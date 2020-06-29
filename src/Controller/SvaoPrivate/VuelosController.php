<?php

namespace App\Controller\SvaoPrivate;

use App\Entity\SvaoPrivate\Aerolinea;
use App\Entity\SvaoPrivate\Aeropuerto;
use App\Entity\SvaoPrivate\Ciudad;
use App\Entity\SvaoPrivate\HorarioVuelo;
use App\Entity\SvaoPrivate\Pais;
use App\Entity\SvaoPrivate\Vuelo;
use App\Form\SvaoPrivate\VueloType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class VuelosController extends AbstractController
{
    /**
     * @Route("/svao/private/aerolinea/vuelos", name="vuelos.index")
     */
    public function index(UserInterface $user)
    {

        if($user->getAerolinea()==null){
            $this->addFlash('danger','No puedes acceder a la url, no tienes asignado una aerolinea.');
            return $this->redirectToRoute('homesvao');
        }
        $aerolinea=$this->getDoctrine()->getRepository(Aerolinea::class)->find($user->getAerolinea());
        $list=$this->getDoctrine()
            ->getRepository(Vuelo::class)
            ->findBy(["estado"=>true,"aerolinea"=>$aerolinea]);

        return $this->render('private/aerolineas/vuelos/vuelos.html.twig',
            [
            'aerolinea' => $aerolinea,
            'list'=>$list
            ]);
    }

    /**
     * @Route("/svao/aerolinea/{aerolinea}/vuelos/create", name="vuelos.create",methods={"GET"})
     * @param Aerolinea $aerolinea
     */
    public function create(Aerolinea $aerolinea)
    {
        $form=$this->createForm(VueloType::class,
            new Vuelo(),
            [   'method'=>'POST',
                'action'=>$this->generateUrl('vuelos.store',['aerolinea'=>$aerolinea->getId()])
            ]);

        $view=$this->renderView('private/aerolineas/vuelos/vuelo.html.twig',
            [
            'form'=>$form->createView(),
            'aerolinea'=>$aerolinea,
            ]);

        return $this->json([
            'status'=>'success',
            'html'=>$view
        ]);

    }
    /**
     * @Route("/svao/aerolinea/{aerolinea}/vuelos/store", name="vuelos.store",methods={"POST"})
     */
    public function store(Request $request, Aerolinea $aerolinea)
    {
        $entityManager=$this->getDoctrine()->getManager();

        $obj=new Vuelo();
        $form=$this->createForm(VueloType::class,$obj,[
            'action'=>$this->generateUrl('vuelos.store',['aerolinea'=>$aerolinea->getId()]),
            'method'=>'POST'
        ]);

        $form->handleRequest($request);

        if($form->isValid())
        {
            $obj=$form->getData();
            $obj->setCodigo(bin2hex(random_bytes(5 )));
            $obj->setAerolinea($aerolinea);
            $obj->setEstado(true);
            try{
                $entityManager->persist($obj);
                $entityManager->flush();
                $this->addFlash('success',"Recurso almacenado exitosamente");
                return $this->redirect($this->generateUrl('vuelos.index',['aerolinea'=>$aerolinea->getId()]));
            }catch (Exception $e){
                $this->addFlash('danger',$e->getMessage());
            }
        }else{

            $list=$this->getDoctrine()
                ->getRepository(Vuelo::class)
                ->findBy(['estado'=>true,"aerolinea"=>$aerolinea]);

            $form=$this->renderView('private/aerolineas/vuelos/vuelo.html.twig',
                [
                    'form'=>$form->createView(),
                    'aerolinea'=>$aerolinea,
                ]);

            return $this->render('private/aerolineas/vuelos/vuelos.html.twig', [
                'aerolinea' => $aerolinea,
                'list'=>$list,
                'form'=>$form
            ]);
        }
    }


    /**
     * @Route("/svao/private/aerolinea/vuelos/{vuelo}/edit", name="vuelos.edit",methods={"GET"})
     * @param Vuelo $vuelo
     */

    public function edit(Vuelo $vuelo)
    {
        $form=$this->createForm(VueloType::class,
        $vuelo,
        [   'method'=>'POST',
            'action'=>$this->generateUrl('vuelos.update',['vuelo'=>$vuelo->getId()])
        ]);

        $view=$this->renderView('private/aerolineas/vuelos/vuelo.html.twig',
            [
                'form'=>$form->createView(),
                'aerolinea'=>$vuelo->getAerolinea(),
            ]);

        return $this->json([
            'status'=>'success',
            'html'=>$view
        ]);
    }

    /**
     * @Route("/svao/private/aerolinea/vuelos/{vuelo}/update", name="vuelos.update",methods={"POST"})
     * @param Vuelo $vuelo
     * @param Request $request
     */

    public function update(Request $request ,Vuelo $vuelo)
    {
        $entityManager=$this->getDoctrine()->getManager();

        $form=$this->createForm(VueloType::class,$vuelo,
            [   'method'=>'POST',
                'action'=>$this->generateUrl('vuelos.update',['vuelo'=>$vuelo->getId()])
            ]);

        $form->handleRequest($request);

        if($form->isValid()){
            try{
                $vuelo=$form->getData();
                $entityManager->flush();
                $this->addFlash('success','Registro actualizado correctamente.');
            }catch (Exception $e){
                $this->addFlash('danger',$e->getMessage());
            }
            return $this->redirect($this->generateUrl('vuelos.index',['aerolinea'=>$vuelo->getAerolinea()->getId()]));
        }

        //Simulamos ir al index
        $list=$this->getDoctrine()
            ->getRepository(Vuelo::class)
            ->findBy(['estado'=>true,'aerolinea'=>$vuelo->getAerolinea()]);

        $form=$this->renderView('private/aerolineas/vuelos/vuelo.html.twig',
            [
                'form'=>$form->createView(),
                'aerolinea'=>$vuelo->getAerolinea(),
            ]);

        return $this->render('private/aerolineas/vuelos/vuelos.html.twig', [
            'aerolinea' => $vuelo->getAerolinea(),
            'list'=>$list,
            'form'=>$form
        ]);
    }


    /**
     * @Route("/svao/aerolinea/vuelos/{vuelo}/delete", name="vuelos.delete",methods={"GET"})
     * @param Vuelo $vuelo
     */
    public function delete(Vuelo $vuelo)
    {
        $form=$this->createForm(VueloType::class,
            $vuelo,
            [   'method'=>'POST',
                'action'=>$this->generateUrl('vuelos.trash',['vuelo'=>$vuelo->getId()])
            ]);

        $view=$this->renderView('private/aerolineas/vuelos/vuelo.html.twig',
            [
                'form'=>$form->createView(),
                'aerolinea'=>$vuelo->getAerolinea(),
                'delete'=>true
            ]);

        return $this->json([
            'status'=>'success',
            'html'=>$view
        ]);
    }

    /**
     * @Route("/svao/aerolinea/vuelos/{vuelo}/trash", name="vuelos.trash",methods={"POST"})
     * @param Vuelo $vuelo
     */
    public function trash(Vuelo $vuelo)
    {
        try {
            $entityManager=$this->getDoctrine()->getManager();
            $vuelo->setEstado(false);
            $entityManager->flush();
            $this->addFlash('warning',"Eliminacion realizada correctamente");
        }catch (\Exception $e){
            $this->addFlash('danger',$e->getMessage());
        }
        return $this->redirect($this->generateUrl('vuelos.index',['aerolinea'=>$vuelo
            ->getAerolinea()->getId()]));
    }
    /**==============================================================================================
     * Funciones para administrar la reserva de vuelo ===============================================
     * ==============================================================================================
     */


}
