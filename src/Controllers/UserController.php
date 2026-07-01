<?php
namespace App\Controllers;

use App\View;
use App\Attributes\get;
use App\Attributes\post;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Address;

class UserController
{
    // public function __construct(protected MailerInterface $mailer)
    // {
    // }
    #[get('/users/create')]
    public function create(): View
    {
        return View::make('Users/registor');
    }

    #[post('/users/registor')]
    public function registor()
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $firstName = explode(' ', $name)[0];

        $text = <<<Body
        Hello $firstName,
        Thank you for signing up!
        Body;


        $html = <<<HtmlBody
        <h1 style="text-align: center; color: blue;">Welcome</h1>
        Hello $firstName,
        <br />
        Thank you for signing up!
        HtmlBody;
//change
        (new \App\Modals\Email())->queue(
            new Address($email),
            new Address('support@example.com', 'Support'),
            'Welcome',
            $text,
            $html
        );

        //  $email = (new Email())
        //      ->from('support@example.com')
        //      ->to($email)
        //      ->subject('welcome!')
        //      ->attach('Hello World!', 'welcome.txt')
        //      ->text($text)
        //      ->html($html);

        //   $dsn = 'smtp://mailhog:1025'; 
//
        //   $transport = Transport::fromDsn($dsn);
//
        //   $mailer = new Mailer($transport);
        // $this->mailer->send($email);
    }
}