<?php

namespace App\Console\Commands;

use App\Mail\sendemail;
use App\Models\ContactUs;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEmailsFromContactUs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:send-contact-us';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send emails for contacts with status 0';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $operator = 1;
        // info("Cron Job running at " . now());
        $contactUs = ContactUs::where('status',0)->get();
        //dd($contactUs);
        foreach ($contactUs as $contact) {
            // Prepare your email data
            $data = [
                'name' => $contact->name,
                'email' => $contact->email,
                'subject' => $contact->subject,
                'message' => $contact->message,
                'attachment' => $contact->attachment,
            ];
            // Admin Email   
            $adminEmail = "muhammadsabeehsafdar394@gmail.com";

            Mail::to($adminEmail)->send(new sendemail($data));
            $contact->status = 1;
            $contact->save();
            $this->info('Summary email sent successfully!');
        }
    }
}
