<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\User;
use App\Form\ContactType;
use http\Message;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    //  l'annotation route permet de définir l'url:
            //2 arguments :
            //* 1er : la route (l'url)
            //* 2e : le nom de la route (lien href avec la fonction path())
            //* les 2 arguments doivent être placés entre DOUBLE QUOTE


    /**
     * @Route("/contact", name="contact")
     */
    public function sendMail(MailerInterface $mailer, Request $request)
    {

        if (!empty($_POST)):

            $mess = $request->request->get('message');
            $nom = $request->request->get('prenom');
            $prenom = $request->request->get('nom');
            $motif = $request->request->get('motif');
            $from = $request->request->get('email');

            $email = (new TemplatedEmail())
                ->from($from)
                ->to('irinacovid2021@gmail.com')
                ->subject($motif)
                ->text('Sending emails is fun again!')
                ->htmlTemplate('contact/email.html.twig');
            $cid = $email->embedFromPath('images/EN_mode_bilingue_1.jpg', 'logo');

            // pass variables (name => value) to the template
            $email->context([
                'message' => $mess,
                'nom' => $nom,
                'prenom' => $prenom,
                'subject' => $motif,
                'from' => $from,
                'cid' => $cid,
                'liens' => 'https://127.0.0.1:8000',
                'objectif' => 'Accéder au site'

            ]);

            $mailer->send($email);


            return $this->redirectToRoute("accueilSite");
        endif;

        return $this->render('home/contact.html.twig');
    }

}

//    /**
//     * @Route("/contact", name="contact")
//     */
//    public function index(Request $request,Swift_Mailer $mailer)
//    {
//    //        $user=new User;
//    //        $formcont = $this->createForm(ContactType::class, $user);
//    //        $formcont->handleRequest($request);
//    //       dd($formcont->getErrors());
//        if (!empty($_POST)) {
//            // $contact = $formcont->getData();
//            // dd($contact);
//            // Simple Mail Transfer Protocol - protocole simple de transfert de courrier:        //port 465 SSL //port 587 TLS
//
//            $transporter=(new \Swift_SmtpTransport('smtp.gmail.com',465,'SSL')) // Transport Layer Security
//            ->setUsername('irinacovid2021@gmail.com')
//                ->setPassword('Covidirina2021');
//
//            $mailer=new \Swift_Mailer($transporter);
//            // Ici nous enverrons l'e-mail
//            $message = (new \Swift_Message('Nouveau contact'))
//                // On attribue l'expéditeur
//                ->setFrom($_POST['email'])
//                // On attribue le destinataire
//                ->setTo('irinacovid2021@gmail.com');
//
//    //        // On crée le texte avec la vue. The embed() - method to add an image from a file or stream.
//            // get the image contents from an existing file
//            $cid=$message->embed(\Swift_Image::fromPath('images/EN_mode_bilingue_1.jpg'));
//            $message->setBody(
//                $this->renderView(
//                    'contact/email.html.twig',[
//
//                    'message'=>$_POST['message'],
//                    'nom'=>$_POST['nom'],
//                    'prenom'=>$_POST['prenom'],
//                    'motif'=>$_POST['motif'],
//                    'email'=>$_POST['email'],
//                    'cid'=>$cid
//                ]),
//                'text/html'
//            )
//            ;
//            $mailer->send($message);
//            // Permet un message flash de renvoi
//            $this->addFlash('message', 'Votre message a été transmis, nous vous répondrons dans les meilleurs délais.');
//            return $this->redirectToRoute('accueilSite');
//
//        }
//        return $this->render('home/contact.html.twig',[
//            //'contactForm' => $formcont->createView()
//        ]);
//    }
//}