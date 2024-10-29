<?php

declare(strict_types=1);

namespace TekosInteractive\SaaLoginBundle\Infra\Security\Handler;

use TekosInteractive\SaaUserBundle\Domain\Interfaces\AccessTokenSession\AccessTokenSessionCommandRepositoryInterface;
use  TekosInteractive\SaaUserBundle\Domain\Interfaces\User\UserCommandRepositoryInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use  TekosInteractive\SaaUserBundle\Domain\Entities\AccessTokenSession;

readonly class VerifyAccessToken implements AccessTokenHandlerInterface
{
    public function __construct(
        private UserCommandRepositoryInterface $userCommandRepository,
        private AccessTokenSessionCommandRepositoryInterface $accessTokenCommandRepository,
    ) {
    }

    public function getUserBadgeFrom(#[\SensitiveParameter] string $accessToken): UserBadge
    {
        if (empty($accessToken)) {
            throw new BadCredentialsException('invalid_credentials');
        }

        /** @var AccessTokenSession|null $accessToken */
        $accessToken = $this->accessTokenCommandRepository->findOneBy(['jwt' => $accessToken]);

        if (!$accessToken instanceof AccessTokenSession || false === $accessToken->isValid()) {
            throw new BadCredentialsException('invalid_credentials');
        }

        return new UserBadge($accessToken->getUser()->getUserCredential()->getEmail());
    }
}
