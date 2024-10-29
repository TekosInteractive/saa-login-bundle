<?php

namespace TekosInteractive\SaaLoginBundle\Infra\Events\Auth;

use Symfony\Contracts\EventDispatcher\Event;
use TekosInteractive\SaaUserBundle\Domain\Entities\User;

class ForgotPassword extends Event
{
    public const NAME = 'auth.forgot_password';

    public function __construct(
        private readonly User $user
    ) {
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
