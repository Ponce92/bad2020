<?php

namespace App\Controller\SvaoPrivate;


use App\Entity\Rol;
use App\Form\SvaoPrivate\ClienteEmpresarialType;
use App\Form\SvaoPrivate\ClienteNaturalType;

use mysql_xdevapi\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\SvaoPrivate\Cliente;
use Symfony\Component\HttpFoundation\Request;

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

        $view=$this->renderView('private/clientes/create.html.twig',[
            'form'=>$form->createView(),
        ]);

        return $this->json([
            'status'=>'success',
            'html'=>$view
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

        $view=$this->renderView('private/clientes/createEmpresarial.html.twig',[
            'form'=>$form->createView(),
        ]);

        return $this->json([
            'status'=>'success',
            'html'=>$view
        ]);
    }

    /**
     * @Route("/svao/private/clientes/store/enterprise", name="clientes.store.empresarial",methods={"POST",})
     */
    public function storeEmpresarial(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $cli=new Cliente();
        $form=$this->createForm(ClienteEmpresarialType::class,$cli,[
            'action'=>$this->generateUrl('clientes.store.empresarial'),
            'method'=>'POST'
        ]);

        $form->handleRequest($request);
        if($form->isValid())
        {
            $cli=$form->getData();
            $status='success';
            try{
                $entityManager->persist($cli);
                $entityManager->flush();

                }catch (Exception $e){$status="transaccion_error";}

            $view="...";

        }else{
            $status="form_errors";

            $view=$this->renderView('private/clientes/createEmpresarial.html.twig',[
                'form'=>$form->createView(),
            ]);
        }

        return $this->json([
            'status'=>$status,
            'html'=>$view,
        ]);

    }
    /**
     * @Route("/svao/private/clientes/store/natural", name="clientes.store.natural")
     */
    public function storeNatural(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $cli=new Cliente();
        $form=$this->createForm(ClienteNaturalType::class,$cli,['action'=>$this->generateUrl('clientes.store.natural'),
            'method'=>'POST'
                        ]);
        $form->handleRequest($request);

        if($form->isValid())
        {
            $cli=$form->getData();
            $status="success";
            try{
                $entityManager->persist($cli);
                $entityManager->flush();

            }catch (Exception $e){$status="transaccion_error";}
            $cli=new Cliente();
            $form=$this->createForm(ClienteNaturalType::class,$cli);

            $view=$this->renderView('private/clientes/create.html.twig',[
                'form'=>$form->createView(),
            ]);

        }else{
            $status="form_errors";

            $view=$this->renderView('private/clientes/create.html.twig',[
                'form'=>$form->createView(),
            ]);
        }

        return $this->json([
            'status'=>$status,
            'html'=>$view,
        ]);
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


}
