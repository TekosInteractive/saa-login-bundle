<?php

namespace TekosInteractive\SaaLoginBundle\Infra\DtoFactories\InputFactories\Auth;

use TekosInteractive\SaaCoreBundle\Infra\DtoFactories\InputFactories\InputFactoryInterface;
use TekosInteractive\SaaLoginBundle\Action\Auth\Dtos\ResetPasswordInput;
use TekosInteractive\SaaCoreBundle\Infra\DtoFactories\InputFactories\AbstractInputFactory;

class ResetPasswordInputFactory extends AbstractInputFactory implements InputFactoryInterface
{
    public static function supportedInput(): string
    {
        return ResetPasswordInput::class;
    }

    public function supportedRouteName(): string
    {
        return 'api_auth_reset_password';
    }
}
