<?php

namespace TekosInteractive\SaaLoginBundle\Infra\DtoFactories\OutputFactories\Auth;

use TekosInteractive\SaaLoginBundle\Action\Auth\Dtos\ResetPasswordOutput;
use TekosInteractive\SaaCoreBundle\Infra\DtoFactories\OutputFactories\OutputFactoryInterface;

class ResetPasswordOutputFactory implements OutputFactoryInterface
{
    public function generateFromObjectOrArray(mixed $objects): ResetPasswordOutput
    {
        return new ResetPasswordOutput();
    }

    public static function supportedOutput(): string
    {
        return ResetPasswordOutput::class;
    }
}
