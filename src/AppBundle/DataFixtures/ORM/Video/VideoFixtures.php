<?php

namespace AppBundle\DataFixtures\ORM\Video;

use AppBundle\DataFixtures\ORM\Data\TagFixturesData;
use AppBundle\DataFixtures\ORM\User\UserFixtures;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use AppBundle\DataFixtures\ORM\Data\UserFixturesData;
use AppBundle\DataFixtures\ORM\Data\VideoFixturesData;
use AppBundle\Entity\User;
use AppBundle\Entity\Video;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use  Symfony\Component\Filesystem\Filesystem;

class VideoFixtures extends Fixture
{
    const LIMIT = 10;

    public function load(ObjectManager $manager)
    {
        $fs = new Filesystem();
        $users = array_slice(UserFixturesData::$data, 0, UserFixtures::LIMIT);
        $data = VideoFixturesData::$data;

        foreach ($data as $videoData) {
            echo '.';
            $video = new Video();
            $video->setTitle($videoData['title']);
            $video->setDescription($videoData['title']);
            $filePath = __DIR__ . '/../Data/test.mp4';
            $fileName = \filter_var($videoData['title'], FILTER_SANITIZE_EMAIL);
            $targetfilePath = __DIR__ . '/../Data/' . $fileName . 'mp4';
            $fs->copy($filePath, $targetfilePath);
            $video->setVideoFile(new UploadedFile($targetfilePath, 'test.mp4', 'video/mp4', null, null, true));
            $video->setCreator($this->getReference($users[array_rand($users)]['firstName']));
            $video->addTag($this->getReference(TagFixturesData::$data[array_rand(TagFixturesData::$data)]['name']));
            $video->addTag($this->getReference(TagFixturesData::$data[array_rand(TagFixturesData::$data)]['name']));
            $manager->persist($video);
        }
        $manager->flush();
    }
}