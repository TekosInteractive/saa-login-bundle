<?php

namespace TekosInteractive\SaaLoginBundle\Infra\DtoFactories\InputFactories\Auth;

use TekosInteractive\SaaCoreBundle\Infra\DtoFactories\InputFactories\InputFactoryInterface;
use TekosInteractive\SaaLoginBundle\Action\Auth\Dtos\LogoutInput;
use TekosInteractive\SaaCoreBundle\Infra\DtoFactories\InputFactories\AbstractInputFactory;

class LogoutInputFactory extends AbstractInputFactory implements InputFactoryInterface
{
    public function getOtherAttributes(): array
    {
        $jwt = $this->getAccessToken();

        return [
            'token' => $jwt,
        ];
    }

    public static function supportedInput(): string
    {
        return LogoutInput::class;
    }

    public function supportedRouteName(): string
    {
        return 'api_auth_management_logout';
    }
}
