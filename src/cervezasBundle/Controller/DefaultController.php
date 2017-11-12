<?php

namespace cervezasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use cervezasBundle\Entity\Cervezas;
use cervezasBundle\Form\CervezasType;
use Symfony\Component\HttpFoundation\Request;

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
        return $this->render('cervezasBundle:Default:mostrar1.html.twig',array('id'=>$cervezas));
    }
    public function crearAction($nombre,$pais)
    {
      $crearCerveza = new cervezas();

      $crearCerveza->setNombre($nombre);
      $crearCerveza->setPais($pais);
      $crearCerveza->setPoblacion("Mi casa");
      $crearCerveza->setTipo("Rubia");
      $crearCerveza->setImportacion(1);
      $crearCerveza->setTamano(1);
      $crearCerveza->setFechaAlmacen(\DateTime::createFromFormat('Y-m-d','2017-11-5'));
      $crearCerveza->setCantidad(1);
      $crearCerveza->setFoto("sanmiguel.jpg");

        $mangDoc = $this->getDoctrine()->getManager();

        $mangDoc->persist($crearCerveza);
        $mangDoc->flush($crearCerveza);

        $id = $crearCerveza->getId();

        $repository = $this->getDoctrine()->getRepository('cervezasBundle:Cervezas');
        $cervezas = $repository->find($id);
        return $this->render('cervezasBundle:Default:mostrar1.html.twig',array('id'=>$cervezas));

        // return $this->render('cervezasBundle:Default:crear.html.twig',array('Nombre'=>$crearCerveza->getNombre(),'Pais'=>$crearCerveza->getPais()));
    }
    public function formAction(Request $request)
    {
        $fromCerveza = new cervezas();

        $form = $this->createForm(CervezasType::class,$fromCerveza);
        $form->handleRequest($request);

          if ($form->isSubmitted() && $form->isValid()) {

            $fromCerveza = $form->getData();

            $DB = $this->getDoctrine()->getManager();
            $DB->persist($fromCerveza);
            $DB->flush();


            $id = $fromCerveza->getId();

            $repository = $this->getDoctrine()->getRepository('cervezasBundle:Cervezas');
            $cervezas = $repository->find($id);
            return $this->render('cervezasBundle:Default:mostrar1.html.twig',array('id'=>$cervezas));
          }
        return $this->render('cervezasBundle:Default:form.html.twig',array('form'=> $form->createView() ));
    }
    public function modAction(Request $request, $id)
    {
       $repository = $this->getDoctrine()->getRepository('cervezasBundle:Cervezas');

       $fromCerveza = $repository->find($id);

        $form = $this->createForm(CervezasType::class,$fromCerveza);
        $form->handleRequest($request);

          if ($form->isSubmitted() && $form->isValid()) {

            $DB = $this->getDoctrine()->getManager();
            $DB->persist($fromCerveza);
            $DB->flush();

            return $this->render('cervezasBundle:Default:mostrar1.html.twig',array('id'=>$fromCerveza));
          }
        return $this->render('cervezasBundle:Default:form.html.twig',array('form'=> $form->createView() ));

    }
}
