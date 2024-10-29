<?php

namespace TekosInteractive\SaaLoginBundle\Domain\InputHandlers\Auth;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use TekosInteractive\SaaCoreBundle\Domain\Enums\PayloadStatus;
use TekosInteractive\SaaCoreBundle\Domain\Exceptions\NotFoundException;
use TekosInteractive\SaaCoreBundle\Domain\Exceptions\ValidationException;
use TekosInteractive\SaaCoreBundle\Domain\Interfaces\IsValidatorInterface;
use TekosInteractive\SaaCoreBundle\Domain\Payloads\Payload;
use TekosInteractive\SaaLoginBundle\Action\Auth\Dtos\LoginInput;
use TekosInteractive\SaaLoginBundle\Action\Auth\Dtos\LoginOutput;
use TekosInteractive\SaaLoginBundle\Domain\Enums\EntityType;
use TekosInteractive\SaaCoreBundle\Domain\Interfaces\Dtos\InputDtoInterface;
use TekosInteractive\SaaLoginBundle\Domain\Interfaces\Auth\LoginInputHandlerInterface;
use TekosInteractive\SaaCoreBundle\Domain\OutputFactories\OutputFactoryProviderInterface;
use TekosInteractive\SaaUserBundle\Domain\Entities\AccessTokenSession;
use TekosInteractive\SaaUserBundle\Domain\Entities\User;
use TekosInteractive\SaaUserBundle\Domain\Interfaces\AccessTokenSession\AccessTokenSessionCommandRepositoryInterface;
use TekosInteractive\SaaUserBundle\Domain\Interfaces\User\UserQueryRepositoryInterface;

class LoginInputHandler implements LoginInputHandlerInterface, IsValidatorInterface
{
    const TOKEN = 'token';
    protected string $entityType;
    protected string $outputClass;

    public function __construct(
        protected UserQueryRepositoryInterface $userQueryRepository,
        protected AccessTokenSessionCommandRepositoryInterface $accessTokenSessionCommandRepo,
        protected UserPasswordHasherInterface $passwordHasher,
        protected JWTTokenManagerInterface $jwtTokenManager,
        protected OutputFactoryProviderInterface $outputFactoryProvider,
    ) {
        $this->entityType = EntityType::Auth->value;
        $this->outputClass = LoginOutput::class;
    }

    /**
     * @throws NotFoundException
     */
    public function handle(InputDtoInterface $inputDto): Payload
    {
        /** @var LoginInput $inputDto */
        $user = $this->userQueryRepository->findOneByUsernameOrEmail($inputDto->usernameOrEmail);

        if (!$user instanceof User) {
            throw new NotFoundException(key: 'user');
        }

        $userCredential = $user->getUserCredential();

        if (
            false === $this->passwordHasher->isPasswordValid($userCredential, $inputDto->password)
        ) {
            throw new NotFoundException(key: 'user');
        }

        $jwt = $this->jwtTokenManager->create($userCredential);

        $accessToken = new AccessTokenSession(
            user: $user,
            jwt: $jwt
        );

        $this->accessTokenSessionCommandRepo->save($accessToken)->flush();

        return new Payload(PayloadStatus::OK, [
            self::TOKEN => $jwt
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function validateInput(InputDtoInterface $inputDto): void
    {
        if (empty($inputDto->usernameOrEmail)) {
            throw new ValidationException('required', 'usernameOrEmail');
        }

        if (empty($inputDto->password)) {
            throw new ValidationException('required', 'password');
        }
    }
}
