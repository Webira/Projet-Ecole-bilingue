<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Entity\Eleve;
use App\Entity\User;
use App\Form\EleveType;
use App\Repository\EleveRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EleveController extends AbstractController
{
   /* /**
     * @Route("/eleveage", name="eleveage")
     */
    /*public function age(): Response
    {
         $eleve = $this->getDoctrine()->getRepository(Eleve::class)->findAll();

        $datetime1 = $eleve->setDate(new \DateTime());
         $datetime2 = $eleve->setBirthdate(\ DateTime::class);
             $age = $datetime1->diff($datetime2() == true)->y;

        return $this->render('eleve/eleveage.html.twig', [
            'controller_name' => 'EleveController',
        ]);
  }
                /* $datetime1 = new \DateTime();        // date actuelle
                    $datetime2 = new \DateTime('1993-09-28');
                    $age = $datetime1->diff($datetime2, true)->y;       // le y = nombre d'années ex : 22
                */


    /**
     * @Route("/eleves", name ="eleves")
     */
    public function allEleves(): Response
    {
        $eleves = $this->getDoctrine()->getRepository(Eleve::class)->findAll();

      // dd($eleves);

        return $this->render('eleve/tabGestionEleve.html.twig', [
            "eleves" => $eleves
        ]);
    }

    /**
     * @Route("/add_eleve", name="add_eleve")
     *
     */
    public function addEleve( Request $request, EntityManagerInterface $manager){

            $eleve = new Eleve();

            /*Calcul d'age enfant de Birthdate*/
//        $datetime1 = $eleve->setDate(new \DateTime());
//        $datetime2 = $eleve->setBirthdate(\ DateTime::class);
            /* */
        $form = $this->createForm(EleveType::class, $eleve);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
                /* Calcul d'age enfant de Birthdate
             * if(!$eleve->getId()){
                $eleve->setBirthdate(\ DateTime::class);
            }*/
            $eleve->setUser($this->getUser());
            $eleve->setDate(new \DateTime());
//            $age = $datetime1->diff($datetime2() == true)->y;
                /*  */

            $manager->persist($eleve);
            $manager->flush();

            return $this->redirectToRoute('showeleve',[
                'id'=>$eleve->getId()
            ]);
        }

        return $this->render('eleve/formuEleve.html.twig', [
            "formEleve" => $form->createView(),

        ]);
    }

    /**
     *
     * @Route("/modif_eleve/{id}", name="modif_eleve")
     */
    public function modifEleve(Eleve $eleve, Request $request, EntityManagerInterface $manager, $id=null)
    {

        $form = $this->createForm(EleveType::class, $eleve);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /*if(!$eleve->getId()){
                $eleve->setBirthdate(\ DateTime::class);
            }*/
            $manager->persist($eleve);
            $manager->flush();

            return $this->redirectToRoute('showeleve', [
                'id' => $eleve->getId()
            ]);
    }

        return $this->render('eleve/modifEleve.html.twig', [
            "formodifEleve" => $form->createView(),
//            'editModeEleve' => $eleve->getId() !==null
        ]);
    }

    /**
     * @Route("/eleve/{id}", name="showeleve")
     */
    public function show($id): Response
    {
        $eleve = $this->getDoctrine()->getRepository(Eleve::class)->find($id);

        return $this->render('eleve/oneEleve.html.twig', [
            "eleve" => $eleve,

        ]);
    }

    /**
     *
     * @Route("/delete_eleve/{id}", name="delete_eleve")
     */
    public function supprimerEleve($id, EntitymanagerInterface $manager)
    {
        $eleve =  $this->getDoctrine()->getRepository(Eleve::class)->find($id);

        $manager->remove($eleve);
        $manager->flush();

        return $this->redirectToRoute('eleves');

    }




}
