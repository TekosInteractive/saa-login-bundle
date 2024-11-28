<?php

namespace TekosInteractive\SaaLoginBundle\Action\Auth\Dtos;

use TekosInteractive\SaaCoreBundle\Domain\Interfaces\Dtos\OutputDtoInterface;

class LoginOutput implements OutputDtoInterface
{
    public function __construct(
        public string $token
    ) {
    }
}
