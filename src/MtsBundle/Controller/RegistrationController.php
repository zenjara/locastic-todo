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
        $form = $this->createForm(RegisterType::class, $korisnik);

        $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                // 3) Encode the password (you could also do this via Doctrine listener)
                $password = $this->get('security.password_encoder')
                    ->encodePassword($korisnik, $korisnik->getPlainPassword());
                $korisnik->setPassword($password);
                $confirm_code=md5(uniqid(rand()));
                $korisnik->setConfirmCode($confirm_code);

                // 4) save the User!
                $em = $this->getDoctrine()->getManager();

                $em->persist($korisnik);
                $em->flush();

                // Your subject
                $subject="Confirm your  account!";

                $header="from: TODO staff <todo@support.com>";

                $message="Your Comfirmation link \r\n";
                $message.="Click on this link to activate your account \r\n";
                $message.="http://www.todo-locastic.com/activate/$confirm_code";


                $sentmail = mail($korisnik->getEmail(),$subject,$message,$header);



        if($sentmail){
            echo "Your Confirmation link Has Been Sent To Your Email Address.";
        }
        else {
            echo "Cannot send Confirmation link to your e-mail address";
        }

                $todolist= new Tlist();
                $todolist->setName("Welcome")->setKorisnik($korisnik);

                $task= new Task();
                $task->setName("Get comfortable :)");
                $task->setPriority("High")->setTlist($todolist);
                $em->persist($todolist);
                $em->persist($task);
                $em->flush();
                return $this->redirectToRoute('success');
            }


        return $this->render('MtsBundle:Registration:registration.html.twig',array("form"=> $form->createView()));
    }

    /**
     * @Route("/success", name="success")
     */
    public function successAction(){
        return $this->render(
            "MtsBundle:Registration:success.html.twig"
        );
    }


    /**
     * @Route("/activate/{code}", name="activation")
     */
    public function activaterAction(Request $request,$code)
    {

        $em= $this->getDoctrine()->getManager();
        $korisnik= $em->getRepository("MtsBundle:Korisnik")->findOneByConfirmCode($code);
        if($korisnik){
            $korisnik->setIsActivated(true);
            return $this->redirectToRoute('success');
        }
        else{
            return $this->render('MtsBundle:Dashboard:dashboard.html.twig',array("code"=>$code));
        }


    }
}