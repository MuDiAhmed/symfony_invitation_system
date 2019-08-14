<?php

namespace App\DataFixtures;

use App\Entity\Invitaion;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class InvitationFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $users = $manager->getRepository(User::class)->findAll();
        for($i = 0; $i < 3; $i++){
            $invitation = new Invitaion();
            $invitation->setSender($users[0]);
            $invitation->setReceiver($users[$i+1]);
            $manager->persist($invitation);
        }
        for($i = 0; $i < 3; $i++){
            if($i ==1)continue;
            $invitation = new Invitaion();
            $invitation->setSender($users[1]);
            $invitation->setReceiver($users[$i]);
            $manager->persist($invitation);
        }
        for($i = 0; $i < 3; $i++){
            if($i ==2)continue;
            $invitation = new Invitaion();
            $invitation->setSender($users[2]);
            $invitation->setReceiver($users[$i]);
            $manager->persist($invitation);
        }
        for($i = 0; $i < 3; $i++){
            if($i ==3)continue;
            $invitation = new Invitaion();
            $invitation->setSender($users[3]);
            $invitation->setReceiver($users[$i]);
            $manager->persist($invitation);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
