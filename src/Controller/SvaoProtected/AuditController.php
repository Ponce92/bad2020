<?php

namespace App\Controller\SvaoProtected;

use App\Entity\SvaoProtected\Accions;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AuditController extends AbstractController
{
    /**
     * @Route("/svao/protected/audit", name="svao.protected.audit")
     */
    public function index(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $RAW_QUERY = 'SELECT distinct (nombre_tabla)  FROM auditoria ;';
        $statement = $em->getConnection()->prepare($RAW_QUERY);
        $statement->execute();
        $tbl=$request->query->get('tabla');
        $result = $statement->fetchAll();


        if($request->query->get('tabla')){
            $list=$this->getDoctrine()->getManager()->getRepository(Accions::class)->findBy(['tabla'=>$request->query->get('tabla')]);
        }else{
            $list=$this->getDoctrine()->getManager()->getRepository(Accions::class)->findAll(array('fecha'=>'ASC'));
        }


        return $this->render('protected/audit/index.html.twig', [
            'list'=>$list,
            'tbl'=>$tbl,
            'tablas'=>$result,
        ]);
    }
}
