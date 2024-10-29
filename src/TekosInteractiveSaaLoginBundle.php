<?php

declare(strict_types=1);

namespace TekosInteractive\SaaLoginBundle;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use TekosInteractive\SaaLoginBundle\DependencyInjection\TekosInteractiveSaaLoginExtension;

class TekosInteractiveSaaLoginBundle extends AbstractBundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        if (null === $this->extension) {
            $this->extension = new TekosInteractiveSaaLoginExtension();
        }

        return $this->extension ?: null;
    }
}
