<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PerfilEliminado extends Mailable
{
    use Queueable, SerializesModels;

    public User $usuario;
    public string $razon;

    /**
     * Create a new message instance.
     */
    public function __construct(User $usuario, $razon = '')
    {
        $this->usuario = $usuario;
        $this->razon = $razon;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tu cuenta ha sido eliminada',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.perfil_eliminado',
            with: [
                'usuario' => $this->usuario,
                'razon' => $this->razon,
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
