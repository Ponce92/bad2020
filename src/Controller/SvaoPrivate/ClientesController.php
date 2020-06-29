<?php

namespace App\Controller\SvaoPrivate;


use App\Entity\Rol;
use App\Entity\SvaoPrivate\Reserva;
use App\Entity\SvaoProtected\Usuario;
use App\Form\SvaoPrivate\ClienteEmpresarialType;
use App\Form\SvaoPrivate\ClienteNaturalType;

use App\Security\User;
use mysql_xdevapi\Exception;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\SvaoPrivate\Cliente;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class ClientesController extends AbstractController
{
    /**
     * @Route("/svao/private/list/clientes", name="clientes.list",methods={"GET",})
     */
    public function index()
    {
        $list=$this->getDoctrine()
            ->getRepository(Cliente::class)
            ->findAll();

        return $this->render('private/clientes/clientes.html.twig', [
            'list' => $list,
        ]);
    }

    /**
     * @Route("/svao/private/clientes/create/natural", name="clientes.create.natural")
     */
    public function createNatural()
    {
        $cliente=new Cliente();

        $form=$this->createForm(ClienteNaturalType::class,$cliente,[
                'action'=>$this->generateUrl('clientes.store.natural'),
                'method'=>'POST'
                                                                        ]);

        $partitial=$this->renderView('private/clientes/create.html.twig',[
            'form'=>$form->createView(),
        ]);

        return $this->render('public/cliente.html.twig',[
                'form'=>$partitial
        ]);
    }

    /**
     * @Route("/svao/private/clientes/create/empresarial", name="clientes.create.empresarial")
     */
    public function createEmpresarial(Request $request)
    {
        $cliente=new Cliente();

        $form=$this->createForm(ClienteEmpresarialType::class,$cliente,[
            'action'=>$this->generateUrl('clientes.store.empresarial'),
            'method'=>'POST'
        ]);

        $partitial=$this->renderView('private/clientes/createEmpresarial.html.twig',[
            'form'=>$form->createView(),
        ]);

        return $this->render('public/cliente.html.twig',[
            'form'=>$partitial
        ]);
    }

    /**
     * @Route("/svao/private/clientes/store/enterprise", name="clientes.store.empresarial",methods={"POST",})
     */
    public function storeEmpresarial(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user=new Usuario();
        $rol=$entityManager->getRepository(Rol::class)->find(4);
        $cli=new Cliente();
        $form=$this->createForm(ClienteEmpresarialType::class,$cli,[
            'action'=>$this->generateUrl('clientes.store.empresarial'),
            'method'=>'POST'
        ]);

        $form->handleRequest($request);
        if($form->isValid())
        {
            $user->setNombre($form->get('email')->getData());
            $user->setPassword($form->get('password')->getData());
            $user->setRol($rol);
            $user->setfechaEdicion( new DateTime());
            $user->setFechaCreacion(new DateTime());
            $user->setFechaUltimoAcesso( new DateTime());

            $cli=$form->getData();
            try{
                $entityManager->persist($cli);
                $entityManager->persist($user);
                $entityManager->flush();
                $this->addFlash('success','Cuenta generada exitosamente.');
                $this->addFlash('info','Ya puedes loguearte para comezar .');
                }catch (Exception $e){
                $this->addFlash('danger',$e->getMessage());
                return $this->redirect('clientes.create.empresarial');
                $status="transaccion_error";
                }
            $this->addFlash('warning','Ya puedes loguearte para comezar .');
            $this->addFlash('success','Tu cueta ha sido creada satisfactoriamente');

            return $this->render('public/clienteInfo.html.twig',[
                'cliente'=>$cli,
                'tipo'=>'empresarial'
            ]);
        }else{
            $formView=$this->renderView('private/clientes/createEmpresarial.html.twig',[
                'form'=>$form->createView(),

            ]);
            return $this->render('public/cliente.html.twig',[
                'form'=>$formView
            ]);
        }

    }
    /**
     * @Route("/svao/private/clientes/store/natural", name="clientes.store.natural")
     */
    public function storeNatural(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $cli=new Cliente();
        $user=new Usuario();
        $rol=$entityManager->getRepository(Rol::class)->find(4);
        $form=$this->createForm(ClienteNaturalType::class,$cli,['action'=>$this->generateUrl('clientes.store.natural'),
            'method'=>'POST'
                        ]);
        $form->handleRequest($request);
        if($form->isValid())
        {
            $user->setNombre($form->get('email')->getData());
            $user->setPassword($form->get('password')->getData());
            $user->setRol($rol);
            $user->setfechaEdicion( new DateTime());
            $user->setFechaCreacion(new DateTime());
            $user->setFechaUltimoAcesso( new DateTime());

            $cli=$form->getData();


            try{
                $cli->setViajeroFrecuente(bin2hex(random_bytes(5 )));
                $entityManager->persist($cli);
                $entityManager->persist($user);
                $entityManager->flush();
            }catch (\Exception $e){
                $this->addFlash('danger','Un error grabe a ocurrid, porfavor intenta nuevamente');
                return $this->redirectToRoute('clientes.create.natural');
            }
            $this->addFlash('warning','Ya puedes loguearte para comezar .');
            $this->addFlash('success','Tu cueta ha sido creada satisfactoriamente');

            return $this->render('public/clienteInfo.html.twig',[
                'cliente'=>$cli,
                'tipo'=>'natural'
            ]);

        }else{
            $formView=$this->renderView('private/clientes/create.html.twig',[
                'form'=>$form->createView(),
            ]);

            return $this->render('public/cliente.html.twig',[
                'form'=>$formView
            ]);
        }
    }

    /**
     * @Route("/svao/private/clientes/edit/{id}", name="clientes.edit")
     */
    public function edit(int $id)
    {
        $cliente = $this->getDoctrine()
            ->getRepository(Cliente::class)
            ->find($id);

        if($cliente->getTipoDoc()!=null){

            $form=$this->createForm(ClienteNaturalType::class,$cliente,[
                'action'=>$this->generateUrl('clientes.natural.update',['id'=>$id]),
                'method'=>'POST',
            ]);

            $view=$this->renderView('private/clientes/editClienteNatural.html.twig',[
                'form'=>$form->createView(),
                'id'=>$id,
            ]);

        }else{

            $form=$this->createForm(ClienteEmpresarialType::class,$cliente,[
                'action'=>$this->generateUrl('clientes.empresarial.update',['id'=>$id]),
                'method'=>'POST',
            ]);

            $view=$this->renderView('private/clientes/editClienteEmpresarial.html.twig',[
                'form'=>$form->createView(),
                'id'=>$id,
            ]);

        }

        return $this->json([
            'status'=>'success',
            'html'=>$view
        ]);
    }

    /**
     * @Route("/svao/private/clientes/updaten/{id}", name="clientes.natural.update",methods={"POST"})
     *
     */

    public function naturalUpdate(Request $request,int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $obj=$entityManager->getRepository(Cliente::class)->find($id);

        $form=$this->createForm(ClienteNaturalType::class,$obj,[
            'action'=>$this->generateUrl('clientes.natural.update',['id'=>$id]),
            'method'=>'POST',
        ]);

        $form->handleRequest($request);

        if($form->isValid()){
            try {
                $obj=$form->getData();
                $entityManager->flush();
                $view='Cliente actualizado correctamente';
                $status='success';
            }catch (Exception $e){
                $status='transaccion_error';
            }
        }else{
            $status="form_erors";
            $view=$this->renderView('private/clientes/editClienteNatural.html.twig',[
                'form'=>$form->createView(),
                'id'=>$id,
            ]);
        }

        return $this->json([
            'status'=>$status,
            'html'=>$view,
        ]);
    }

    /**
     * @Route("/svao/private/clientes/updatee/{id}", name="clientes.empresarial.update", methods={"POST"})
     *
     */
    public function empresarialUpdate(Request $request, int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $obj=$entityManager->getRepository(Cliente::class)->find($id);

        $form=$this->createForm(ClienteEmpresarialType::class,$obj,[
            'action'=>$this->generateUrl('clientes.empresarial.update',['id'=>$id]),
            'method'=>'POST',
        ]);

        $form->handleRequest($request);

        if($form->isValid()){
            $obj=$form->getData();
            try {
                $entityManager->flush();
                $view='Cliente actualizado correctamente';
                $status='success';
            }catch (Exception $e){
                $status='transaccion_error';
            }
        }else{
            $status="form_erors";
            $view=$this->renderView('private/clientes/editClienteEmpresarial.html.twig',[
                'form'=>$form->createView(),
                'id'=>$id,
            ]);
        }

        return $this->json([
            'status'=>$status,
            'html'=>$view,
        ]);

    }
    /**
     * @Route("/svao/private/clientes/delete/{id}", name="clientes.delete", methods={"GET"})
     *
     */
    public function delete(int $id)
    {
        $cliente = $this->getDoctrine()
            ->getRepository(Cliente::class)
            ->find($id);


        $view=$this->renderView('private/clientes/delete.html.twig',[
            'cliente'=>$cliente,
        ]);

        return $this->json([
            'status'=>'success',
            'html'=>$view
        ]);
    }
    /**
     * @Route("/svao/private/clientes/destroy/{id}", name="clientes.destroy", methods={"GET"})
     *
     */
    public function destroy(int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $obj = $this->getDoctrine()
            ->getRepository(Cliente::class)
            ->find($id);


        try {
            $entityManager->remove($obj);
            $entityManager->flush();

            $view="";
            $status='reload';

        }catch (\Exception $e){
            $status='transac_error';
        }

        return $this->json([
            'status'=>$status,
            'html'=>$view
        ]);
    }

    /**
     * @Route("/svao/private/vuelos/clientes", name="clientes.historico", methods={"GET"})
     *
     */

    public function historico(UserInterface $user)
    {
        $em=$this->getDoctrine()->getRepository(Reserva::class);
        $cliente=$this->getDoctrine()->getRepository(Cliente::class)->find($user->getCliente());

        $reservas=$em->findBy([
            'cliente'=>$cliente,
        ]);

        return $this->render('private/clientes/vuelos/historico.html.twig', [
            'list' => $reservas,
        ]);
    }

}
