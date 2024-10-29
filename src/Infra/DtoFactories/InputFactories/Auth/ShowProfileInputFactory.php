<?php

namespace TekosInteractive\SaaLoginBundle\Infra\DtoFactories\InputFactories\Auth;

use TekosInteractive\SaaCoreBundle\Domain\Exceptions\PermissionDeniedException;
use TekosInteractive\SaaCoreBundle\Infra\DtoFactories\InputFactories\InputFactoryInterface;
use TekosInteractive\SaaCoreBundle\Infra\DtoFactories\InputFactories\AbstractInputFactory;
use TekosInteractive\SaaLoginBundle\Action\Auth\Dtos\ShowProfileInput;

class ShowProfileInputFactory extends AbstractInputFactory implements InputFactoryInterface
{
    /**
     * @throws PermissionDeniedException
     */
    public function getOtherAttributes(): array
    {
        $userCredential = $this->getTokenUser();
        $user = $userCredential->getUser();

        return [
            'id' => $user->getId(),
        ];
    }
    public static function supportedInput(): string
    {
        return ShowProfileInput::class;
    }

    public function supportedRouteName(): string
    {
        return 'api_auth_profile';
    }
}
