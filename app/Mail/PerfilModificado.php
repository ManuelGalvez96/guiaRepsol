<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PerfilModificado extends Mailable
{
    use Queueable, SerializesModels;

    public User $usuario;
    public string $cambios;

    /**
     * Create a new message instance.
     */
    public function __construct(User $usuario, string $cambios)
    {
        $this->usuario = $usuario;
        $this->cambios = $cambios;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tu perfil ha sido modificado',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.perfil_modificado',
            with: [
                'usuario' => $this->usuario,
                'cambios' => $this->cambios,
            ]
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
