<?php

namespace TekosInteractive\SaaLoginBundle\Action\Auth;

use TekosInteractive\SaaLoginBundle\Action\Auth\Dtos\LoginInput;
use TekosInteractive\SaaLoginBundle\Domain\Interfaces\Auth\LoginInputHandlerInterface;
use TekosInteractive\SaaCoreBundle\Domain\Payloads\Payload;

class Login
{
    public function __construct(
        private readonly LoginInputHandlerInterface $inputHandler
    ) {
    }

    public function __invoke(LoginInput $input): Payload
    {
        return $this->inputHandler->handle($input);
    }
}
