<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $container;
    private $encoder;

    public function __construct(ContainerInterface $container, UserPasswordEncoderInterface $encoder)
    {
        $this->container = $container;
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {

        $senderUser = new User();
        $senderUser->setEmail($this->container->getParameter('sender_email'));
        $senderUser->setPassword($this->encoder->encodePassword($senderUser, 'password'));
        $manager->persist($senderUser);
        $receiverUser = new User();
        $receiverUser->setEmail($this->container->getParameter('receiver_email'));
        $receiverUser->setPassword($this->encoder->encodePassword($receiverUser, 'password'));
        $manager->persist($receiverUser);

        $manager->flush();
    }
}
