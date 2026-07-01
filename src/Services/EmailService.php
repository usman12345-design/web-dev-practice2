<?php
declare(strict_types=1);
namespace App\Services;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email as SymfonyEmail;
use App\Enums\EmailStatus;

class EmailService
{
    //change
  public function __construct(protected \App\Modals\Email $emailModel, protected MailerInterface $mailer)
  {

  }

  public function SendQueuedEmails()
  {
    $emails = $this->emailModel->getEmailByStatus(EmailStatus::Queue);
    foreach ($emails as $email) {
      //$meta = json_decode($email->meta, true);
        // 💡 FIX: No need to json_decode! Eloquent already made $email->meta a native PHP array.
        $meta = $email->meta;
      $emailMessage = (new SymfonyEmail())
        ->from($meta['from'])
        ->to($meta['to'])
        ->subject($email->subject)
        ->text($email->text_body)
        ->html($email->html_body);

      $this->mailer->send($emailMessage);
      $this->emailModel->markEmailSent($email->id);
    }

  }
}