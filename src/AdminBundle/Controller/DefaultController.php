<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('AdminBundle:Default:index.html.twig');
    }

    /**
     * @Route("/administration", name="administration")
     */
    public function adminAction()
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Access denied : you\'re not logged in !');
        return $this->render('AdminBundle:Default:index.html.twig');
    }


}
