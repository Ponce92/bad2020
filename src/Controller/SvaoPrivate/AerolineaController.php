<?php

namespace App\Controller\SvaoPrivate;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\SvaoPrivate\Aerolinea;
use App\Form\SvaoPrivate\AerolineaType;

class AerolineaController extends AbstractController
{
    /**
     * @Route("/svao/private/aerolineas", name="aerolineas.index",methods={"GET",})
     */
    public function index(Request $request)
    {
        $list=$this->getDoctrine()
            ->getRepository(Aerolinea::class)
            ->findAll();

        return $this->render('private/aerolineas/aerolineas.html.twig', [
            'list' => $list,
        ]);
    }

    /**
     * @Route("/svao/private/aeroliena/create",name="aerolineas.create",methods={"GET",})
     */
    public function create(Request $request){


        $form=$this->createForm(AerolineaType::class,
                                    new Aerolinea(),
                                    [   'method'=>'POST',
                                        'action'=>$this->generateUrl('aerolineas.store')
                                    ]);


        $view=$this->renderView('private/aerolineas/create.html.twig',[
            'form'=>$form->createView(),
        ]);

        return $this->json([
            'status'=>'success',
            'html'=>$view
        ]);

    }

    /**
     * @Route("svao/private/aerolinea/store",name="aerolineas.store",methods={"POST",})
     */
    public function store(Request $request){
        $entityManager=$this->getDoctrine()->getManager();

        $linea=new Aerolinea();
        $form=$this->createForm(AerolineaType::class,$linea,[
           'action'=>$this->generateUrl('aerolineas.store'),
            'method'=>'POST'
        ]);

        $form->handleRequest($request);

        if($form->isValid())
        {
            $linea=$form->getData();
            $status="success";
            try{
                $entityManager->persist($linea);
                $entityManager->flush();

            }catch (Exception $e){
                $status="transaccion_error";
            }
            $linea=new Aerolinea();

            $form=$this->createForm(AerolineaType::class,$linea,[
                'action'=>$this->generateUrl('aerolineas.store'),
                'method'=>'POST'
            ]);

            $view=$this->renderView('private/aerolineas/create.html.twig',[
                'form'=>$form->createView(),
            ]);

        }else{
            $status="form_errors";
            $view=$this->renderView('private/aerolineas/create.html.twig',[
                'form'=>$form->createView(),
            ]);
        }
        return $this->json([
            'status'=>$status,
            'html'=>$view,
        ]);


    }

    /**
     * @Route("svao/private/aerolinea/edit/{linea}",name="aerolineas.edit",methods={"GET",})
     */
    public function edit(){

    }


    /**
     * @Route("svao/private/aerolinea/update/{linea}",name="aerolineas.edit",methods={"POST",})
     */
    public function update(){

    }

    /**
     * @Route("svao/private/aerolinea/{linea}/delete",name="aerolineas.edit",methods={"",})
     */
    public function delete(){

    }



}
