<?php

namespace AppBundle\DataFixtures\ORM\Tag;

use AppBundle\DataFixtures\ORM\Data\TagFixturesData;
use AppBundle\Entity\Tag;
use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TagFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $data = TagFixturesData::$data;
        foreach ($data as $tagData) {
            echo '.';
            /** @var User $user */
            $tag = new Tag();
            $tagName = $tagData['name'];
            $tag->setName($tagName);
            $tag->setRestricted(array_rand([true, false]));
            $this->addReference($tagName, $tag);
            $manager->persist($tag);
        }
        $manager->flush();
    }
}