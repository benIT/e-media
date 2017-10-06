<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Video;
use Sensio\Bundle\FrameworkExtraBundle\EventListener\ControllerListener;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\Stream;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Video controller.
 *
 */
class VideoController extends Controller
{
    use ControllerUtilsTrait;

    /**
     * Lists all video entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $videos = $em->getRepository('AppBundle:Video')->findAll();

        return $this->render('video/index.html.twig', array(
            'videos' => $videos,
        ));
    }

    /**
     * Creates a new video entity.
     *
     */
    public function newAction(Request $request)
    {
        $video = new Video();
        $form = $this->createForm('AppBundle\Form\VideoType', $video, ['action_type' => 'create']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($video);
            $em->flush();
            $this->flashMessage(ControllerUtilsTrait::$flashSuccess);
            return $this->redirectToRoute('video_show', array('id' => $video->getId()));
        }

        return $this->render('video/edit.html.twig', array(
            'title' => $this->get('translator')->trans('form_create.create', [], 'video'),
            'video' => $video,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a video entity.
     *
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
     *
     */
    public function editAction(Request $request, Video $video)
    {
        $editForm = $this->createForm('AppBundle\Form\VideoType', $video, ['action_type' => 'update']);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->flashMessage(ControllerUtilsTrait::$flashSuccess);
            return $this->redirectToRoute('video_index');
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
            'videos' => $videos
        ));
    }

    /**
     * Deletes a video entity.
     *
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
//            ->setMethod('DELETE')
            ->getForm();
    }

}
