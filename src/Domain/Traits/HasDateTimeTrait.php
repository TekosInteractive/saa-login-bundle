<?php

namespace TekosInteractive\SaaLoginBundle\Domain\Traits;

use DateTimeImmutable;
use DateTimeZone;
use Exception;

/**
 * @codeCoverageIgnore
 */
trait HasDateTimeTrait
{
    /**
     * @throws Exception
     */
    protected function toNowUtcDateTime(): DateTimeImmutable
    {
        return new DateTimeImmutable('now', new DateTimeZone('UTC'));
    }
}
