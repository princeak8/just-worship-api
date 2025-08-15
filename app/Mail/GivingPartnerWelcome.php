<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use App\Models\GivingPartner;
use App\Models\BankAccount;
use App\Models\OnlineAccount;

use App\Utilities;

class GivingPartnerWelcome extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $givingPartner;

    /**
     * Create a new message instance.
     */
    public function __construct(GivingPartner $givingPartner)
    {
        $this->givingPartner = $givingPartner;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Thank you for partnering with us!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $bankAccounts = BankAccount::all();
        $onlineAccounts = OnlineAccount::all();

        if($onlineAccounts->count() > 0) {
            foreach($onlineAccounts as $account) {
                $account->qrCodePhoto;
                // Generate QR code as PNG binary
                $qrCode = QrCode::format('png')->size(200)->generate($account->url);

                // Encode to base64 so it can be embedded inline in email HTML
                $account->qrCodeBase64 = base64_encode($qrCode);
                Utilities::logStuff(base64_encode($qrCode));
            }
        }
        Utilities::logStuff($onlineAccounts);

        return new Content(
            view: 'emails.giving-partner-welcome',
            with: [
                "partner" =>  $this->givingPartner,
                "bankAccounts" => $bankAccounts,
                "onlineAccounts" => $onlineAccounts
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
