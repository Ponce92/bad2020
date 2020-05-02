<?php

namespace App\Controller;

use App\Form\SvaoProtected\RolType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RolRepository;
use App\Entity\Rol;



class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(RolRepository $rep)
    {
        return new RedirectResponse($this->generateUrl('index_rol'));
    }
}
