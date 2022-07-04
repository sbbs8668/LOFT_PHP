<?php
namespace Src;

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

trait Mailsender
{
  /**
   * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
   */
  protected function sendEmail($mail, $subject, $message): void
  {
    $conf = trim(file_get_contents(__DIR__.'/config/mail.txt'));
    $transport = Transport::fromDsn($conf);

    $mailer = new Mailer($transport);
    $email = (new Email())
      ->from('loftphp@rambler.ru')
      ->to($mail)
      ->subject($subject)
      ->text($message)
      ->html("<p>$message</p>");
    $mailer->send($email);
  }
}
