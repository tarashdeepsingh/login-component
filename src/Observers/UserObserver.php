<?php

namespace Avalon\LrvLogin\LoginComponent\Observers;

use Avalon\LrvLogin\LoginComponent\Services\EmailService;
use App\Models\User;

class UserObserver
{
    protected $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    public function created(User $user)
    {
        $this->emailService->sendEmail([
            'email_from' => env('MAIL_FROM_ADDRESS', 'no-reply@example.org'),
            'email_to' => $user->email,
            'email_subject' => $userData['subject'],
            'email_content' => $userData['content']
        ]);
    }
}
