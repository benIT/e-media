<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function indexAction()
    {
        $users = $this->get('fos_user.user_manager')->findUsers();

        return $this->render('user/index.html.twig', array(
            'users' => $users,
        ));
    }

    public function showAction(User $user)
    {
        return $this->render('user/show.html.twig', array(
            'user' => $user,
        ));
    }
}
