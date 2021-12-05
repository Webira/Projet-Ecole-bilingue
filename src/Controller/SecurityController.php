<?php

namespace App\Controller;


use App\Entity\User;
use App\Form\PromoteType;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * @Route("/admin", name="admin_")
 */
class SecurityController extends AbstractController
{
    /**
     * @Route("/allusers", name="allusers")
     */
    public function allUsers(UserRepository $repository): Response
    {
        $users = $repository->findAll();

        return $this->render('usersecurity/tabGestionUser.html.twig', [
            'users' => $users
        ]);
    }

    /**
     *
     * @Route("/modif_userrole/{id}", name="modif_userrole")
     */
    public function editUserRole(User $user, Request $request): Response
    {

        $form = $this->createForm(PromoteType::class, $user);

        $form->handleRequest($request);
       // dd($form->getErrors());
        if ($form->isSubmitted() && $form->isValid()) {


            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('message', 'Le Role d\'Utilisateur modifié avec succès');

            return $this->redirectToRoute('admin_allusers');
        }

        return $this->render('usersecurity/promoRoles.html.twig', [
            "formodifRole" => $form->createView(),
            "user"=>$user
        ]);
    }

    /**
     * @Route("/delete_user/{id}", name="delete_user")
     */
    public function supprimerUser($id, EntitymanagerInterface $manager)
    {
        $user =  $this->getDoctrine()->getRepository(User::class)->find($id);

        $manager->remove($user);
        $manager->flush();

        return $this->redirectToRoute('admin_allusers');

    }

}





//    /**
//     * @Route("/promote/{id}", name="promote")
//     */
//    public function promoteToAdmin($id, Request $request, EntityManagerInterface $manager): Response
//    {
//        $secret = "adCodemin1";                //code secret de admin
//        $form = $this->createForm(PasswordType::class);
//        $form->handleRequest($request);
//
//        // on récupere mote pass de bass
//        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
//        if (!$user) {
//            $this->addFlash('erreur', 'l\'utilisateur n\éxiste pas !');
//        }
//        if ($form->isSubmitted() && $form->isValid()) {
//
//            //on compare la saisie dans le formulaire avec le mot de pass secret stocké dans $secret
//            if ($form->get("secret")->getData() != $secret) {
//                throw $this->createNotFoundException("Vous n'avez pas le bon code");
//            }
//
//            $user->setRoles(["ROLE_ADMIN"]);
//
//            $manager->persist($user);
//            $manager->flush();
//
//            $this->addFlash('success', 'Felisitation, vous etes enregistrez !');
//
//            return $this->redirectToRoute('accueilSite');
//
//        }
//        return $this->render("usersecurity/promoRoles.html.twig", [
//            "formPromote" => $form->createView(),
//            "user" => $user
//        ]);
//    }
/////////////////

