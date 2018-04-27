<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Video;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controller for lti integration
 * Class LtiController
 * @package AppBundle\Controller
 */
class LtiController extends Controller
{
    use ControllerUtilsTrait;

    /**
     * This route is used for lti integration.
     * @param Request $request
     * @param Video $video
     * @return RedirectResponse
     */
    public function showAction(Request $request, Video $video)
    {
        $ltiToolProvider = $this->get('app.lti.provider');
        $ltiToolProvider->setRequest($request);
        $ltiToolProvider->handleRequest();
        return new RedirectResponse($this->get('router')->generate('video_show', ['id' => $video->getId()]));
    }

}
