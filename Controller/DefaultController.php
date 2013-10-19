<?php

namespace RC\ServiredBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('RCServiredBundle:Default:index.html.twig', array('name' => $name));
    }
}
