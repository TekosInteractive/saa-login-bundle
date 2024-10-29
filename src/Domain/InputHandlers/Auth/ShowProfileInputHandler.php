<?php

namespace TekosInteractive\SaaLoginBundle\Domain\InputHandlers\Auth;

use TekosInteractive\SaaCoreBundle\Domain\InputHandlers\QueryHandlerAbstract;
use TekosInteractive\SaaLoginBundle\Domain\Enums\EntityType;
use TekosInteractive\SaaCoreBundle\Domain\OutputFactories\OutputFactoryProviderInterface;
use TekosInteractive\SaaLoginBundle\Domain\Interfaces\Auth\ShowProfileInputHandlerInterface;
use TekosInteractive\SaaUserBundle\Domain\Dtos\OutputDto\UserOutput;
use TekosInteractive\SaaUserBundle\Domain\Interfaces\User\UserQueryRepositoryInterface;

class ShowProfileInputHandler extends QueryHandlerAbstract implements ShowProfileInputHandlerInterface
{
    protected string $entityType;
    protected string $entityOutput;

    public function __construct(
        protected UserQueryRepositoryInterface $userQueryRepository,
        protected OutputFactoryProviderInterface $outputFactoryProvider,
    ) {
        $this->entityType = EntityType::Auth->value;
        $this->entityOutput = UserOutput::class;

        parent::__construct(
            $userQueryRepository,
            $outputFactoryProvider
        );
    }
}
