<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Video;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;

class StreamController extends Controller
{
    /**
     * @see https://symfony.com/doc/current/components/http_foundation.html#serving-files
     * @param Video $video
     * @return BinaryFileResponse
     */
    public function streamAction(Request $request, Video $video)
    {
        $videoPath = $this->get('vich_uploader.storage')->resolvePath($video, 'videoFile');
        $response = new BinaryFileResponse($videoPath);
        BinaryFileResponse::trustXSendfileTypeHeader();
        return $response;

    }
}
