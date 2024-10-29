<?php

namespace TekosInteractive\SaaLoginBundle\Action\Auth\Dtos;

use TekosInteractive\SaaCoreBundle\Domain\Interfaces\Dtos\InputDtoInterface;

class ForgotPasswordInput implements InputDtoInterface
{
    public function __construct(
        public string $email
    ) {
    }
}
