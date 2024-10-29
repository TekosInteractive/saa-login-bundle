<?php

namespace TekosInteractive\SaaLoginBundle\Action\Auth\Dtos;

use TekosInteractive\SaaCoreBundle\Domain\Interfaces\Dtos\InputDtoInterface;

class LogoutInput implements InputDtoInterface
{
    public function __construct(
        public string $token
    ) {
    }
}
