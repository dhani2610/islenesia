<?php

namespace App\Mail;

use App\Models\Inquiry;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InquiryAdminNotification extends Mailable
{
    use Queueable, SerializesModels;

    public Inquiry $inquiry;

    /**
     * Create a new message instance.
     */
    public function __construct(Inquiry $inquiry)
    {
        $this->inquiry = $inquiry;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $siteName = Setting::get('site_name', 'Islenesia');
        $roleTitle = strtoupper($this->inquiry->type === 'pemasok' ? 'Pemasok' : 'Buyer');
        $commodity = $this->inquiry->product ? $this->inquiry->product->name : ($this->inquiry->subject ?: 'Komoditas Umum');

        return new Envelope(
            subject: "[Inquiry #{$this->inquiry->id}] {$roleTitle}: {$this->inquiry->name} - {$commodity}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.inquiry_admin',
            with: [
                'inquiry' => $this->inquiry,
                'siteSettings' => Setting::allMap(),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
