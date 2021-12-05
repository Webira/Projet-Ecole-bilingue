<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Entity\Eleve;
use App\Entity\Professor;
use App\Form\EleveType;
use App\Form\ProfessorType;
use App\Repository\ProfessorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;

class ProfController extends AbstractController
{

//
    /**
     * @IsGranted("ROLE_REGIST")
     * @Route("/add_prof", name="add_prof")
     * @Route("/modif_prof/{id}", name="modif_prof")
     */
    public function addProf(Request $request, EntityManagerInterface $manager, ProfessorRepository $repository, $id = null)
{
        if ($id == null):
            $professor = new Professor();
        else:
            $professor = $repository->find($id);
        endif;

        $professors = $repository->findAll();

        $form = $this->createForm(ProfessorType::class, $professor);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()):

            $manager->persist($professor);
            $manager->flush();

            return $this->redirectToRoute('showprof',[
                'id'=>$professor->getId()
            ]);

        endif;
        return $this->render('prof/formuProf.html.twig', [
            "formProf" => $form->createView(),
            'editModeProf' => $professor->getId() !==null
        ]);
    }

    /**
     * @Route("/prof/{id}", name="showprof")
     */
    public function show($id): Response
    {
        $professor = $this->getDoctrine()->getRepository(Professor::class)->find($id);

        return $this->render('prof/oneProf.html.twig', [
            "professor" => $professor
        ]);
    }

    /**
     * @Route("/allprof", name ="allprof")
     */
    public function allProf(): Response
    {
        $professors = $this->getDoctrine()->getRepository(Professor::class)->findAll();

        return $this->render('prof/tabGestionProf.html.twig', [

            "professors" => $professors
        ]);
    }

    /**
     * @Route("/delete_prof/{id}", name="delete_prof")
     */
    public function supprimerProf($id, EntitymanagerInterface $manager)
    {
        $professor =  $this->getDoctrine()->getRepository(Professor::class)->find($id);

        $manager->remove($professor);
        $manager->flush();

        return $this->redirectToRoute('allprof');
    }
}

//    /**
//    //     * @Route("/add_prof", name="add_prof")
//    //     *
//    //     */
//    public function addProf( Request $request, EntityManagerInterface $manager){
//
//        /*dd($request);*/
//        if(empty($professor)) {
//            $professor = new Professor();
//        }
//
//        $form = $this->createForm(ProfessorType::class, $professor);
//        $form->handleRequest($request);
//
//        if($form->isSubmitted() && $form->isValid()){
//
////            if($id==null){
//           // $professor->setDateAt(new \DateTime());
////            }
//
//            $manager->persist($professor);
//            $manager->flush();
//
//            return $this->redirectToRoute('showprof/'.$professor->getId(),[
//                'id'=>$professor->getId()
//            ]);
//
//        }
//
//        return $this->render('prof/formuProf.html.twig', [
//            "formProf" => $form->createView(),
//            // 'editMode' => $cours->getId() !==null
//        ]);
//    }
//
//    /**
//     * @Route("/modif_professor/{id}", name="modif_professor")
//     */
//    public function modProf(Professor $professor,Request $request, EntityManagerInterface $manager,  $id=null)
//    {
//
//        $form = $this->createForm(ProfessorType::class, $professor, array('modif'=>true));
//        $form->handleRequest($request);
//
//
//        if($form->isSubmitted() && $form->isValid()){
//
//            //$imageFile = $form->get('imageFile')->getData();
//
////            if($id==null){
//           // $professor->setDateAt(new \DateTime());
////            }
//
//            $manager->persist($professor);
//            $manager->flush();
//
//            return $this->redirectToRoute('showprof',[
//                'id'=>$professor->getId()
//            ]);
//
//        }
//
//        return $this->render('prof/modifProf.html.twig', [
//            "formodifProf" => $form->createView(),
////            'editMode' => $professor->getId() !==null
//        ]);
//
//    }




