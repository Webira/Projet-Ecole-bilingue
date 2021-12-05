<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="accueilSite")
     */
    public function indexAcc(): Response
    {
        return $this->render('/home/accueil.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/adminpage", name="adminpage")
     */
    public function admin(): Response
    {
        return $this->render('/home/adminAccueil.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/apropos", name="apropos")
     */
    public function apropos(): Response
    {
        return $this->render('/home/apropos.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }


}

