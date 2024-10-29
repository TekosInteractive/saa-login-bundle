<?php

namespace TekosInteractive\SaaLoginBundle\Infra\DtoFactories\OutputFactories\Auth;

use TekosInteractive\SaaCoreBundle\Infra\DtoFactories\OutputFactories\OutputFactoryInterface;
use TekosInteractive\SaaLoginBundle\Action\Auth\Dtos\ShowProfileOutput;

class ShowProfileOutputFactory implements OutputFactoryInterface
{
    public function generateFromObjectOrArray(mixed $objects): ShowProfileOutput
    {
        return new ShowProfileOutput(
            id: $objects->id,
            attributes: [
                'email' => $objects->email,
                'username' => $objects->username,
                'firstName' => $objects->firstName,
                'lastName' => $objects->lastName,
                'nickname' => $objects->nickname,
                'birthday' => $objects->birthday,
                'headline' => $objects->headline,
                'avatar' => $objects->avatar,
                'locale' => $objects->locale,
            ],
            relationships: $objects->relationships
        );
    }

    public static function supportedOutput(): string
    {
        return ShowProfileOutput::class;
    }
}
