<?php

namespace TekosInteractive\SaaLoginBundle\Infra\DtoFactories\InputFactories\Auth;

use TekosInteractive\SaaCoreBundle\Infra\DtoFactories\InputFactories\InputFactoryInterface;
use TekosInteractive\SaaLoginBundle\Action\Auth\Dtos\LoginInput;
use TekosInteractive\SaaCoreBundle\Infra\DtoFactories\InputFactories\AbstractInputFactory;

class LoginInputFactory extends AbstractInputFactory implements InputFactoryInterface
{
    public static function supportedInput(): string
    {
        return LoginInput::class;
    }

    public function supportedRouteName(): string
    {
        return 'api_auth_management_login';
    }
}
