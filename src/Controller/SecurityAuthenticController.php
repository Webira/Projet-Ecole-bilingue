<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityAuthenticController extends AbstractController
{
    /**
     * @Route("/connexion", name="app_login", methods={"GET", "POST"}))
     */
    public function login(AuthenticationUtils $authenticationUtils, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder): Response
    {

        //creer un utilisateur pour enregistrer dans bdd direct.
//        $user = new User();
//        $user->setEmail('dinad@doc.fr');
//        $user->setPassword($passwordEncoder->encodePassword($user,'0000'));
//        $user->setRoles(['ROLE_USER']);
//        $entityManager->persist($user);
//        $entityManager->flush();
////////////////////


        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('usersecurity/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }


    /**
     * @Route("/deconnexion", name="logout", methods={"GET"})
     */
    public function logout()
    {

        return $this->render('home/accueil.html.twig');
    }


    /**
     * @Route("/registuser", name="registuser")
     */
    public function register(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        // on analyse la requête
        $form->handleRequest($request);

// si le formulaire a été remplire et submite et la form est valide avec la modele
        if ($form->isSubmitted() && $form->isValid()):
// creer le mot de pass et l'encoder
            $mdp = $encoder->encodePassword($user, $request->request->get('registration')['password']);
            $user->setPassword($mdp);

// demander à Manager persister l'User et après envoyer la requete dans BDD.
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            //envoyer la requete dans BDD
            $manager->flush();
            $this->addFlash('success', 'Félicitation! votre inscription s\'est bien déroulée. Connectez vous à présent');

// Rederection, si tout est bien,à la page oneUser.html.twig
            return $this->redirectToRoute('showeuser', [
                            'id' => $user->getId()
                        ]);
        endif;
        //Crér une variable 'formUser' et utiliser la methode createView() pour afficher dans le fishier twig
                return $this->render('usersecurity/registration.html.twig', [
            'formUser' => $form->createView(),
        ]);
    }


    /**
     * @Route("/user/{id}", name="showeuser")
     */
    public function show($id): Response
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        return $this->render('usersecurity/oneUser.html.twig', [
            "user" => $user,

        ]);
    }

    /**
     *
     * @Route("/modif_user/{id}", name="modif_user")
     */
    public function editUser(User $user, Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder, $id=null): Response
    {
//
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        if (!$user) {
            $this->addFlash('erreur', 'l\'utilisateur n\éxiste pas !');
        }
//
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $mdp = $encoder->encodePassword($user, $request->request->get('registration')['password']);
            $user->setPassword($mdp);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('message', 'Utilisateur modifié avec succès');
            return $this->redirectToRoute('showeuser',  [
                                'id' => $user->getId()
                            ]);

//            return $this->redirectToRoute('', [
//                'id' => $user->getId()
//            ]);
        }
        return $this->render('usersecurity/modifUser.html.twig', [
            "formodifUser" => $form->createView()
        ]);
    }



}