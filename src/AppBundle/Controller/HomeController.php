<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Video;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
}
