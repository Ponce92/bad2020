<?php

namespace App\Controller\SvaoProtected;

use App\Form\SvaoProtected\RolType;
use App\Repository\RolRepository;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\NumberColumn;
use Omines\DataTablesBundle\Column\TextColumn;

use Omines\DataTablesBundle\DataTableFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Rol;

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
        $form=$this->createForm(RolType::class,$rol);
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

        //Renderizamos el form para enviarlo . . .
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
    public function update(Request $request,$id){
        $entityManager = $this->getDoctrine()->getManager();
        $rol=$entityManager->getRepository(Rol::class)->find($id);
        return $rol;

        $form=$this->createForm(RolType::class,New Rol());
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

//        //Renderizamos el form para enviarlo . . .
//        $view=$this->renderView('protected/rol/create.html.twig',[
//            'form'=>$form->createView(),
//        ]);
//
//        return $this->json([
//            'status'=>'success',
//            'html'=>$view
//        ]);
    }
}
