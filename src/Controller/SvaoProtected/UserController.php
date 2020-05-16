<?php

namespace App\Controller\SvaoProtected;

use App\Entity\Rol;
use App\Form\SvaoProtected\EditUserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\SvaoProtected\Usuario;
use App\Form\SvaoProtected\UserType;
use DateTime;

class UserController extends AbstractController
{
    /**
     * @Route("/svao/protected/usuarios", name="usuarios.index")
     */
    public function index(Request $request)
    {
        $list=$this->getDoctrine()
            ->getRepository(Usuario::class)
            ->findAll();

        return $this->render('protected/usuarios/usuarios.html.twig', [
            'list' => $list,
        ]);
    }


    /**
     * @Route("/svao/protected/usuarios/create",name="usuarios.create",methods={"GET",})
     */
    public function create(Request $request){

        $user=New Usuario();
        $form=$this->createForm(UserType::class,
            $user,
            [   'method'=>'POST',
                'action'=>$this->generateUrl('usuarios.store')
            ]);


        $view=$this->renderView('protected/usuarios/create.html.twig',[
            'form'=>$form->createView(),
        ]);

        return $this->json([
            'status'=>'success',
            'html'=>$view
        ]);

    }
    /**
     * @Route("svao/protected/usuarios/store",name="usuarios.store",methods={"POST",})
     */
    public function store(Request $request){
        $entityManager=$this->getDoctrine()->getManager();
        $user=new Usuario();
        $form=$this->createForm(UserType::class,$user,[
            'action'=>$this->generateUrl('usuarios.store'),
            'method'=>'POST'
        ]);

        $form->handleRequest($request);

        if($form->isValid())
        {
            $user=$form->getData();
            $user->setfechaEdicion( new DateTime());
            $user->setFechaCreacion(new DateTime());
            $user->setFechaUltimoAcesso( new DateTime());

            $status="success";
            try{
                $entityManager->persist($user);
                $entityManager->flush();

            }catch (Exception $e){
                $status="transaccion_error";
            }
            $user=new Usuario();

            $form=$this->createForm(UserType::class,$user,[
                'action'=>$this->generateUrl('usuarios.store'),
                'method'=>'POST'
            ]);
            $view=$this->renderView('protected/usuarios/create.html.twig',[
                'form'=>$form->createView(),
            ]);

        }else{

            $status="form_errors";
            $view=$this->renderView('protected/usuarios/create.html.twig',[
                'form'=>$form->createView(),
            ]);
        }
        return $this->json([
            'status'=>$status,
            'html'=>$view,
        ]);


    }

    /**
     * @Route("svao/private/usuarios/edit/{id}",name="protected.usuarios.edit",methods={"GET",})
     */
    public function edit(int $id)
    {
        $user = $this->getDoctrine()
            ->getRepository(Usuario::class)
            ->find($id);

        $form=$this->createForm(EditUserType::class,$user,[
            'action'=>$this->generateUrl('protected.usuarios.update',['id'=>$id]),
            'method'=>'PUT',
        ]);

        $view=$this->renderView('protected/usuarios/edit.html.twig',[
            'form'=>$form->createView(),
            'id'=>$id,
        ]);

        return $this->json([
            'status'=>'success',
            'html'=>$view
        ]);

    }


    /**
     * @Route("svao/protected/usuarios/update/{id}",name="protected.usuarios.update",methods={"PUT",})
     */
    public function update(Request $request,int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $usuario=$entityManager->getRepository(Usuario::class)->find($id);

        $form=$this->createForm(EditUserType::class,$usuario,[
            'action'=>$this->generateUrl('protected.usuarios.update',['id'=>$id]),
            'method'=>'PUT',
        ]);

        $form->handleRequest($request);

        if($form->isValid()){
            try {
                $usuario=$form->getData();
                $entityManager->flush();

                $view='Usuario actualizado correctamente';
                $status='success';
            }catch (Exception $e){
                $status='transaccion_error';
            }
        }else{
            $status="form_erors";
            $view=$this->renderView('protected/usuarios/edit.html.twig',[
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
     * @Route("svao/protected/usuarios/delete/{id}",name="usuaios.delete",methods={"GET",})
     */
    public function delete(int $id)
    {
        $usuario = $this->getDoctrine()
            ->getRepository(Usuario::class)
            ->find($id);


        $view=$this->renderView('protected/usuarios/delete.html.twig',[
            'user'=>$usuario,
        ]);

        return $this->json([
            'status'=>'success',
            'html'=>$view
        ]);
    }


    /**
     * @Route("svao/protected/usuarios/destroy/{id}",name="usuarios.destroy",methods={"GET",})
     */

    public function destroy(int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $obj = $this->getDoctrine()
            ->getRepository(Usuario::class)
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
