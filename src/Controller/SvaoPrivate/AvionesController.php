<?php

namespace App\Controller\SvaoPrivate;

use App\Entity\SvaoPrivate\Aerolinea;
use App\Entity\SvaoPrivate\Avion;
use App\Form\SvaoPrivate\AvionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class AvionesController extends AbstractController
{
    /**
     * @Route("/svao/private/aerolinea/aviones", name="aviones.index")
     */
    public function index(Request $request, UserInterface $user)
    {
        $aeId=$user->getAerolinea();
        if($aeId==null){
            $this->addFlash('danger','No puedes acceder a la url, no tienes asignado una aerolinea.');
            return $this->redirectToRoute('homesvao');
        }
        $aerolinea=$this->getDoctrine()->getRepository(Aerolinea::class)->find($aeId);
        $list=$this->getDoctrine()
                ->getRepository(Avion::class)
                ->findBy(
                    ['estado'=>true,'aerolinea'=>$aerolinea]
                );

        return $this->render('private/aerolineas/aviones/index.html.twig', [
            'aerolinea' => $aerolinea,
            'list'=>$list
        ]);
    }
    /**
     * @Route("/svao/private/aerolinea/{aerolinea}/aviones/create", name="aviones.create")
     * @param Aerolinea $aerolinea
     */
    public function create(Request  $request, Aerolinea $aerolinea)
    {
        $form=$this->createForm(AvionType::class,
            new Avion(),
            [   'method'=>'POST',
                'action'=>$this->generateUrl('aviones.store',['aerolinea'=>$aerolinea->getId()])
            ]);

        $view=$this->renderView('private/aerolineas/aviones/avion.html.twig',
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
     * @Route("/svao/private/aerolinea/{aerolinea}/aviones/store", name="aviones.store")
     * @param Aerolinea $aerolinea
     */
    public function store(Request $request,Aerolinea $aerolinea)
    {
        $entityManager=$this->getDoctrine()->getManager();

        $obj=new Avion();
        $form=$this->createForm(AvionType::class,$obj,[
            'action'=>$this->generateUrl('aviones.store',['aerolinea'=>$aerolinea->getId()]),
            'method'=>'POST'
        ]);

        $form->handleRequest($request);

        if($form->isValid())
        {
            $obj=$form->getData();
            $em=$this->getDoctrine()
                ->getRepository(Avion::class)
                ->getCode($aerolinea,$form->get('tipo')->getData());

            $obj->setCodigo($em['fn_generate_code_avion']);
            $obj->setEstado(true);
            $obj->setAerolinea($aerolinea);

            try{
                $entityManager->persist($obj);
                $entityManager->flush();
                $this->addFlash('success',"Recurso almacenado exitosamente");
                return $this->redirect($this->generateUrl('aviones.index',['aerolinea'=>$aerolinea->getId()]));
            }catch (Exception $e){
                $this->addFlash('danger',$e->getMessage());
            }
        }else{

            $list=$this->getDoctrine()
                ->getRepository(Avion::class)
                ->findAll();

            return $this->render('private/aerolineas/aviones/index.html.twig', [
                'aerolinea' => $aerolinea,
                'list'=>$list,
                'form'=>$form->createView()
            ]);
        }
    }

    /**
     * @Route("/svao/private/aerolinea/aviones/{avion}/edit", name="aviones.edit",methods={"GET"})
     * @param Avion $avion
     */

    public function edit(Avion $avion)
    {
        $form=$this->createForm(AvionType::class,
            $avion,
            [   'method'=>'POST',
                'action'=>$this->generateUrl('aviones.update',['avion'=>$avion->getId()])
            ]);

        $view=$this->renderView('private/aerolineas/aviones/avion.html.twig',
            [
                'form'=>$form->createView(),
                'aerolinea'=>$avion->getAerolinea(),
            ]);

        return $this->json([
            'status'=>'success',
            'html'=>$view
        ]);
    }

    /**
     * @Route("/svao/private/aerolinea/aviones/{avion}/update", name="aviones.update")
     * @param Avion $avion
     * @param Request $request
     */

    public function update(Request $request ,Avion $avion)
    {
        $entityManager=$this->getDoctrine()->getManager();

        $form=$this->createForm(AvionType::class,$avion,
            [   'method'=>'POST',
                'action'=>$this->generateUrl('aviones.update',['avion'=>$avion->getId()])
            ]);

        $form->handleRequest($request);
        if($form->isValid()){
            try{
                $avion=$form->getData();
                $entityManager->flush();
                $this->addFlash('success','Registro actualizado correctamente.');
            }catch (Exception $e){
                $this->addFlash('danger',$e->getMessage());
            }
            return $this->redirect($this->generateUrl('aviones.index',['aerolinea'=>$avion->getAerolinea()->getId()]));
        }

        //Simulamos ir al index
        $list=$this->getDoctrine()
            ->getRepository(Avion::class)
            ->findBy(['aerolinea_id'=>$avion->getAerolinea()->getId()]);


        return $this->render('private/aerolineas/aviones/index.html.twig', [
            'aerolinea' => $avion->getAerolinea(),
            'list'=>$list,
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("scvao/private/aerolinea/aviones/{avion}/delete",name="aviones.delete",methods={"GET"})
     * @param Avion $avion
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     *
     */
    public function delete(Avion $avion)
    {
        $form=$this->createForm(AvionType::class,
            $avion,
            [   'method'=>'POST',
                'action'=>$this->generateUrl('aviones.trash',['avion'=>$avion->getId()])
            ]);

        $view=$this->renderView('private/aerolineas/aviones/avion.html.twig',
            [
                'form'=>$form->createView(),
                'aerolinea'=>$avion->getAerolinea(),
                'delete'=>true
            ]);

        return $this->json([
            'status'=>'success',
            'html'=>$view
        ]);

    }
    /**
     * @Route("scvao/private/aerolinea/aviones/{avion}/trash",name="aviones.trash",methods={"post"})
     * @param Avion $avion
     *
     */
    public function trash(Request $request, Avion $avion)
    {
        try {
            $entityManager=$this->getDoctrine()->getManager();
            $avion->setEstado(false);
            $entityManager->flush();
            $this->addFlash('success',"Eliminacion realizada correctamente");
        }catch (\Exception $e){
            $this->addFlash('danger',$e->getMessage());
        }
        return $this->redirect($this->generateUrl('aviones.index',['aerolinea'=>$avion->getAerolinea()->getId()]));
    }
}
