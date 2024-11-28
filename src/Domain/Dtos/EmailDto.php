<?php

namespace TekosInteractive\SaaLoginBundle\Domain\Dtos;

class EmailDto
{
    public function __construct(
        public ?string $subject,
        public ?string $senderAddress,
        public ?string $receiverAddress,
        public ?string $senderName = '',
        public ?string $receiverName = '',
        public ?int $template = null,
        public ?array $context = []
    ) {
    }
}
