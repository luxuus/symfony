<?php

namespace App\EventSubscriber;

use App\Repository\UserRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Event\AuthenticationSuccessEvent;

class LogLastConnectionSubscriber implements EventSubscriberInterface
{

    public function __construct(private UserRepository $userRepository)
    {

    }


    public function onSecurityAuthenticationSuccess(AuthenticationSuccessEvent $event): void
    {

        $this->userRepository->setLastTimeConnection($event->getAuthenticationToken()->getUser());
    }

    public static function getSubscribedEvents(): array
    {
        return [
            AuthenticationSuccessEvent::class => 'onSecurityAuthenticationSuccess',

        ];
    }
}
