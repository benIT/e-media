<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Video;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class StreamController extends Controller
{
    use ControllerUtilsTrait;

    /**
     * secure the HLS m3u8 and segment download
     * @param Request $request
     * @param Video $video
     * @param $file
     * @param $frameSize
     * @return BinaryFileResponse
     */
    public function downloadHlsFileAction(Request $request, Video $video, $file, $frameSize)
    {
        $videoPath = $this->get('vich_uploader.storage')->resolvePath($video, 'videoFile');
        $filePath = $frameSize ? pathinfo($videoPath)['dirname'] . '/' . $frameSize . '/' . $file : pathinfo($videoPath)['dirname'] . '/' . $file;
        $response = new BinaryFileResponse($filePath);
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_INLINE, basename($filePath));
        return $response;
    }


    /**
     * Http Live Streaming
     * @see https://en.wikipedia.org/wiki/HTTP_Live_Streaming
     * @param Request $request
     * @param Video $video
     * @param $frameSize
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function streamAction(Request $request, Video $video, $frameSize)
    {
        $videoPath = $this->get('vich_uploader.storage')->resolvePath($video, 'videoFile');
        $fs = new Filesystem();
        $playlistFile = getenv('HLS_PLAYLIST_NAME');
        $playlistFileLocation = join('/', [pathinfo($videoPath)['dirname'], $frameSize, $playlistFile]);
        $errorFileLocation = join('/', [pathinfo($videoPath)['dirname'], $frameSize, 'error']);
        $lockFileLocation = join('/', [pathinfo($videoPath)['dirname'], $frameSize, 'lock']);
        $error = false;

        if ($fs->exists($errorFileLocation)) {
            $error = $this->get('translator')->trans('encoding.error', [], 'stream');
            $this->flashMessage(ControllerUtilsTrait::$flashDanger, $error);
        } elseif ($fs->exists($lockFileLocation)) {
            $error = $this->get('translator')->trans('encoding.pending', [], 'stream');
            $this->flashMessage(ControllerUtilsTrait::$flashInfo, $error);
        } elseif (!$fs->exists($playlistFileLocation)) {
            $error = $this->get('translator')->trans('encoding.no-playlist', [], 'stream');
            $this->flashMessage(ControllerUtilsTrait::$flashDanger, $error);
        }


        return $this->render('stream/stream.html.twig', array(
            'error' => $error,
            'video' => $video,
            'frameSize' => $frameSize
        ));
    }
}