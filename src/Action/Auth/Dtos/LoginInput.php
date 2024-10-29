<?php

namespace TekosInteractive\SaaLoginBundle\Action\Auth\Dtos;

use TekosInteractive\SaaCoreBundle\Domain\Interfaces\Dtos\InputDtoInterface;

class LoginInput implements InputDtoInterface
{
    public function __construct(
        public string $usernameOrEmail,
        public string $password
    ) {
    }
}
