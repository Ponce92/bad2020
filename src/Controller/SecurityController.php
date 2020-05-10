<?php

namespace App\Controller;

use App\Form\SvaoProtected\LoginType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends AbstractController
{

    /**
     * @Route("/", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {

        $form=$this->createForm(LoginType::class,null,['action'=>$this->generateUrl('loginUser'),
            'method'=>'POST'
        ]);

        return $this->render('public/login.html.twig', [
            'form' =>$form->createView() ,
            'band'=>"Error",
        ]);
        //$this->getUser()
//        if (true) {
//            return $this->redirectToRoute('home');
//        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/login/", name="loginUser",methods={"POST",})
     */
    public function loginUser(Request $request)
    {
        $form=$this->createForm(LoginType::class,['action'=>$this->generateUrl('loginUser'),
            'method'=>'POST'
        ]);
        $form->handleRequest($request);
        $data=$form->getData();

        if($data['username']=="user1")
        {

            return $this->redirectToRoute('homesvao');
        }



        $form=$this->createForm(LoginType::class,null,['action'=>$this->generateUrl('loginUser'),
            'method'=>'POST'
        ]);

        return $this->render('public/login.html.twig', ['band'=>"true",
                                                                'form'=>$form->createView()
                                                        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
