<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Video;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{

    public function indexAction(Request $request)
    {
        $latestVideos = $this->getDoctrine()
            ->getRepository(Video::class)
            ->findLatest($this->getParameter('app_number_video_homepage'));
        // replace this example code with whatever you need
        return $this->render('home/index.html.twig', [
            'latestVideos' => $latestVideos,
        ]);
    }
}
