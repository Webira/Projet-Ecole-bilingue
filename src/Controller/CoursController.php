<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Form\CoursType;
use App\Repository\CoursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;


class CoursController extends AbstractController
{

    /**
     * @IsGranted("ROLE_REGIST")
     * @Route("/add_cours", name="add_cours")
     *
     */
    public function addCours( Request $request, EntityManagerInterface $manager, $id = null){

        /*dd($request);*/
          if(empty($cours)) {
               $cours = new Cours();
          }

        $form = $this->createForm(CoursType::class, $cours , array('add'=>true));
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

                $cours->setDateAt(new \DateTime());

            $photoFile = $form->get('photo')->getData();
            if ($photoFile) {
                $nomImage = date("YmdHis") . "-" . uniqid() . "-" . $photoFile->getClientOriginalName();
            }
            $photoFile->move(
                $this->getParameter("image_cours"),
                $nomImage
            );
            $cours->setPhoto($nomImage);

            $manager->persist($cours);
            $manager->flush();

            return $this->redirectToRoute('showcours',[
                'id'=>$cours->getId()
            ]);
        }
        return $this->render('cours/formuCours.html.twig', [
            "formCours" => $form->createView(),     // nom de la variable passée sur twig

        ]);
    }

    /**
     * @IsGranted("ROLE_REGIST")
     * @Route("/modif_cours/{id}", name="modif_cours")
     */
    public function modiCours(Cours $cours,Request $request, EntityManagerInterface $manager)
    {

        $form = $this->createForm(CoursType::class, $cours, array('modif' => true));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $photoFile = $form->get('photoFile')->getData();
            if ($photoFile) {
                $nomImage = date("YmdHis") . "-" . uniqid() . "-" . $photoFile->getClientOriginalName();
            }
            $photoFile->move(
                $this->getParameter("image_cours"),
                $nomImage
            );

            $cours->setPhoto($nomImage);

            $manager->persist($cours);
            $manager->flush();

        // $this->addFlash('success', "Le cours N° " . $cours->getId() . " a bien été modifié");

        return $this->redirectToRoute('showcours', [
            'id' => $cours->getId()
        ]);
        }
        return $this->render('cours/modifCours.html.twig', [
            "formodifCours" => $form->createView(),

        ]);
    }

    /**
     * @Route("/ateliers", name="ateliers")
     */
    public function allCours(CoursRepository $repository): Response
    {
        $courses = $repository->findAll();

        //dd($courses);
     //dd($this->getUser()->getRoles());
//      if ($this->getUser() && $this->getUser()->getRoles()[0] == 'ROLE_ADMIN'){
//
//          return $this->render('cours/tabGestionCours.html.twig', [
//              'courses' => $courses,
//          ]);

//      }else{
          return $this->render('cours/allCours.html.twig', [
              'courses' => $courses,

          ]);
//      }
    }

    /**
     * @Route("/tabateliers", name="tabateliers")
     */
    public function tabAllCours(CoursRepository $repository): Response
    {
        $courses = $repository->findAll();

        //dd($courses);
        //dd($this->getUser()->getRoles());
//        if ($this->getUser() && $this->getUser()->getRoles()[0] == 'ROLE_ADMIN'){

            return $this->render('cours/tabGestionCours.html.twig', [
                'courses' => $courses,
            ]);
//        }else{
//            return $this->render('cours/allCours.html.twig', [
//                'courses' => $courses,
//            ]);
//        }
    }


    /**
     * @Route("/showcours/{id}", name="showcours")
     */
    public function show($id): Response
    {
        $cours = $this->getDoctrine()->getRepository(Cours::class)->find($id);

        return $this->render('cours/oneCours.html.twig', [
            "cours" => $cours,
        ]);
    }

    /**
     * @Route("/showcourstype/{type}", name="showtypecours")
     */
    public function showTypeCours($type, Request $request, PaginatorInterface $paginator): Response
    {
        $courses = $this->getDoctrine()->getRepository(Cours::class)->findAll();

        $atelierpages = $this->getDoctrine()->getRepository(Cours::class)->findAll();
        // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
        $atelierpages =  $paginator->paginate($atelierpages, $request->query->getInt('page', 1), 1);
                                                                                                  // Nombre de résultats par page
        //dd($courses);
        //dd($cours);
        return $this->render('cours/coursByCritere.html.twig', [
            "courses" => $courses,
            "atelierpages"=>$atelierpages
        ]);
    }

    /**
    * @Route("/delete_cours/{id}", name="delete_cours")
    */
    public function supprimerCours($id, EntitymanagerInterface $manager)
    {
        $cours =  $this->getDoctrine()->getRepository(Cours::class)->find($id);

        $manager->remove($cours);
        $manager->flush();

        return $this->redirectToRoute('ateliers');

    }





}
