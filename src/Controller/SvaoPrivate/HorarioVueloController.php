<?php

namespace App\Controller\SvaoPrivate;

use App\Entity\SvaoPrivate\Aerolinea;
use App\Entity\SvaoPrivate\HorarioVuelo;
use App\Entity\SvaoPrivate\Aeropuerto;

use App\Form\SvaoPrivate\HorarioVueloType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class HorarioVueloController extends AbstractController
{
    /**
     * @Route("/svao/aerolineas/horariovuelo", name="horariosva.index")
     */
    public function index( UserInterface $user)
    {
        $entityManager=$this->getDoctrine()->getManager();
        if($user->getAerolinea()==null){
            $this->addFlash('danger','No puedes acceder a la url, no tienes asignado una aerolinea.');
            return $this->redirectToRoute('homesvao');
        }
        $aerolinea=$entityManager->getRepository(Aerolinea::class)->find($user->getAerolinea());

        $list=$this->getDoctrine()
                ->getRepository(HorarioVuelo::class)
                ->findBy([
                    'aerolinea'=>$aerolinea,
                    'estado'=>true,
                    ]);


        return $this->render('private/horariosvuelos/index.html.twig',[
            'aerolinea'=>$aerolinea,
            'list'=>$list
        ]);
    }

    /**
     * @Route("/svao/aeropuerto/horariovuelo", name="horario_aeropuerto.index")
     */
    public function aeropuertoIndex( UserInterface $user)
    {
        $entityManager=$this->getDoctrine()->getManager();
        if($user->getAeropuerto()==null){
            $this->addFlash('danger','No puedes acceder a la url, Contacta al administrador del sistema.');
            return $this->redirectToRoute('homesvao');
        }
        $aeropuerto=$entityManager->getRepository(Aeropuerto::class)->find($user->getAeropuerto());

        $list=$this->getDoctrine()
            ->getRepository(HorarioVuelo::class)
            ->findBy([
                'aeropuerto'=>$aeropuerto,
                'estado'=>true,
            ]);


        return $this->render('private/horariosvuelos/aeropuertoIndex.html.twig',[
            'aeropuerto'=>$aeropuerto,
            'list'=>$list
        ]);
    }

    /**
     * @Route("/aerolineas/horariosvuelos/create", name="horariosv.create",methods={})
     */
    public function create(UserInterface $user)
    {
        $horario=new HorarioVuelo();

        $form=$this->createForm(HorarioVueloType::class,
            $horario,
            [   'method'=>'POST',
                'action'=>$this->generateUrl('horariosv.store')
            ]);

        $view=$this->renderView('private/horariosvuelos/horario.html.twig',
            [
                'form'=>$form->createView(),
            ]);

        return $this->json([
            'status'=>'success',
            'html'=>$view
        ]);
    }

    /**
     * @Route("aerolineas/horariosvuelos/store", name="horariosv.store",methods={"POST"})
     */
    public function store(Request $request,UserInterface $user)
    {
        $entityManager=$this->getDoctrine()->getManager();

        $aerolinea=$entityManager->getRepository(Aerolinea::class)->find($user->getAerolinea());

        $obj=new HorarioVuelo();
        $form=$this->createForm(HorarioVueloType::class,$obj,[
            'action'=>$this->generateUrl('horariosv.store'),
            'method'=>'POST'
        ]);

        $form->handleRequest($request);

        if($form->isValid())
        {
            $obj=$form->getData();
            $obj->setTipo('out');
            $obj->setAerolinea($aerolinea);
            $obj->setEstado(true);
            try{
                $entityManager->persist($obj);
                $entityManager->flush();
                $this->addFlash('success',"Recurso almacenado exitosamente");
                return $this->redirect($this->generateUrl('horariosva.index'));
            }catch (Exception $e){
                $this->addFlash('danger',$e->getMessage());
            }
        }else{
            $list=null;
            $form=$this->renderView('private/horariosvuelos/index.html.twig',
                [
                    'form'=>$form->createView(),
                ]);

            return $this->render('private/aerolineas/vuelos/vuelos.html.twig', [
                'list'=>$list,
                'form'=>$form
            ]);
        }
    }

    /**
     * @Route("aerolineas/horariosvuelos/{horario}/edit",name="horariosv.edit",methods="GET")
     * @param HorarioVuelo $horario
     */
    public function edit(HorarioVuelo $horario)
    {
        $form=$this->createForm(HorarioVueloType::class,
            $horario,
            [   'method'=>'POST',
                'action'=>$this->generateUrl('horariosv.update',['horario'=>$horario->getId()])
            ]);

        $view=$this->renderView('private/horariosvuelos/horario.html.twig',
            [
                'form'=>$form->createView(),
            ]);

        return $this->json([
            'status'=>'success',
            'html'=>$view
        ]);
    }

    /**
     * @Route("aerolineas/horariosvuelos/{horario}/edit",name="horariosv.update",methods="POST")
     * @param HorarioVuelo $horario
     */
    public function update(Request $request,HorarioVuelo $horario,UserInterface $user)
    {
        $entityManager=$this->getDoctrine()->getManager();

        $form=$this->createForm(HorarioVueloType::class,$horario,
            [   'method'=>'POST',
                'action'=>$this->generateUrl('horariosv.update',['horario'=>$horario->getId()])
            ]);

        $form->handleRequest($request);

        if($form->isValid()){
            try{
                $horario=$form->getData();
                $entityManager->flush();
                $this->addFlash('success','Registro actualizado correctamente.');
            }catch (Exception $e){
                $this->addFlash('danger',$e->getMessage());
            }
            return $this->redirect($this->generateUrl('horariosva.index'));
        }

        //Simulamos ir al index
        $aerolinea=$entityManager->getRepository(Aerolinea::class)->find($user->getAerolinea());
        $list=$this->getDoctrine()
            ->getRepository(HorarioVuelo::class)
            ->findBy(['estado'=>true,'aerolinea'=>$aerolinea->getAerolinea()]);

        $form=$this->renderView('private/horariosvuelos/horario.html.twig',
            [
                'form'=>$form->createView(),
            ]);

        return $this->render('private/aerolineas/vuelos/vuelos.html.twig', [
            'aerolinea' => $aerolinea,
            'list'=>$list,
            'form'=>$form
        ]);
    }


    /**
     * @Route("aerolineas/horariosvuelos/{horario}/delete",name="horariosv.delete",methods="GET")
     * @param HorarioVuelo $horario
     */
    public function delete(HorarioVuelo $horario)
    {

        $form=$this->createForm(HorarioVueloType::class,
            $horario,
            [   'method'=>'POST',
                'action'=>$this->generateUrl('horariosv.trash',['horario'=>$horario->getId()])
            ]);

        $view=$this->renderView('private/horariosvuelos/horario.html.twig',
            [
                'form'=>$form->createView(),
                'delete'=>true
            ]);

        return $this->json([
            'status'=>'success',
            'html'=>$view
        ]);
    }

    /**
     * @Route("aerolineas/horariosvuelos/{horario}/delete",name="horariosv.trash",methods="POST")
     * @param HorarioVuelo $horario
     */
    public function trash(HorarioVuelo $horario)
    {
        try {
            $entityManager=$this->getDoctrine()->getManager();
            $horario->setEstado(false);
            $entityManager->flush();
            $this->addFlash('warning',"Eliminacion realizada correctamente");
        }catch (\Exception $e){
            $this->addFlash('danger',$e->getMessage());
        }
        return $this->redirect($this->generateUrl('horariosva.index'));
    }
/**=====================================================================================================================
 *  Funciones que utiliza el administrador de aeropuerto. ==============================================================
 * =====================================================================================================================
 */

    /**
     * @Route("aerolineas/horariosvuelos/{horario}/editv",name="horariosv.editv",methods="GET")
     * @param HorarioVuelo $horario
     */
    public function editVuelo(HorarioVuelo $horario)
    {
        $form=$this->createForm(HorarioVueloType::class,
            $horario,
            [
                'opt'=>'arp',
                'method'=>'POST',
                'action'=>$this->generateUrl('horariosv.update',['horario'=>$horario->getId()])
            ]);

        $view=$this->renderView('private/horariosvuelos/horario.html.twig',
            [
                'form'=>$form->createView(),
            ]);

        return $this->json([
            'status'=>'success',
            'html'=>$view
        ]);
    }
}
