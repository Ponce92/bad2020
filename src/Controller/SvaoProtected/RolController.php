<?php

namespace App\Controller\SvaoProtected;

use App\Form\SvaoProtected\RolType;
use App\Repository\RolRepository;
use mysql_xdevapi\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Rol;
use Symfony\Component\Validator\Constraints\Json;

class RolController extends AbstractController
{
    /**
     * @Route("/svao/protected/roles", name="index_rol")
     */
    public function index(RolRepository $rep)
    {
        $roles = $rep->findAll();
        $rol= new Rol();

        $editForm=$this->createForm(RolType::class,$rol,[
           'action'=>$this->generateUrl('store_rol')
        ]);

        $form=$this->createForm(RolType::class,$rol,[
            'action'=>$this->generateUrl('store_rol'),
            'method'=>'POST',
        ]);

        return $this->render('home/index.html.twig', [
            'roles' => $roles,
            'form'  =>$form->createView(),
            'form_edit'=>$editForm->createView(),
        ]);
    }

    /**
     * @Route("svao/store/rol",name="store_rol",methods={"POST",})
     */
    public function store(Request $request){
        $em=$this->getDoctrine()->getManager();
        $rol=new Rol();
        $form=$this->createForm(RolType::class,$rol);
        $form->handleRequest($request);
        if($form->isValid()){

            $rol=$form->getData();

            try {
                $em->persist($rol);
                $em->flush();
                $this->addFlash(
                    'success',
                    'Rol almacenado correctamente'
                );

            }catch (Exception $e){
                $this->addFlash(
                    'danger',
                    'Rol almacenado correctamente'
                );

            }

            return new RedirectResponse($this->generateUrl('index_rol'));

        }
        return $this->render('home/index.html.twig',[
            'roles' =>$em->getRepository(Rol::class)->findAll(),
            'form'  => $form->createView()

        ]);
    }

    /**
     * @Route("svao/protected/roles/{id}",name="roles_show",methods={"GET"},requirements={"id"="\d+"})
     */
    public function show(int $id){
        $rol = $this->getDoctrine()
            ->getRepository(Rol::class)
            ->find($id);

        $form=$this->createForm(RolType::class,$rol,[
            'action'=>$this->generateUrl('store_rol')
        ]);

        //Renderizamos el form para enviarlo . . .
        $html=$this->renderView('protected/rol/edit.html.twig',[
            'form'  =>$form->createView(),
            'edit' =>false,
            ]);

        //Retornamos el Json . . .
        $p_view=['status'=>'success',
                'html'=>$html
                ];
        return new JsonResponse($p_view);
    }
}
