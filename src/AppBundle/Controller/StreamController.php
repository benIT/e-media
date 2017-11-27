<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Video;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class StreamController extends Controller
{
    /**
     * @see https://symfony.com/doc/current/components/http_foundation.html#serving-files
     * @see apache mod_xsendfile: https://tn123.org/mod_xsendfile/
     * @see nginx X-accel: https://www.nginx.com/resources/wiki/start/topics/examples/x-accel/
     * @param Request $request
     * @param Video $video
     * @return BinaryFileResponse
     * @throws \Exception
     */
    public function streamAction(Request $request, Video $video)
    {
        $videoPath = $this->get('vich_uploader.storage')->resolvePath($video, 'videoFile');
        $response = new BinaryFileResponse($videoPath);

        $serverSoftware = $request->server->get('SERVER_SOFTWARE');
        //determine header according to server software to serve file faster directly by server instead of using php
        if (preg_match('/nginx/', $serverSoftware)) {
            $response->headers->set('X-Accel-Redirect', '/stream-files/video/' . basename($videoPath));
        } elseif (preg_match('/apache/', $serverSoftware)) {
            $response->headers->set('X-Sendfile', $videoPath);
        } else {
            throw  new \Exception(sprintf('server "%s" not supported', $serverSoftware));
        }
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, basename($videoPath));
        BinaryFileResponse::trustXSendfileTypeHeader();
        return $response;
    }
}