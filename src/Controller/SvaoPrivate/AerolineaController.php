<?php

namespace App\Controller\SvaoPrivate;

use App\Entity\SvaoPrivate\Aeropuerto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\SvaoPrivate\Aerolinea;
use App\Form\SvaoPrivate\AerolineaType;

class AerolineaController extends AbstractController
{
    /**
     * @Route("/svao/aerolineas", name="aerolineas.index",methods={"GET",})
     */
    public function index(Request $request)
    {
        $list=$this->getDoctrine()
            ->getRepository(Aerolinea::class)
            ->findBy(['estado'=>true]);

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
    public function store(Request $request)
    {
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
            $linea->setEstado(true);
            $code=$entityManager->getRepository(Aerolinea::class)->getCode($form->get('nombre')->getData());
            //---------------------------------------------------------------------------------------------------------
            //---------------------------------------------------------------------------------------------------------

            $linea->setCodigo($code['fn_generate_code_aerolineas']);

            try{
                $entityManager->persist($linea);
                $entityManager->flush();

            }catch (Exception $e){
                $status="transaccion_error";
            }
            $this->addFlash('success',"Aerolinea agregada exitosamente");
            return $this->redirect($this->generateUrl('aerolineas.index'));
        }else{
            $view=$this->renderView('private/aerolineas/create.html.twig',[
                'form'=>$form->createView(),
            ]);

            $list=$this->getDoctrine()
                ->getRepository(Aerolinea::class)
                ->findBy(['estado'=>true]);

            return $this->render('private/aerolineas/aerolineas.html.twig', [
                'list' => $list,
                'form'=>$view
            ]);
        }
    }


    /**
     * @Route("svao/private/aerolinea/edit/{linea}",name="aerolineas.edit",methods={"GET",})
     */
    public function edit(Aerolinea $linea)
    {

        $form=$this->createForm(AerolineaType::class,$linea,[
            'action'=>$this->generateUrl('aerolineas.update',['linea'=>$linea->getId()]),
            'method'=>'POST',
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
     * @Route("svao/private/aerolinea/update/{linea}",name="aerolineas.update",methods={"POST",})
     */
    public function update(Request $request,Aerolinea $linea)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $form=$this->createForm(AerolineaType::class,
            $linea,
            [   'method'=>'POST',
                'action'=>$this->generateUrl('aerolineas.update',['linea'=>$linea->getId()])
            ]);

        $form->handleRequest($request);
        if($form->isValid()){
            try{
                $linea=$form->getData();
                $entityManager->flush();
                $this->addFlash('success','Aerolinea actualizada correctamente');

            }catch (Exception $e){
                $this->addFlash('danger',"El sistema fracaso al completar latransaccion");
            }
            return $this->redirect($this->generateUrl('aerolineas.index'));
        }

        $list=$this->getDoctrine()
            ->getRepository(Aerolinea::class)
            ->findBy(['estado',true]);

        return $this->render('private/aerolineas/aerolineas.html.twig',['list'=>$list,'form'=>$form->createView()]);

    }

    /**
     * @Route("svao/private/aerolinea/{linea}/delete",name="aerolineas.delete",methods={"GET",})
     */
    public function delete(Aerolinea $linea)
    {

        $form=$this->createForm(AerolineaType::class,$linea,[
            'action'=>$this->generateUrl('aerolineas.trash',['linea'=>$linea->getId()]),
            'method'=>'POST',
        ]);

        $view=$this->renderView('private/aerolineas/create.html.twig',[
            'form'=>$form->createView(),
            'accion'=>'delete',
        ]);

        return $this->json([
            'status'=>'success',
            'html'=>$view
        ]);
    }

    /**
     * @Route("svao/private/aerolinea/{linea}/trash",name="aerolineas.trash",methods={"POST",})
     */
    public function trash(Aerolinea $linea)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $linea->setEstado(false);

        $entityManager->flush();

        $this->addFlash('warning','Elemento eliminado correctamente.');
        return $this->redirect($this->generateUrl('aerolineas.index'));

    }

}
