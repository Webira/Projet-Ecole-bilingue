<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request,\Swift_Mailer $mailer)
    {
//        $user=new User;
//        $formcont = $this->createForm(ContactType::class, $user);
//        $formcont->handleRequest($request);
  //dd($formcont->getErrors());
        if (!empty($_POST)) {
           // $contact = $formcont->getData();
           // dd($contact);
            $transporter=(new \Swift_SmtpTransport('smtp.gmail.com',587,'tls'))
                ->setUsername('dorancocovid2021@gmail.com')
                ->setPassword('Dorancosalle06');

            $mailer=new \Swift_Mailer($transporter);
            // Ici nous enverrons l'e-mail
            $message = (new \Swift_Message('Nouveau contact'))
                // On attribue l'expéditeur
                ->setFrom($_POST['email'])
                // On attribue le destinataire
                ->setTo('guery.ira@gmail.com');
                // On crée le texte avec la vue

                    $cid=$message->embed(\Swift_Image::fromPath('images/EN_mode_bilingue_1.jpg'));
                $message->setBody(
                    $this->renderView(
                        'contact/email.html.twig',[
                            'message'=>$_POST['message'],
                            'nom'=>$_POST['nom'],
                            'prenom'=>$_POST['prenom'],
                            'motif'=>$_POST['motif'],
                            'email'=>$_POST['email'],
                            'cid'=>$cid


                    ])
                    ,
                    'text/html'
                )
            ;
            $mailer->send($message);

            $this->addFlash('message', 'Votre message a été transmis, nous vous répondrons dans les meilleurs délais.'); // Permet un message flash de renvoi
       return $this->redirectToRoute('accueilSite');

        }
        return $this->render('home/contact.html.twig',[
            //'contactForm' => $formcont->createView()
        ]);
    }
}
