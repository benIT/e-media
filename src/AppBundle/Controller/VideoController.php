<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Video;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;


/**
 * Video controller.
 */
class VideoController extends Controller
{
    use ControllerUtilsTrait;

    /**
     * Lists all video entities.
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $videos = $em->getRepository('AppBundle:Video')->findLatest();

        return $this->render('video/index.html.twig', array(
            'videos' => $videos,
        ));
    }

    /**
     * Creates a new video entity.
     */
    public function newAction(Request $request)
    {
        $video = new Video();
        $video->setCreator($this->getUser());
        $form = $this->createForm('AppBundle\Form\VideoType', $video, ['action_type' => 'create']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($video);
            $em->flush();
            $this->flashMessage(ControllerUtilsTrait::$flashSuccess);

            return $this->redirectToRoute('video_upload', array('id' => $video->getId()));
        }

        return $this->render('video/edit.html.twig', array(
            'title' => $this->get('translator')->trans('form_create.create', [], 'video'),
            'video' => $video,
            'form' => $form->createView(),
        ));
    }

    public function uploadVideoAction(Request $request, Video $video)
    {
        $form = $this->createForm('AppBundle\Form\VideoFileType', $video);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $video->setUpdatedAt(new \DateTime());
            $em->persist($video);
            $em->flush();
            $this->flashMessage(ControllerUtilsTrait::$flashSuccess);

            return $this->redirectToRoute('video_show', array('id' => $video->getId()));
        }
        return $this->render('video/upload.html.twig', array(
            'title' => $this->get('translator')->trans('form_create.create', [], 'video'),
            'video' => $video,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a video entity.
     */
    public function showAction(Video $video)
    {
        $deleteForm = $this->createDeleteForm($video);

        return $this->render('video/show.html.twig', array(
            'video' => $video,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing video entity.
     */
    public function editAction(Request $request, Video $video)
    {
        $editForm = $this->createForm('AppBundle\Form\VideoType', $video, ['action_type' => 'edit']);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $video->setUpdatedAt(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($video);
            $em->flush();
            $this->flashMessage(ControllerUtilsTrait::$flashSuccess);
            return $this->redirectToRoute('video_show', ['id' => $video->getId()]);
        }

        return $this->render('video/edit.html.twig', array(
            'title' => $this->get('translator')->trans('form_create.edit', [], 'video'),
            'video' => $video,
            'form' => $editForm->createView(),
        ));
    }

    public function searchAction(Request $request)
    {
        $form = $this->createForm('AppBundle\Form\VideoSearchType');
        $form->handleRequest($request);
        $videos = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $criteria = $form->getData();
            $videos = $this->getDoctrine()->getRepository(Video::class)->findVideo($criteria);
        }

        return $this->render('video/search.twig', array(
            'form' => $form->createView(),
            'submitted' => $form->isSubmitted(),
            'videos' => $videos,
        ));
    }

    /**
     * Deletes a video entity.
     */
    public function deleteAction(Request $request, Video $video)
    {
        $form = $this->createDeleteForm($video);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($video);
            $em->flush();
            $this->flashMessage(ControllerUtilsTrait::$flashSuccess);

            return $this->redirectToRoute('video_index');
        }

        return $this->render('video/delete.twig', array(
            'video' => $video,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to delete a video entity.
     *
     * @param Video $video The video entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Video $video)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('video_delete', array('id' => $video->getId())))
            ->getForm();
    }

    /**
     * @see https://symfony.com/doc/current/components/http_foundation.html#serving-files
     * @see apache mod_xsendfile: https://tn123.org/mod_xsendfile/
     * @see nginx X-accel: https://www.nginx.com/resources/wiki/start/topics/examples/x-accel/
     * @param Request $request
     * @param Video $video
     * @return BinaryFileResponse
     * @throws \Exception
     */
    public function downloadAction(Request $request, Video $video)
    {
        $videoPath = $this->get('vich_uploader.storage')->resolvePath($video, 'videoFile');
        $response = new BinaryFileResponse($videoPath);
        if (filter_var(getenv('USE_X_SENDFILE_MODE'), FILTER_VALIDATE_BOOLEAN)) {
            BinaryFileResponse::trustXSendfileTypeHeader();
            $serverSoftware = $request->server->get('SERVER_SOFTWARE');
            //determine header according to server software to serve file faster directly by server instead of using php
            if (preg_match('/nginx/', $serverSoftware)) {
                if (!$nginxLocationXSendFile = getenv('NGINX_LOCATION_X_SEND_FILE')) {
                    throw new ParameterNotFoundException('nginx_location_x_send_file');
                }
                // slash management in lginx stream location
                $nginxLocationXSendFile = substr($nginxLocationXSendFile, -1) === '/' ? $nginxLocationXSendFile : $nginxLocationXSendFile . '/';
                $nginxLocationXSendFile = substr($nginxLocationXSendFile, 0, 1) === '/' ? $nginxLocationXSendFile : '/' . $nginxLocationXSendFile;
                $response->headers->set('X-Accel-Redirect', $nginxLocationXSendFile . 'video/' . basename(pathinfo($videoPath)['dirname']) . '/' . pathinfo($videoPath)['basename']);
            } elseif (preg_match('/apache/', $serverSoftware)) {
                $response->headers->set('X-Sendfile', $videoPath);
            } else {
                throw  new \Exception(sprintf('server "%s" not supported', $serverSoftware));
            }
            $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_INLINE, basename($videoPath));
        }
        return $response;
    }
}
