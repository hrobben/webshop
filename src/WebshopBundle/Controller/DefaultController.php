<?php

namespace WebshopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('WebshopBundle:Default:index.html.twig',
            [
                'name' => 'Hallo',
                'body' => 'dit is de body tekst',
            ]);
    }
}
