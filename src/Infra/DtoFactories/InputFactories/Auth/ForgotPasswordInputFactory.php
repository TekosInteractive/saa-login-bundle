<?php

namespace TekosInteractive\SaaLoginBundle\Infra\DtoFactories\InputFactories\Auth;

use TekosInteractive\SaaCoreBundle\Infra\DtoFactories\InputFactories\InputFactoryInterface;
use TekosInteractive\SaaLoginBundle\Action\Auth\Dtos\ForgotPasswordInput;
use TekosInteractive\SaaCoreBundle\Infra\DtoFactories\InputFactories\AbstractInputFactory;

class ForgotPasswordInputFactory extends AbstractInputFactory implements InputFactoryInterface
{
    public static function supportedInput(): string
    {
        return ForgotPasswordInput::class;
    }

    public function supportedRouteName(): string
    {
        return 'api_auth_forgot_password';
    }
}
