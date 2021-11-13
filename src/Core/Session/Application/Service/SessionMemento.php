<?php


namespace DeliberryAPI\Core\Session\Application\Service;


use DeliberryAPI\Core\Trace\Domain\Model\Trace;
use DeliberryAPI\Core\User\Domain\Model\UserLoggedInterface;

final class SessionMemento
{
    private UserLoggedInterface $user;
    private Trace $trace;

    public function user(): UserLoggedInterface
    {
        return $this->user;
    }

    public function trace(): Trace
    {
        return $this->trace;
    }

    public function withUser(UserLoggedInterface $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function withTrace(Trace $trace): self
    {
        $this->trace = $trace;
        return $this;
    }

}