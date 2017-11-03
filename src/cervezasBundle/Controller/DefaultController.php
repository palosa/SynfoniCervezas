<?php

namespace cervezasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('cervezasBundle:Default:index.html.twig');
    }
    public function idAction($id)
    {
        $repository = $this->getDoctrine()->getRepository('cervezasBundle:Cervezas');

        $cervezas = $repository->find($id);
        return $this->render('cervezasBundle:Default:id.html.twig',array('id'=>$cervezas));
    }
}
