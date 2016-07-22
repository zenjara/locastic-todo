<?php
/**
 * Created by PhpStorm.
 * User: IvanMatas
 * Date: 7/18/2016
 * Time: 8:51 PM
 * []{}@
 */
namespace MtsBundle\Controller;

use MtsBundle\Entity\Korisnik;
use MtsBundle\Entity\Task;
use MtsBundle\Entity\TempKorisnik;
use MtsBundle\Entity\Tlist;
use MtsBundle\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController extends Controller
{

    /**
     * @Route("/register", name="registration")
     */
    public function registerAction(Request $request)
    {

        $korisnik = new Korisnik();
        $tempKorisnik = new TempKorisnik();
        $form = $this->createForm(RegisterType::class, $korisnik);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $this->get('security.password_encoder')
                ->encodePassword($korisnik, $korisnik->getPlainPassword());
            $korisnik->setPassword($password);

            $confirm_code = md5(uniqid(rand()));
            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $tempKorisnik->setConfirmCode($confirm_code);
            $tempKorisnik->setEmail($korisnik->getEmail());
            $tempKorisnik->setPassword($korisnik->getPassword());
            $tempKorisnik->setFirstName($korisnik->getFirstName());
            $tempKorisnik->setLastName($korisnik->getLastName());
//                $em->persist($korisnik);
            $em->persist($tempKorisnik);
            $em->flush();


            $email = $korisnik->getEmail();
            $pass = $korisnik->getPassword();

            // send e-mail to ...
            $to = $email;

            // Your subject
            $subject = "Confirmation link";

            // From
            $header = "from: TODO staff <todo@todo.com>";

            // Your message
            $message = "Your Comfirmation link \r\n";
            $message .= "Click on this link to activate your account \r\n";
            $message .= "http://www.yourweb.com/confirmation.php?passkey=$confirm_code";

            // send email
            $sentmail = mail($to, $subject, $message, $header);


            // if your email succesfully sent
            if ($sentmail) {
                echo "Your Confirmation link Has Been Sent To Your Email Address.";
            } else {
                echo "Cannot send Confirmation link to your e-mail address";
            }
            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user
            $todolist = new Tlist();
            $todolist->setName("Welcome")->setKorisnik($korisnik);

            $task = new Task();
            $task->setName("Get comfortable :)");
            $task->setPriority("High")->setTlist($todolist);
            $em->persist($todolist);
            $em->persist($task);
            $em->flush();
            return $this->redirectToRoute('success');

        }
            return $this->render('MtsBundle:Registration:registration.html.twig', array("form" => $form->createView()));
        }


    /**
     * @Route("/success", name="success")
     */
    public function successAction(){
        return $this->render(
            "MtsBundle:Registration:success.html.twig"
        );
    }
}