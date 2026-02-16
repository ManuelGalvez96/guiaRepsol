<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Restaurante_Eliminado extends Mailable
{
    use Queueable, SerializesModels;

    public $nombre;
    public $restaurante_id;

    /**
     * Create a new message instance.
     */
    public function __construct($nombre, $restaurante_id = null)
    {
        $this->nombre = $nombre;
        $this->restaurante_id = $restaurante_id;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Restaurante Eliminado',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.restaurante_eliminado',
            with: [
                'nombre' => $this->nombre,
                'restaurante_id' => $this->restaurante_id,
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
