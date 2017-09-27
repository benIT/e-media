<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\DataFixtures\ORM\Data\UserFixturesData;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach (UserFixturesData::$data as $username) {
            $userManager = $this->container->get('fos_user.user_manager');
            $user = $userManager->createUser();
            $user->setUsername($username);
            $user->setEmail($username . '@mail.com');
            $user->setPlainPassword($username);
            $user->setEnabled(true);
            $userManager->updateUser($user);
        }
    }
}