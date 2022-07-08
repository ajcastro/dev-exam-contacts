<?php

namespace App\Jobs;

use App\Models\Contact;
use App\Notifications\GreetingNotification;
use App\Services\Greeter\GreeterInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class SendRandomGreetingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(GreeterInterface $greeter)
    {
        $contacts = Contact::get();

        $message = $greeter->getMessage();

        Notification::send($contacts, new GreetingNotification($message));
    }
}
