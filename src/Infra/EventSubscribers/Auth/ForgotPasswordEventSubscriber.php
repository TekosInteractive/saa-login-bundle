<?php

namespace TekosInteractive\SaaLoginBundle\Infra\EventSubscribers\Auth;

use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;
use TekosInteractive\SaaLoginBundle\Domain\Dtos\EmailDto;
use TekosInteractive\SaaLoginBundle\Infra\Events\Auth\ForgotPassword;
use TekosInteractive\SaaLoginBundle\Infra\Providers\MailerProvider;

class ForgotPasswordEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly MailerProvider $mailerProvider,
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly ResetPasswordHelperInterface $resetPasswordHelper,
        private readonly ParameterBagInterface $params
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ForgotPassword::NAME => 'onRegistered'
        ];
    }

    /**
     * @throws ResetPasswordExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function onRegistered(ForgotPassword $event): void
    {
        $user = $event->getUser();
        $userCredential = $user->getUserCredential();
        $userIdentity = $user->getUserIdentity();
        $resetToken = $this->resetPasswordHelper->generateResetToken($userCredential);

        $this->mailerProvider->send(
            new EmailDto(
                subject: $this->params->get('mail.reset_password.subject'),
                senderAddress: $this->params->get('app.mail_from'),
                receiverAddress: $userCredential->getEmail(),
                receiverName: $userIdentity->getFirstName(),
                template: $this->params->get('mail.reset_password.template'),
                context: [
                    'appName' => $this->params->get('app.name'),
                    'resetLink' => $this->urlGenerator->generate(
                        $this->params->get('app.front.reset_password'),
                        ['token' => $resetToken->getToken()],
                        UrlGeneratorInterface::ABSOLUTE_URL
                    )
                ],
            )
        );
    }
}
