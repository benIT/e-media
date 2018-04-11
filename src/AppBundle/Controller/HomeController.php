<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Video;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    public function indexAction(Request $request)
    {
        $latestVideos = $this->getDoctrine()
            ->getRepository(Video::class)
            ->findLatest(getenv('APP_NUMBER_VIDEO_HOMEPAGE'));
        // replace this example code with whatever you need
        return $this->render('home/index.html.twig', [
            'latestVideos' => $latestVideos,
        ]);
    }

    public function versionAction(Request $request)
    {
        $fileSystem = new Filesystem();
        $buildFile = $this->get('kernel')->getRootDir() . '/../build.json';
        if ($fileSystem->exists($buildFile)) {
            $versionInfo = json_decode(file_get_contents($buildFile));
        }
        return $this->render('home/version.html.twig', [
            'versionInfo' => isset($versionInfo) ? $versionInfo : null,
        ]);

    }
}
