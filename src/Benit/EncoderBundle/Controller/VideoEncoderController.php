<?php

namespace Benit\EncoderBundle\Controller;

use AppBundle\Controller\ControllerUtilsTrait;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \FFMpeg\FFMpeg;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;

class VideoEncoderController extends Controller
{
    use ControllerUtilsTrait;

    public function encodeAction(\AppBundle\Entity\Video $video)
    {
        $videoPath = $this->container->get('vich_uploader.storage')->resolvePath($video, 'videoFile');
        $ffmpeg = FFMpeg::create([
            'ffprobe.binaries' => '/usr/bin/ffprobe',
            'ffmpeg.binaries' => '/usr/bin/ffmpeg',
        ]);
        $tempVideoPath = '/tmp/' . uniqid();
        $format = new \FFMpeg\Format\Video\WebM();
        $encodedVideo = $ffmpeg->open($videoPath);
        $encodedVideo->save($format, $tempVideoPath);
        $video->setVideoFile(new UploadedFile($tempVideoPath, null, null, null, null, true));
        $em = $this->getDoctrine()->getManager();
        $video->setUpdatedAt(new \DateTime());
        $em->persist($video);
        $em->flush();
        $this->flashMessage(ControllerUtilsTrait::$flashSuccess);
        return new RedirectResponse($this->generateUrl('video_show', ['id' => $video->getId()]));
    }
}
