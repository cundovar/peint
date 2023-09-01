<?php 
namespace App\Security;

use App\Entity\User;
use App\Entity\Commentaire;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class CommentVoter extends Voter
{
    const EDIT ='EDIT_COMMENT';
    protected function supports(string $attribute,$subject)
    {
        return 
        $attribute=self::EDIT &&
        $subject instanceof Commentaire;

    }
    protected function voteOnAttribute(string $attribute,$subject,TokenInterface $token)
{
    $user=$token->getUser();
    if (!$user instanceof User || !$subject instanceof Commentaire){
        return false;
    }

    return $subject->getUser()->getId();
    
}

}