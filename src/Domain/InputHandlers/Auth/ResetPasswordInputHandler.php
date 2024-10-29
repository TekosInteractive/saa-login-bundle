<?php

namespace TekosInteractive\SaaLoginBundle\Domain\InputHandlers\Auth;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;
use TekosInteractive\SaaCoreBundle\Domain\Enums\PayloadStatus;
use TekosInteractive\SaaCoreBundle\Domain\Exceptions\NotFoundException;
use TekosInteractive\SaaCoreBundle\Domain\Exceptions\ValidationException;
use TekosInteractive\SaaCoreBundle\Domain\Payloads\Payload;
use TekosInteractive\SaaLoginBundle\Action\Auth\Dtos\ResetPasswordInput;
use TekosInteractive\SaaLoginBundle\Action\Auth\Dtos\ResetPasswordOutput;
use TekosInteractive\SaaLoginBundle\Domain\Enums\EntityType;
use TekosInteractive\SaaCoreBundle\Domain\Interfaces\Dtos\InputDtoInterface;
use TekosInteractive\SaaLoginBundle\Domain\Interfaces\Auth\ResetPasswordInputHandlerInterface;
use TekosInteractive\SaaCoreBundle\Domain\OutputFactories\OutputFactoryProviderInterface;
use TekosInteractive\SaaUserBundle\Domain\Entities\User;
use TekosInteractive\SaaUserBundle\Domain\Interfaces\User\UserCommandRepositoryInterface;

class ResetPasswordInputHandler implements ResetPasswordInputHandlerInterface
{
    protected string $entityType;
    protected string $outputClass;

    public function __construct(
        private ResetPasswordHelperInterface $helper,
        private UserCommandRepositoryInterface $userCommandRepository,
        private UserPasswordHasherInterface $passwordHasher,
        protected OutputFactoryProviderInterface $outputFactoryProvider
    ) {
        $this->entityType = EntityType::Auth->value;
        $this->outputClass = ResetPasswordOutput::class;
    }

    /**
     * @throws ResetPasswordExceptionInterface
     * @throws NotFoundException
     */
    public function handle(InputDtoInterface $inputDto): Payload
    {
        /** @var ResetPasswordInput $inputDto */
        $userFromToken = $this->helper
            ->validateTokenAndFetchUser(
                $inputDto->resetToken
            );

        /** @var User|null $user */
        $user = $this->userCommandRepository->find($userFromToken->getId());

        if (!$user instanceof User) {
            throw new NotFoundException(key: 'user');
        }

        $userCredential = $user->getUserCredential();
        $hashedPassword = $this->passwordHasher->hashPassword($userCredential, $inputDto->password);
        $userCredential->setPassword($hashedPassword);
        $user->setUserIdentity($userCredential);

        $this->userCommandRepository
            ->save($user)
            ->flush();

        $this->helper->removeResetRequest($inputDto->resetToken);

        return new Payload(
            PayloadStatus::OK,
            []
        );
    }

    /**
     * @throws ValidationException
     */
    public function validateInput(InputDtoInterface $inputDto): void
    {
        if (empty($inputDto->usernameOrEmail)) {
            throw new ValidationException('required', 'resetToken');
        }

        if (empty($inputDto->password)) {
            throw new ValidationException('required', 'password');
        }
    }
}
