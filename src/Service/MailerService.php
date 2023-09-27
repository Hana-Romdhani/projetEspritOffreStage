<?php 
namespace App\Service;

use PhpParser\Builder\Function_;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;

use Symfony\Component\Mime\Email;
Class MailerService
{   public function __construct(MailerInterface $mailer){

    
}
    public function sendEmail():void 
    {
        $email = (new Email())
            ->from('hello@example.com')
            ->to('you@example.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

       $this->$mailer->send($email);

        // ...
    }

}