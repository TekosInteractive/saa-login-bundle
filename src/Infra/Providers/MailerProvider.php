<?php

namespace TekosInteractive\SaaLoginBundle\Infra\Providers;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use TekosInteractive\SaaLoginBundle\Domain\Dtos\EmailDto;

class MailerProvider
{
    const TWIG = 'twig';
    const TEXT = 'emailTemplate';
    const PARAMS = 'params';

    const TEMPLATE_ID = 'templateId';

    public function __construct(
        private readonly MailerInterface $mailer
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function send(EmailDto $email): void
    {
        if (empty($email->senderAddress)) {
            throw new UnprocessableEntityHttpException(
                json_encode([
                    'default' => 'invalid_sender'
                ])
            );
        }

        if (empty($email->receiverAddress)) {
            throw new UnprocessableEntityHttpException(
                json_encode([
                    'default' => 'invalid_receiver'
                ])
            );
        }

        $templatedEmail = (str_contains($email->template, self::TWIG))
            ? $this->sendEmailWithTwigTemplate($email)
            : $this->sendEmailWithIdTemplate($email);

        if ($email->senderAddress != '') {
            $templatedEmail->from(new Address($email->senderAddress, $email->senderName ?? ''));
        }

        if ($email->receiverAddress != '') {
            $templatedEmail->to(new Address($email->receiverAddress, $email->receiverName ?? ''));
        }

        $this->mailer->send($templatedEmail);
    }

    protected function sendEmailWithTwigTemplate(EmailDto $email): TemplatedEmail
    {
        $templatedEmail = new TemplatedEmail();
        $templatedEmail
            ->subject($email->subject)
            ->htmlTemplate($email->template)
            ->context($email->context);

        return $templatedEmail;
    }

    protected function sendEmailWithIdTemplate(EmailDto $email): Email
    {
        $templatedEmail = new Email();

        $templatedEmail
            ->subject($email->subject)
            ->text(self::TEXT)
            ->getHeaders()
            ->addTextHeader(self::TEMPLATE_ID, $email->template)
            ->addParameterizedHeader(self::PARAMS, self::PARAMS, $email->context);

        return $templatedEmail;
    }
}
