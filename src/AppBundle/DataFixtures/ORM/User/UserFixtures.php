<?php

namespace AppBundle\DataFixtures\ORM\User;

use AppBundle\DataFixtures\ORM\Data\UserFixturesData;
use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserFixtures extends Fixture implements ContainerAwareInterface
{
    const LIMIT = 2;

    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {

        $data = UserFixturesData::$data;
        $userManager = $this->container->get('fos_user.user_manager');
        $count = 0;
        foreach ($data as $userData) {
            echo '.';
            /** @var User $user */
            $user = $userManager->createUser();
            $username = $userData['firstName'];
            $user->setFirstName($username);
            $user->setLastName($userData['lastName']);
            $user->setUsername($username);
            $user->setEmail($username . '@mail.com');
            $user->setPlainPassword($username);
            $user->setEnabled(true);
            $userManager->updateUser($user);
            $this->addReference($username, $user);
            ++$count;
            if ($count > self::LIMIT) {
                break;
            }
        }
    }
}
