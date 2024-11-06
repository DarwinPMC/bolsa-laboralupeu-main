<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;
use App\Models\Postulacion;
use App\Models\CorreoEnviado; // Asegúrate de importar el modelo


class PostulacionAceptadaMail extends Mailable
{
    use SerializesModels;

    public $postulacion;
    public $correoRemitente;

    /**
     * Create a new message instance.
     *
     * @param Postulacion $postulacion
     * @param string $correoRemitente
     */
    public function __construct(Postulacion $postulacion, $correoRemitente, CorreoEnviado $correo)
    {
        $this->postulacion = $postulacion;
        $this->correoRemitente = $correoRemitente;
        $this->correo = $correo;  // Asegúrate de que el correo se asigna correctamente
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address($this->correoRemitente, ''), // Usar Address en lugar de un array
            subject: 'Tu postulación ha sido aceptada',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.postulacion_aceptada',
            with: [
                'nombre' => $this->postulacion->usuario->name,
                'oferta' => $this->postulacion->oferta->titulo,
                'correo' => $this->correo // Pasar el correo enviado

            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
