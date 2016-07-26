<?php

namespace MtsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction()
    {
        $korisnik=$this->get("security.token_storage")->getToken()->getUser();

        if(!is_string($korisnik)){

            return $this->render("MtsBundle:Dashboard:dashboard.html.twig", array(
                "korisnik" => $korisnik,
                "todoLists" => $korisnik->getTlists(),

            ));
        }
        return $this->render('MtsBundle:Default:index.html.twig');
    }
}
