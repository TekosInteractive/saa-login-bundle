<?php

namespace TekosInteractive\SaaLoginBundle\Action\Auth;

use TekosInteractive\SaaLoginBundle\Action\Auth\Dtos\LogoutInput;
use TekosInteractive\SaaLoginBundle\Domain\Interfaces\Auth\LogoutInputHandlerInterface;
use TekosInteractive\SaaCoreBundle\Domain\Payloads\Payload;

class Logout
{
    public function __construct(
        private readonly LogoutInputHandlerInterface $inputHandler
    ) {
    }

    public function __invoke(LogoutInput $input): Payload
    {
        return $this->inputHandler->handle($input);
    }
}
