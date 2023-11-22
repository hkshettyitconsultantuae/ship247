<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingCreated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public Booking $booking, public float $addonAmount = 0)
    {
        $addonAmount = 0;
        foreach ($this->booking->addons as $addon) {
            if ($addon->type === "toggle" && is_numeric($addon->value)) {
                $addonAmount += intval($addon->value);
            } else if ($addon->value > 0 && $addon->type === "counter") {
                if($addon->step) {
                    $addonAmount += floatval($addon->value) * floatval($addon->step);
                } else {
                    $addonAmount += floatval($addon->value);
                }
            }
        }
        $this->addonAmount = $addonAmount;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Booking Created Successfully!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.booking-created',
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
