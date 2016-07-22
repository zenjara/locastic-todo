<?php

/**
 * Created by PhpStorm.
 * User: IvanMatas
 * Date: 7/21/2016
 * Time: 5:51 PM
 */

/*Namespace MtsBundle;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\BrowserKit\Request;


class Delete extends Controller
{*/


} /*


      //**
         * @Route("/delete", name="delete")
         */
/*public function deleteAction()
{
        echo "<h1>".$_POST['id']."</h1>";
        $em = $this->getDoctrine()->getManager();
        $task = $em->getRepository('MtsBundle:Task')->findOneById($_POST['id']);

        if (!$task) {
                throw $this->createNotFoundException(
                    'No task found for id ' . $_POST['id']
                );
        }

        $em->remove($task);
        $em->flush();

        echo "ok";
        return $this->render("MtsBundle:Dashboard:dashboard.html.twig", array());
}
}*/