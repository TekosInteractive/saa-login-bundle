<?php

namespace TekosInteractive\SaaLoginBundle\Domain\InputHandlers\Auth;

use DateTimeImmutable;
use TekosInteractive\SaaCoreBundle\Domain\Enums\PayloadStatus;
use TekosInteractive\SaaCoreBundle\Domain\Exceptions\ValidationException;
use TekosInteractive\SaaCoreBundle\Domain\Interfaces\Dtos\InputDtoInterface;
use TekosInteractive\SaaCoreBundle\Domain\Interfaces\IsValidatorInterface;
use TekosInteractive\SaaCoreBundle\Domain\Payloads\Payload;
use TekosInteractive\SaaLoginBundle\Action\Auth\Dtos\LogoutInput;
use TekosInteractive\SaaLoginBundle\Action\Auth\Dtos\LogoutOutput;
use TekosInteractive\SaaLoginBundle\Domain\Enums\EntityType;
use TekosInteractive\SaaLoginBundle\Domain\Interfaces\Auth\LogoutInputHandlerInterface;
use TekosInteractive\SaaCoreBundle\Domain\OutputFactories\OutputFactoryProviderInterface;
use TekosInteractive\SaaLoginBundle\Domain\Traits\HasDateTimeTrait;
use TekosInteractive\SaaUserBundle\Domain\Entities\AccessTokenSession;
use TekosInteractive\SaaUserBundle\Domain\Interfaces\AccessTokenSession\AccessTokenSessionCommandRepositoryInterface;
use TekosInteractive\SaaUserBundle\Domain\Interfaces\User\UserQueryRepositoryInterface;

class LogoutInputHandler implements LogoutInputHandlerInterface, IsValidatorInterface
{
    use HasDateTimeTrait;

    protected string $entityType;
    protected string $outputClass;

    public function __construct(
        protected UserQueryRepositoryInterface $userQueryRepository,
        protected AccessTokenSessionCommandRepositoryInterface $accessTokenSessionCommandRepo,
        protected OutputFactoryProviderInterface $outputFactoryProvider
    ) {
        $this->entityType = EntityType::Auth->value;
        $this->outputClass = LogoutOutput::class;
    }

    public function handle(InputDtoInterface $inputDto): Payload
    {
        try {
            /** @var LogoutInput $inputDto */
            $accessToken = $this->accessTokenSessionCommandRepo->findOneBy([
                'jwt' => $inputDto->token
            ]);

            if ($accessToken instanceof AccessTokenSession && true === $accessToken->isValid()) {
                $accessToken->revokeAccessToken();
                $this->accessTokenSessionCommandRepo->save($accessToken)->flush();

                return new Payload(PayloadStatus::OK, []);
            }

            return new Payload(PayloadStatus::ERROR, []);
        } catch (\Exception $e) {
            return new Payload(
                PayloadStatus::ERROR,
                ['message' => $e->getMessage()]
            );
        }
    }

    /**
     * @throws ValidationException
     */
    public function validateInput(InputDtoInterface $inputDto): void
    {
        if (empty($inputDto->token)) {
            throw new ValidationException('required', 'token');
        }
    }
}
