<?php

declare(strict_types=1);

namespace TekosInteractive\SaaLoginBundle\Tests;

use PHPUnit\Framework\TestCase;
use TekosInteractive\SaaLoginBundle\DependencyInjection\TekosInteractiveSaaLoginExtension;
use TekosInteractive\SaaLoginBundle\TekosInteractiveSaaLoginBundle;

/**
 * Description: Unit Test for Saa User bundle
 *
 */
class TekosInteractiveSaaLoginBundleTest extends TestCase
{
    public function testGetContainerExtension(): void
    {
        // Given
        $bundle = new TekosInteractiveSaaLoginBundle();

        // Then
        $this->assertInstanceOf(
            TekosInteractiveSaaLoginExtension::class,
            $bundle->getContainerExtension()
        );
    }
}
