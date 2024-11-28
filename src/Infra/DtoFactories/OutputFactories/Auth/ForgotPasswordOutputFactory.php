<?php

namespace TekosInteractive\SaaLoginBundle\Infra\DtoFactories\OutputFactories\Auth;

use TekosInteractive\SaaLoginBundle\Action\Auth\Dtos\ForgotPasswordOutput;
use TekosInteractive\SaaCoreBundle\Infra\DtoFactories\OutputFactories\OutputFactoryInterface;

class ForgotPasswordOutputFactory implements OutputFactoryInterface
{
    public function generateFromObjectOrArray(mixed $objects): ForgotPasswordOutput
    {
        return new ForgotPasswordOutput();
    }

    public static function supportedOutput(): string
    {
        return ForgotPasswordOutput::class;
    }
}
