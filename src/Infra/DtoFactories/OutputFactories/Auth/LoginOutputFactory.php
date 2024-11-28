<?php

namespace TekosInteractive\SaaLoginBundle\Infra\DtoFactories\OutputFactories\Auth;

use TekosInteractive\SaaLoginBundle\Action\Auth\Dtos\LoginOutput;
use TekosInteractive\SaaCoreBundle\Infra\DtoFactories\OutputFactories\OutputFactoryInterface;

class LoginOutputFactory implements OutputFactoryInterface
{
    public function generateFromObjectOrArray(mixed $objects): LoginOutput
    {
        return new LoginOutput($objects->token);
    }

    public static function supportedOutput(): string
    {
        return LoginOutput::class;
    }
}
