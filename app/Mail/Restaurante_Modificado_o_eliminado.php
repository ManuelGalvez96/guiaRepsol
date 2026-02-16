<?php

namespace App\Mail;

use App\Models\Restaurante;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Restaurante_Modificado_o_eliminado extends Mailable
{
    use Queueable, SerializesModels;

    public Restaurante $restaurante;

    /**
     * Create a new message instance.
     */
    public function __construct(Restaurante $restaurante)
    {
        $this->restaurante = $restaurante;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Restaurante Modificado',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.restaurante_modificado_o_eliminado',
            with: [
                'restaurante' => $this->restaurante,
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
