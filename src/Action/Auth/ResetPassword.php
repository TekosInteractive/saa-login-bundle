<?php

namespace TekosInteractive\SaaLoginBundle\Action\Auth;

use TekosInteractive\SaaLoginBundle\Action\Auth\Dtos\ResetPasswordInput;
use TekosInteractive\SaaLoginBundle\Domain\Interfaces\Auth\ResetPasswordInputHandlerInterface;
use TekosInteractive\SaaCoreBundle\Domain\Payloads\Payload;

class ResetPassword
{
    public function __construct(
        private readonly ResetPasswordInputHandlerInterface $inputHandler
    ) {
    }

    public function __invoke(ResetPasswordInput $input): Payload
    {
        return $this->inputHandler->handle($input);
    }
}
