<?php

namespace TekosInteractive\SaaLoginBundle\Infra\DtoFactories\OutputFactories\Auth;

use TekosInteractive\SaaLoginBundle\Action\Auth\Dtos\LogoutOutput;
use TekosInteractive\SaaCoreBundle\Infra\DtoFactories\OutputFactories\OutputFactoryInterface;

class LogoutOutputFactory implements OutputFactoryInterface
{
    public function generateFromObjectOrArray(mixed $objects): LogoutOutput
    {
        return new LogoutOutput();
    }

    public static function supportedOutput(): string
    {
        return LogoutOutput::class;
    }
}
