<?php

namespace TekosInteractive\SaaLoginBundle\Action\Auth\Dtos;

use TekosInteractive\SaaCoreBundle\Domain\Interfaces\Dtos\InputDtoInterface;

class ResetPasswordInput implements InputDtoInterface
{
    public function __construct(
        public ?string $resetToken,
        public ?string $password
    ) {
    }
}
