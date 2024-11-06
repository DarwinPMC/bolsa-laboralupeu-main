<?php

namespace App\Mail;

use App\Models\Oferta;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;  // Importa la clase Address

class InvitacionOferta extends Mailable
{
    use Queueable, SerializesModels;

    public $oferta;
    public $nombreUsuario;
    public $correoRemitente;
    public $urlOferta;

    /**
     * Crear una nueva instancia de InvitacionOferta.
     *
     * @param  \App\Models\Oferta  $oferta
     * @param  string  $nombreUsuario
     * @param  string  $correoRemitente
     * @return void
     */
    public function __construct(Oferta $oferta, $nombreUsuario, $correoRemitente)
    {
        $this->oferta = $oferta;
        $this->nombreUsuario = $nombreUsuario;
        $this->correoRemitente = $correoRemitente;

        // Generar la URL de la oferta para pasarla a la vista
        $this->urlOferta = route('ofertas.show', ['oferta' => $oferta->id]);
    }

    /**
     * Definir el sobre del correo (de dónde viene el correo, el asunto, etc.).
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new \Illuminate\Mail\Mailables\Envelope(
            from: new Address($this->correoRemitente, config('app.name')),  // Usa Address aquí
            subject: 'Invitación a la oferta laboral: ' . $this->oferta->titulo
        );
    }

    /**
     * Definir el contenido del correo electrónico.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new \Illuminate\Mail\Mailables\Content(
            view: 'emails.invitacion_oferta',
            with: [
                'nombreUsuario' => $this->nombreUsuario,
                'oferta' => $this->oferta,
                'urlOferta' => $this->urlOferta, // Asegurarse de pasar la URL de la oferta
            ],
        );
    }

    /**
     * Obtener los archivos adjuntos para el mensaje.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}

