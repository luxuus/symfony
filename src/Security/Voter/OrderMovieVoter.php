<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class OrderMovieVoter extends Voter
{
    public const ORDER = 'MOVIE_ORDER';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::ORDER])
            && $subject instanceof \App\Entity\Movie;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        // logic to determine if the user can EDIT
        // return true or false
        if(($subject->getRated()=='PG-13' || $subject->getRated()=='PG')&& $user->getAge()>=13){
            return true;
        }
        elseif (($subject->getRated()=='R' || $subject->getRated()=='NC-17')&& $user->getAge()>=17){
            return true;
        }

        return false;
    }
}
