<?php

namespace App\Observers;

use App\Mail\GivingPartnerWelcome;
use App\Models\GivingPartner;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Jobs\SendGivingPartnerWelcomeEmail;

class GivingPartnerObserver
{

    public function created(GivingPartner $givingPartner)
    {
        // Send welcome email
        // Mail::to($givingPartner->email)->send(new GivingPartnerWelcome($givingPartner));
        
        // You could also trigger other events here like:
        // - Slack notifications to admin
        // - SMS notifications
        // - Adding to mailing list
        // - Creating follow-up tasks

        try {
            // Dispatch job to queue for better performance and error handling
            SendGivingPartnerWelcomeEmail::dispatch($givingPartner);
            
            Log::info('Welcome email job dispatched for giving partner', [
                'partner_id' => $givingPartner->id,
                'email' => $givingPartner->email
            ]);
            
        } catch (\Exception $e) {
            // Log the error but don't fail the creation
            Log::error('Failed to dispatch welcome email job for giving partner', [
                'partner_id' => $givingPartner->id,
                'email' => $givingPartner->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Optionally notify admins
            // $this->notifyAdminsOfEmailFailure($givingPartner, $e);
        }
    }

    public function updated(GivingPartner $givingPartner)
    {
        // Handle updates if needed
        try {
            // Handle updates if needed
            if ($givingPartner->wasChanged(['amount', 'recurrent_type'])) {
                Log::info('Giving partner updated', [
                    'partner_id' => $givingPartner->id,
                    'changes' => $givingPartner->getChanges()
                ]);
                
                // You could dispatch update notification job here
                // SendGivingPartnerUpdateEmail::dispatch($givingPartner);
            }
        } catch (\Exception $e) {
            Log::error('Error in giving partner updated observer', [
                'partner_id' => $givingPartner->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    private function notifyAdminsOfEmailFailure(GivingPartner $givingPartner, \Exception $e)
    {
        try {
            // Send notification to admins about email failure
            // You could use Slack, email, or any other notification method
            
            $adminEmails = config('mail.admin_emails', ['admin@yourchurch.com']);
            
            foreach ($adminEmails as $adminEmail) {
                \Mail::to($adminEmail)->send(new \App\Mail\AdminNotification([
                    'subject' => 'Failed to send welcome email to giving partner',
                    'message' => "Failed to send welcome email to {$givingPartner->full_name} ({$givingPartner->email})",
                    'error' => $e->getMessage(),
                    'partner_id' => $givingPartner->id
                ]));
            }
        } catch (\Exception $notificationError) {
            Log::error('Failed to notify admins of email failure', [
                'original_error' => $e->getMessage(),
                'notification_error' => $notificationError->getMessage()
            ]);
        }
    }
}
