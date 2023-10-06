<?php

namespace App\EventSubscriber;

use App\Event\MovieRestrictionEvent;
use App\Repository\UserRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MovieRestrictionSubscriber implements EventSubscriberInterface
{


    public function __construct(private Security $security, private UserRepository $userRepository)
    {
    }

    public function onMovieResctricted(MovieRestrictionEvent $event): void
    {
        if(!$this->security->isGranted('MOVIE_ORDER',$event->getMovie())) {
            dump($this->userRepository->notifyAdministrators());
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            MovieRestrictionEvent::class => 'onMovieResctricted',
        ];
    }
}
