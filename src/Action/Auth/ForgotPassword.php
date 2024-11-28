<?php

namespace TekosInteractive\SaaLoginBundle\Action\Auth;

use TekosInteractive\SaaLoginBundle\Action\Auth\Dtos\ForgotPasswordInput;
use TekosInteractive\SaaLoginBundle\Domain\Interfaces\Auth\ForgotPasswordInputHandlerInterface;
use TekosInteractive\SaaCoreBundle\Domain\Payloads\Payload;

class ForgotPassword
{
    public function __construct(
        private readonly ForgotPasswordInputHandlerInterface $inputHandler
    ) {
    }

    public function __invoke(ForgotPasswordInput $input): Payload
    {
        return $this->inputHandler->handle($input);
    }
}
