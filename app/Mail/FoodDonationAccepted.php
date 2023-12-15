<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\FoodDonation;

class FoodDonationAccepted extends Mailable
{
    use Queueable, SerializesModels;

    public $foodDonation;

    public function __construct(FoodDonation $foodDonation)
    {
        $this->foodDonation = $foodDonation;
    }

    public function build()
    {
        return $this->markdown('emails.food_donation_accepted')
                    ->subject('Food Donation Accepted');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Food Donation Accepted',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.food_donation_accepted',
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
