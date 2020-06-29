<?php

namespace App\Controller\SvaoPrivate;

use App\Entity\SvaoPrivate\Aeropuerto;
use App\Entity\SvaoPrivate\Ciudad;
use App\Entity\SvaoPrivate\Cliente;
use App\Entity\SvaoPrivate\HorarioVuelo;
use App\Entity\SvaoPrivate\Reserva;
use App\Entity\SvaoPrivate\Vuelo;
use App\Security\User;
use Doctrine\ORM\EntityManager;
use http\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class ReservaController extends AbstractController
{

    /**
     * @Route("/svao/vuelos/reserva/", name="vuelos.reservas",methods={"GET"})
     */
    public function getReserva()
    {
        $entityManager=$this->getDoctrine()->getManager();

        $origen=$entityManager->getRepository(Ciudad::class)->find(2);
        $destinos=$entityManager->getRepository(Ciudad::class)->findAll();
        return $this->render('private/clientes/vuelos/reserva.html.twig',[
            'origen'=>$origen,
            'destinos'=>$destinos,
            'destino'=>new Ciudad()
        ]);
    }

    /**
     * @Route("/svao/vuelos/reserva/destino", name="vuelos.reservas.destino",methods={"GET"})
     */
    public function getOpcionesVuelos(Request $request)
    {
        $manager=$this->getDoctrine()->getManager();
        $origen=$manager->getRepository(Ciudad::class)->find(2);
        $destino=$manager->getRepository(Ciudad::class)->find($request->get('destino'));
        $destinos=$manager->getRepository(Ciudad::class)->findAll();

        $horarios=$manager->getRepository(HorarioVuelo::class)->findHorarios($origen,$destino);


        return $this->render('private/clientes/vuelos/reserva.html.twig',[
            'origen'=>$origen,
            'destinos'=>$destinos,
            'destino'=>$destino,
            'horarios'=>$horarios
        ]);
    }

    /**
     * @Route("/svao/vuelos/reserva/desctipcion/{horario}", name="vuelos.reservas.desc",methods={"GET"})
     */
    public function reservarVuelo(HorarioVuelo $horario)
    {
        return $this->render('private/clientes/vuelos/descripcion.html.twig',[
            'horario'=>$horario,
        ]);
    }

    /**
     * @Route("/svao/vuelos/reserva/store", name="vuelos.reservas.store",methods={"POST"})
     */
    public function reservar(Request $request,UserInterface $user)
    {
        $manager=$this->getDoctrine()->getManager();

        try {
            $horarioId=$request->get('horarioId');

            $horario=$manager->find(HorarioVuelo::class,$horarioId);
            $cliente=$manager->find(Cliente::class,$user->getCliente());
            $monto=$request->get('monto');

            $reserva=new Reserva();
            $reserva->setEstado('Reserva');
            $reserva->setCliente($cliente);
            $reserva->setHorario($horario);
            $reserva->setMonto($monto);

            $manager->persist($reserva);
            $manager->flush();
            $this->addFlash('success','Reserva almacenada exitosamente');
        }catch (\Exception $e){
            $this->addFlash('danger','Ha ocurrido un problema '.$e->getMessage());
        }

        return $this->redirect($this->generateUrl('vuelos.reservas'));
    }


}
