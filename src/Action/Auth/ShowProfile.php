<?php

namespace TekosInteractive\SaaLoginBundle\Action\Auth;

use TekosInteractive\SaaCoreBundle\Domain\Payloads\Payload;
use TekosInteractive\SaaLoginBundle\Action\Auth\Dtos\ShowProfileInput;
use TekosInteractive\SaaLoginBundle\Domain\Interfaces\Auth\ShowProfileInputHandlerInterface;

class ShowProfile
{
    public function __construct(
        private readonly ShowProfileInputHandlerInterface $inputHandler
    ) {
    }

    public function __invoke(ShowProfileInput $input): Payload
    {
        return $this->inputHandler->handle($input);
    }
}
