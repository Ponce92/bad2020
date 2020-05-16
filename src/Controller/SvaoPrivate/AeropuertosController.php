<?php

namespace App\Controller\SvaoPrivate;


use App\Form\SvaoPrivate\AeropuertoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\SvaoPrivate\Aeropuerto;

use Symfony\Component\HttpFoundation\Request;


class AeropuertosController extends AbstractController
{
    /**
     * @Route("/svao/private/aeropuertos", name="aeropuertos.list")
     */
    public function index(Request $request)
    {
        $list = $this->getDoctrine()
            ->getRepository(Aeropuerto::class)
            ->findAll();


        return $this->render('private/aeropuerto/aeropuertos.html.twig', [
            'list' => $list,
        ]);

    }

    /**
     * @Route("/svao/private/aeropuertos/create", name="aeropuertos.create",methods={"GET",})
     */
    public function create()
    {
        $aeropuerto=new Aeropuerto();
        $form=$this->createForm(AeropuertoType::class,
            $aeropuerto,
            [   'method'=>'POST',
                'action'=>$this->generateUrl('aeropuertos.store')
            ]);


        $view=$this->renderView('private/aeropuerto/create.html.twig',[
            'form'=>$form->createView(),
        ]);
        return $this->json([
            'status'=>'success',
            'html'=>$view
        ]);
    }

    /**
     * @Route("/svao/private/aeropuertos/store", name="aeropuertos.store",methods={"POST",})
     */
    public function store(Request $request)
    {
        $entityManager=$this->getDoctrine()->getManager();
        $aeropuerto=new Aeropuerto();
        $form=$this->createForm(AeropuertoType::class,
            $aeropuerto,
            [   'method'=>'POST',
                'action'=>$this->generateUrl('aeropuertos.store')
            ]);

        $form->handleRequest($request);

        if($form->isValid())
        {
            $aeropuerto=$form->getData();
            $status="success";
            try{
                $entityManager->persist($aeropuerto);
                $entityManager->flush();

            }catch (Exception $e){
                $status="transaccion_error";
            }

            $aeropuerto=new Aeropuerto();
            $form=$this->createForm(AeropuertoType::class,$aeropuerto,[
                'action'=>$this->generateUrl('aeropuertos.store.store'),
                'method'=>'POST'
            ]);

            $view=$this->renderView('private/aeropuerto/create.html.twig',[
                'form'=>$form->createView(),
            ]);
        }else{

            $status="form_errors";
            $view=$this->renderView('private/aeropuerto/create.html.twig',[
                'form'=>$form->createView(),
            ]);
        }

        return $this->json([
            'status'=>$status,
            'html'=>$view,
        ]);
    }
}
