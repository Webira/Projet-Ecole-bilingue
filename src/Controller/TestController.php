<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index(): Response
    {
        $nom="Guery";
        $prenom="Irina";

        return $this->render('test/testindex.html.twig', [
            'nom' => $nom,
            "prenom" =>$prenom
        ]);
    }
}
