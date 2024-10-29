<?php

namespace TekosInteractive\SaaLoginBundle\Action\Auth\Dtos;

use TekosInteractive\SaaCoreBundle\Domain\Interfaces\Dtos\OutputDtoInterface;
use TekosInteractive\SaaUserBundle\Domain\Enums\EntityType;

class ShowProfileOutput implements OutputDtoInterface
{
    public string $type;

    public function __construct(
        public string $id,
        public array $attributes,
        public array $relationships
    ) {
        $this->type = EntityType::User->value;
    }
}
