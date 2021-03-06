<?php

namespace App\Controller\SvaoPrivate;


use App\Entity\SvaoPrivate\Aerolinea;
use App\Entity\SvaoPrivate\Cliente;
use App\Form\SvaoPrivate\AeropuertoType;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\DataTableFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Validator\Constraints\Form;
use Symfony\Component\Routing\Annotation\Route;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use App\Entity\SvaoPrivate\Aeropuerto;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;


class AeropuertosController extends AbstractController
{
    /**
     * @Route("/svao/private/aeropuertos", name="aeropuertos.list")
     */
    public function index(Request $request,UserInterface $user)
    {
        if($user->getAeropuerto()==null){
            $this->addFlash('danger','No puedes acceder a la url, no tienes asignado una aerolinea.');
            return $this->redirectToRoute('homesvao');
        }
        $aeropuerto=$this->getDoctrine()->getRepository(Aeropuerto::class)->find($user->getAeropuerto());

        $list=$this->getDoctrine()
            ->getRepository(Aeropuerto::class)
        ->findBy(['estado'=>true]);

        return $this->render('private/aeropuerto/aeropuertos.html.twig',[
            'list'=>$list,
            'aeropuerto'=>$aeropuerto
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
            $aeropuerto->setEstado(true);
            $code=$entityManager->getRepository(Aeropuerto::class)->getCode($form->get('pais')->getData());
            $aeropuerto->setCodigo($code['fn_generate_code_aeropuertos']);

            try{
                $entityManager->persist($aeropuerto);
                $entityManager->flush();

            }catch (Exception $e){
                $this->addFlash('danger',"El sistema no logro completar la transaccion");
            }

            $list=$this->getDoctrine()
                ->getRepository(Aeropuerto::class)
                ->findAll();

            $this->addFlash('success',"Transaccion completada exitosamente");

            return $this->render('private/aeropuerto/aeropuertos.html.twig',[
                'list'=>$list,
            ]);

        }else{
            $list=$this->getDoctrine()
                ->getRepository(Aeropuerto::class)
                ->findAll();
            return $this->render('private/aeropuerto/aeropuertos.html.twig',[
                'list'=>$list,
                'form'=>$form->createView()
            ]);

        }
    }

    /**
     * @Route("/svao/private/aeropuertos/{id}/edit", name="aeropuertos.edit",methods={"GET",})
     */
    public function edit(int $id)
    {
        $aeropuerto = $this->getDoctrine()
            ->getRepository(Aeropuerto::class)
            ->find($id);

        $form=$this->createForm(AeropuertoType::class,$aeropuerto,[
            'action'=>$this->generateUrl('aeropuertos.update',['id'=>$id]),
            'method'=>'POST',
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
     * @Route("/svao/private/aeropuertos/update/{id}", name="aeropuertos.update",methods={"POST",})
     */
    public function update(Request $request,int $id){

        $entityManager = $this->getDoctrine()->getManager();
        $aeropuerto=$entityManager->getRepository(Aeropuerto::class)->find($id);

        $form=$this->createForm(AeropuertoType::class,
            $aeropuerto,
            [   'method'=>'POST',
                'action'=>$this->generateUrl('aeropuertos.update',['id'=>$id])
            ]);

        $form->handleRequest($request);
        if($form->isValid()){
            try{
                $aeropuerto=$form->getData();
                $entityManager->flush();
                $this->addFlash('success','Aerolinea actualizada correctamente');

            }catch (Exception $e){
                $this->addFlash('danger',"El sistema fracaso al completar latransaccion");
            }
            return $this->redirect($this->generateUrl('aeropuertos.list'));
        }

        $list=$this->getDoctrine()
            ->getRepository(Aeropuerto::class)
            ->findAll();


        return $this->render('private/aeropuerto/aeropuertos.html.twig',['list'=>$list,'form'=>$form->createView()]);
    }

    /**
     * @Route("/svao/private/aeropuertos/{id}/delete", name="aeropuertos.delete",methods={"GET",})
     */
    public function delete($id)
    {
        $aeropuerto = $this->getDoctrine()
            ->getRepository(Aeropuerto::class)
            ->find($id);

        $form=$this->createForm(AeropuertoType::class,$aeropuerto,[
            'action'=>$this->generateUrl('aeropuertos.trash',['id'=>$id]),
            'method'=>'POST',
        ]);

        $view=$this->renderView('private/aeropuerto/create.html.twig',[
            'form'=>$form->createView(),
            'accion'=>'delete',
        ]);

        return $this->json([
            'status'=>'success',
            'html'=>$view
        ]);

    }

    /**
     * @Route("/svao/private/aeropuertos/{id}/trash", name="aeropuertos.trash",methods={"POST",})
     */
    public function trash(int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $aeropuerto=$entityManager->getRepository(Aeropuerto::class)
            ->find($id);
        $aeropuerto->setEstado(false);

        $entityManager->flush();

        $this->addFlash('info','Elemento eliminado correctamente.');
        return $this->redirect($this->generateUrl('aeropuertos.list'));

    }
}
