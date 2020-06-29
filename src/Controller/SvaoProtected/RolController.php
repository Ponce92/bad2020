<?php

namespace App\Controller\SvaoProtected;

use App\Form\SvaoProtected\RolType;
use App\Repository\RolRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Rol;
use App\Entity\SvaoProtected\Permiso;

class RolController extends AbstractController
{

    /**
     * @Route("/svao/protected/roles", name="index_rol")
     */
    public function index(Request $request)
    {
        $list=$this->getDoctrine()
                    ->getRepository(Rol::class)
                    ->findAll();
        return $this->render('protected/rol/roles.html.twig', [
            'list' => $list,
        ]);
    }

    /**
     * @Route("svao/protected/roles/create", name="roles.create")
     */
    public function create(){
        $rol= new Rol();

        $form=$this->createForm(RolType::class,$rol,[
            'action'=>$this->generateUrl('roles.store'),
            'method'=>'POST',
        ]);

        $view=$this->renderView('protected/rol/create.html.twig',[
                    'form'=>$form->createView(),
                ]);

        return $this->json([
                'status'=>'success',
                'html'=>$view
            ]);
    }
    /**
     * @Route("svao/store/rol",name="roles.store",methods={"POST",})
     */
    public function store(Request $request){
        $entityManager = $this->getDoctrine()->getManager();
        $rol=new Rol();

        $form=$this->createForm(RolType::class,$rol,[
            'action'=>$this->generateUrl('roles.store'),
            'method'=>'POST',
        ]);

        $form->handleRequest($request);

        if($form->isValid()){
            $rol=$form->getData();
            try {
                $entityManager->persist($rol);
                $entityManager->flush();

            }catch (Exception $e){
                //..
            }
            $rol2=new Rol();
            $form=$this->createForm(RolType::class,$rol2);
            $status="success";
            $view=$this->renderView('protected/rol/create.html.twig',[
                'form'=>$form->createView(),
            ]);
        }else{
            $status="form_erors";
            $view=$this->renderView('protected/rol/create.html.twig',[
                            'form'=>$form->createView(),
            ]);
        }
        return $this->json([
                    'status'=>$status,
                    'html'=>$view,
        ]);
    }


    /**
     * @Route("svao/protected/edit/{id}",name="roles.edit",methods={"GET"})
     */
    public function edit(int $id){

        $rol = $this->getDoctrine()
            ->getRepository(Rol::class)
            ->find($id);

        $form=$this->createForm(RolType::class,$rol,[
                                    'action'=>$this->generateUrl('roles.update',['id'=>$id]),
                                    'method'=>'PUT',
                                ]);

        $view=$this->renderView('protected/rol/edit.html.twig',[
                                    'form'=>$form->createView(),
                                    'id'=>$id,
                                ]);

        return $this->json([
            'status'=>'success',
            'html'=>$view
        ]);
    }
    /**
     * @Route("svao/protected/roles/update/{id}",name="roles.update",methods={"PUT"})
     */
    public function update(Request $request, int $id){
        $entityManager = $this->getDoctrine()->getManager();
        $rol=$entityManager->getRepository(Rol::class)->find($id);

        $form=$this->createForm(RolType::class,$rol,[
                'action'=>$this->generateUrl('roles.update',['id'=>$id]),
                'method'=>'PUT'
            ]);

        $form->handleRequest($request);

        if($form->isValid()){
            try {
                $rol=$form->getData();
                $entityManager->flush();

            }catch (Exception $e){

                $status='transaccion_error';
            }
            $rol2=new Rol();
            $newForm=$this->createForm(RolType::class,$rol2,[
                    'action'=>$this->generateUrl('roles.store'),
                    'method'=>'POST'
                    ]);

            $status="success";
            $view=$this->renderView('protected/rol/create.html.twig',[
                    'form'=>$newForm->createView(),
                    ]);
        }else{
            $status="form_erors";
            $view=$this->renderView('protected/rol/edit.html.twig',[
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
     * @Route("svao/protected/roles/delete/{id}",name="svao.roles.delete",methods={"GET"})
     */
    public function delete(int $id)
    {

        $rol = $this->getDoctrine()
            ->getRepository(Rol::class)
            ->find($id);


        $view=$this->renderView('protected/rol/delete.html.twig',[
            'rol'=>$rol,
        ]);

        return $this->json([
            'status'=>'success',
            'html'=>$view
        ]);

    }

    /**
     * @Route("svao/protected/roles/destroy/{id}",name="svao.roles.destroy",methods={"GET"})
     */
    public function destroy(int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $rol = $this->getDoctrine()
            ->getRepository(Rol::class)
            ->find($id);


        try {
            $entityManager->remove($rol);
            $entityManager->flush();

            $view="";
            $status='reload';

        }catch (\Exception $e){
            $view='El rol posee dependencias, elimine objetos relacionados e intente de nuevo';
            $status='aborted';
        }

        return $this->json([
            'status'=>$status,
            'html'=>$view
        ]);
    }

//    ============================== Permisos de los roles +===================================

    /**
     * @Route("svao/protected/roles/{rol}/permisos/all",name="svao.roles.permisos",methods={"GET"})
     */
    public function roles(Rol $rol)
    {
        $list=$this->getDoctrine()->getRepository(Permiso::class)->findAll();
        $cat=$this->getDoctrine()->getRepository(Permiso::class)->findGroupsBy();

        $view=$this->renderView('protected/rol/permiso.html.twig',[
            'rol'=>$rol,
            'list'=>$list,
            'groups'=>$cat
        ]);
        return $this->json([
            'status'=>'success',
            'html'=>$view
        ]);

    }

    /**
     * @Route("svao/protected/roles/{rol}/permisos/all",name="svao.roles.permisions.update",methods={"POST"})
     */
    public function updatePermissinos(Rol $rol, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        //Revocamos toodos los permisos.
        $all=$entityManager->getRepository(Permiso::class)->findAll();
        foreach ($all as $pvt){
            $rol->removePermiso($pvt);
        }
        $entityManager->flush();
        $this->addFlash('success','Rol actualizado correctamente');

        //Agregamos todos los pemrisos
        if($request->get('permissions')){
            $permisos=$request->get('permissions');
            $cuenta=count($permisos);

            for ($i=0;$i<$cuenta;$i++)
            {
                $rol->addPermiso($entityManager->find(Permiso::class,$permisos[$i]));
            }
            $entityManager->flush();
        }
        return $this->redirect($this->generateUrl('index_rol'));
    }
}
