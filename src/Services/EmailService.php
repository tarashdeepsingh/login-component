<?php

namespace Avalon\LrvLogin\Services;
use Illuminate\Support\Facades\Http;

class EmailService
{
    protected $emailServiceUrl;

    public function __construct()
    {
        $this->emailServiceUrl = config('custom_login.email_service_url', 'https://service-discovery.dataforall.org/v1/catalog/service/dfa_mailer');
    }

    public function sendEmail($emailTo, $emailFrom, $subject, $content)
    {
        return Http::post("{$this->emailServiceUrl}/send-email", [
            'email_to' => $emailTo,
            'email_from' => $emailFrom,
            'email_subject' => $subject,
            'email_content' => $content,
        ])->successful();
    }
}
