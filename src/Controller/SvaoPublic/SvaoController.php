<?php

namespace App\Controller\SvaoPublic;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SvaoController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error=$authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('public/login.html.twig',[
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }
    /**
     * @Route("logout", name="app_logout",methods={"GET"})
     */
    public function logout()
    {

        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }

    /**
     * @Route("/private/hclonome", name="homesvao",methods={"GET",})
     */
    public function home()
    {

        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/",name="svao",methods={"GET"})
     */

    public function svao(){
        return $this->render('public/index.html.twig');
    }
}
