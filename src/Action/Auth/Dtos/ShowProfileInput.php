<?php

namespace TekosInteractive\SaaLoginBundle\Action\Auth\Dtos;

use TekosInteractive\SaaCoreBundle\Domain\Interfaces\Dtos\InputDtoInterface;
use TekosInteractive\SaaCoreBundle\Infra\ValueObjects\Uuid\Uuid;

class ShowProfileInput implements InputDtoInterface
{
    public function __construct(
        public Uuid $id
    ) {
    }
}
