<?php

namespace TekosInteractive\SaaLoginBundle\Domain\InputHandlers\Auth;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use TekosInteractive\SaaCoreBundle\Domain\Enums\PayloadStatus;
use TekosInteractive\SaaCoreBundle\Domain\Exceptions\GeneralException;
use TekosInteractive\SaaCoreBundle\Domain\Exceptions\NotFoundException;
use TekosInteractive\SaaCoreBundle\Domain\Exceptions\UniqueConstraintException;
use TekosInteractive\SaaCoreBundle\Domain\Exceptions\ValidationException;
use TekosInteractive\SaaCoreBundle\Domain\Interfaces\IsValidatorInterface;
use TekosInteractive\SaaCoreBundle\Domain\Payloads\Payload;
use TekosInteractive\SaaLoginBundle\Action\Auth\Dtos\ForgotPasswordOutput;
use TekosInteractive\SaaLoginBundle\Domain\Enums\EntityType;
use TekosInteractive\SaaLoginBundle\Domain\Interfaces\Auth\ForgotPasswordInputHandlerInterface;
use TekosInteractive\SaaCoreBundle\Domain\Interfaces\Dtos\InputDtoInterface;
use TekosInteractive\SaaCoreBundle\Domain\OutputFactories\OutputFactoryProviderInterface;
use TekosInteractive\SaaLoginBundle\Infra\Events\Auth\ForgotPassword;
use TekosInteractive\SaaUserBundle\Domain\Entities\User;
use TekosInteractive\SaaUserBundle\Domain\Interfaces\User\UserQueryRepositoryInterface;
use Exception;

class ForgotPasswordInputHandler implements ForgotPasswordInputHandlerInterface, IsValidatorInterface
{
    protected string $entityType;
    protected string $outputClass;

    public function __construct(
        private readonly EventDispatcherInterface $dispatcher,
        protected UserQueryRepositoryInterface $userQueryRepository,
        protected OutputFactoryProviderInterface $outputFactoryProvider
    ) {
        $this->entityType = EntityType::Auth->value;
        $this->outputClass = ForgotPasswordOutput::class;
    }

    /**
     * @throws UniqueConstraintException
     * @throws GeneralException
     */
    public function handle(InputDtoInterface $inputDto): Payload
    {
        try {
            $user = $this->userQueryRepository->findOneByUsernameOrEmail($inputDto->email);

            if (!$user instanceof User) {
                throw new NotFoundException(key: 'user');
            }

            $this->dispatcher->dispatch(new ForgotPassword($user), ForgotPassword::NAME);

            return new Payload(
                PayloadStatus::OK,
                []
            );
        } catch (UniqueConstraintViolationException $e) {
            throw new UniqueConstraintException(key: $e->getMessage());
        } catch (Exception $e) {
            throw new GeneralException($e->getMessage());
        }
    }

    /**
     * @throws ValidationException
     */
    public function validateInput(InputDtoInterface $inputDto): void
    {
        if (empty($inputDto->usernameOrEmail)) {
            throw new ValidationException('required', 'email');
        }
    }
}
