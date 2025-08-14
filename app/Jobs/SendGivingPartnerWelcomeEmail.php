<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

use App\Mail\GivingPartnerWelcome;
use App\Models\GivingPartner;

class SendGivingPartnerWelcomeEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $givingPartner;
    public $tries = 3; // Retry 3 times if failed
    public $backoff = [60, 300, 900]; // Retry after 1 min, 5 min, 15 min
    /**
     * Create a new job instance.
     */
    public function __construct(GivingPartner $givingPartner)
    {
        $this->givingPartner = $givingPartner;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Mail::to($this->givingPartner->email)
                ->send(new GivingPartnerWelcome($this->givingPartner));
                
            Log::info('Welcome email sent successfully', [
                'partner_id' => $this->givingPartner->id,
                'email' => $this->givingPartner->email
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to send welcome email', [
                'partner_id' => $this->givingPartner->id,
                'email' => $this->givingPartner->email,
                'error' => $e->getMessage(),
                'attempt' => $this->attempts()
            ]);
            
            throw $e; // Re-throw to trigger retry mechanism
        }
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('Welcome email job failed permanently', [
            'partner_id' => $this->givingPartner->id,
            'email' => $this->givingPartner->email,
            'error' => $exception->getMessage(),
            'attempts' => $this->attempts()
        ]);

        // Notify admins of permanent failure
        // $this->notifyAdminsOfPermanentFailure($exception);
    }

    private function notifyAdminsOfPermanentFailure(\Throwable $exception)
    {
        try {
            $adminEmails = config('mail.admin_emails', ['admin@yourchurch.com']);
            
            foreach ($adminEmails as $adminEmail) {
                // Mail::to($adminEmail)->send(new \App\Mail\AdminNotification([
                //     'subject' => 'Welcome Email Job Failed Permanently',
                //     'message' => "Failed to send welcome email to {$this->givingPartner->full_name} after all retry attempts",
                //     'error' => $exception->getMessage(),
                //     'partner_id' => $this->givingPartner->id
                // ]));
            }
        } catch (\Exception $e) {
            Log::critical('Failed to notify admins of permanent email failure', [
                'original_error' => $exception->getMessage(),
                'notification_error' => $e->getMessage()
            ]);
        }
    }
}
