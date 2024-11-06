<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage; // Importar Storage para manejar archivos

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, mixed>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'dni' => ['nullable', 'digits:8', 'numeric', 'required_if:rol,postulante'],  // Validación para DNI
            'ruc' => ['nullable', 'digits:11', 'numeric', 'required_if:rol,empresa'],  // Validación para RUC
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'correo' => ['nullable', 'string', 'email', 'max:255'],  // Validación para correo alternativo
            'celular' => ['nullable', 'string', 'max:15'],  // Validación para celular
            'rol' => ['required', Rule::in(['admin', 'empresa', 'postulante', 'supervisor'])],  // Validación para rol
            'archivo_cv' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:2048'],  // Validación para archivo CV
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],  // Validación para foto de perfil
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        // Crear usuario primero sin archivo de CV ni foto de perfil
        $user = User::create([
            'name' => $input['name'],
            'dni' => $input['dni'] ?? null,
            'ruc' => $input['ruc'] ?? null,
            'email' => $input['email'],
            'correo' => $input['correo'] ?? null,
            'celular' => $input['celular'] ?? null,
            'rol' => $input['rol'],
            'is_approved' => 0, // No aprobado por defecto
            'password' => Hash::make($input['password']),
        ]);
        $user->assignRole($input['rol']);  // Esto asignará el rol a partir del input

        // Si se sube un archivo CV, guardar el archivo y actualizar el usuario
        if (isset($input['archivo_cv'])) {
            $path = $input['archivo_cv']->store('cv', 'public');
            $user->archivo_cv = $path;
        }

        // Si se sube una foto de perfil, guardar la foto y actualizar el usuario
        if (isset($input['profile_photo'])) {
            $photoPath = $input['profile_photo']->store('profile_photos', 'public');
            $user->profile_photo_path = $photoPath;
        }

        $user->save();

        return $user;
    }

    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array
     */
    protected function passwordRules()
    {
        return ['required', 'string', 'min:8', 'confirmed'];  // Cambia según tus necesidades de validación de contraseña
    }
    public function boot()
{
    Fortify::createUsersUsing(CreateNewUser::class);
}
}
