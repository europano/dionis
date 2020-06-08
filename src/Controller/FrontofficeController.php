<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Page;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class FrontofficeController extends AbstractController
{
    /**
     * @Route("/", name="frontoffice")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Page::class);

        $aLaUne = $repo->findPagesALaUne();
        $vieDesProjets = $repo->findPagesVieDesProjets();
        $agenda = $repo->findPagesAgenda();

        return $this->render('frontoffice/index.html.twig', [
            'aLaUne' => $aLaUne,
            'vieDesProjets' => $vieDesProjets,
            'agenda' => $agenda
        ]);
    }

}
