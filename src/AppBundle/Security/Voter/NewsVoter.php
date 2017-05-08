<?php

namespace AppBundle\Security\Voter;

use AppBundle\Entity\News;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class NewsVoter extends Voter
{
    const EDIT = 'EDIT_NEWS';

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::EDIT])) {
            return false;
        }

        if (!$subject instanceof News) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        $news = $subject;

        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($news, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canEdit(News $news, User $user)
    {
        return $user->getUsername() === $news->getAuthor();
    }
}
