<?php
/**
 * Created by PhpStorm.
 * User: IvanMatas
 * Date: 7/19/2016
 * Time: 5:44 PM
 */

namespace MtsBundle\Controller;


use MtsBundle\Entity\Task;
use MtsBundle\Entity\Tlist;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DashboardController extends Controller
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboardAction()
    {
        $korisnik = $this->get("security.token_storage")->getToken()->getUser();
        $todoLists = $korisnik->getTlists();
        $counterNotCompleted=0;
        /*foreach ($todoLists as $list) {
            $tasks= $list->getTasks();
            foreach($tasks as $task){
                if(!$task->getIsCompleted()){
                    $counterNotCompleted++;
                }
            }
        }*/
//        $tasks= $todoLists->getTasks();
        return $this->render("MtsBundle:Dashboard:dashboard.html.twig", array(
            "korisnik" => $korisnik,
            "todoLists" => $todoLists,

        ));
    }

    /**
     * @Route("/delete", name="delete")
     */

    public function deleteAction(Request $request)
    {
        $korisnik = $this->get("security.token_storage")->getToken()->getUser();
        $todoLists = $korisnik->getTlists();
        $em = $this->getDoctrine()->getManager();

        if(isset($_POST['id_list'])) {
            $list = $em->getRepository('MtsBundle:Tlist')->findOneById($_POST['id_list']);
            $tasks= $list->getTasks();
            foreach ($tasks as $task) {
                $em->remove($task);
                $em->flush();
            }
            if (!$list) {
                throw $this->createNotFoundException(
                    'No task found for id '.$_POST['id_list']
                );
            }

            $em->remove($list);
            $em->flush();


            echo "ok";
        }

        if(isset($_POST['id'])) {
            $task = $em->getRepository('MtsBundle:Task')->findOneById($_POST['id']);

            if (!$task) {
                throw $this->createNotFoundException(
                    'No task found for id '.$_POST['id']
                );
            }

            $em->remove($task);
            $em->flush();


            echo "ok";
        }


        return $this->render('MtsBundle:Dashboard:dashboard.html.twig',array("korisnik" => $korisnik,
        "todoLists" => $todoLists,
        ));
    }

    /**
     * @Route("/dashboard/add", name="addForm")
     */
    public function addAction(Request $request)
    {
        $korisnik = $this->get("security.token_storage")->getToken()->getUser();

        $em= $this->getDoctrine()->getManager();

        if ($request->getMethod() == 'POST') {

            if (isset($_POST["add_list"])) {

                $todolist = new Tlist();
                $todolist->setName($_POST["name"]);
                $todolist->setKorisnik($korisnik);


//                if(empty($_POST["add_task"])){
                for($i=1;$i<6;$i++){
                        if(isset($_POST["taskName{$i}"])) {
                            $task= new Task();
                            $task->setName($_POST["taskName{$i}"]);
                        }
//                    $task->setDeadline($_POST["deadline"]);
                        if(isset($_POST["priority{$i}"])){
                            $priority{$i} = $_POST["priority{$i}"];
                            switch ($priority{$i}) {
                                case 'high':
                                    $task->setPriority("High");
                                    break;
                                case 'normal':
                                    $task->setPriority("Normal");
                                    break;
                                case 'low':
                                    $task->setPriority("Low");
                                    break;
                                default:
                                    # code...
                                    break;
                            }
                    }
                        $task->setTlist($todolist);
                        $em->persist($task);
//                        $em->flush();



                }
                $em= $this->getDoctrine()->getManager();
                $em->persist($todolist);

                $em->flush();
                return $this->render('MtsBundle:Dashboard:addTodo.html.twig');

            }
            if (isset($_POST["dialog_task_add"])) {

                $task = new Task();
                $todolist= $em->getRepository('MtsBundle:Tlist')->findOneByName($_POST["dialog_list_name"]);

                $task->setName($_POST["dialog_task_name"]);
                //$task->setDeadline($_POST["dialog_task_deadline"]);
                if(isset($_POST["dialog_task_priority"])) {
                    $priority_dialog = $_POST["dialog_task_priority"];
                    switch ($priority_dialog) {
                        case 'high':
                            $task->setPriority("High");
                            break;
                        case 'normal':
                            $task->setPriority("Normal");
                            break;
                        case 'low':
                            $task->setPriority("Low");
                            break;
                        default:
                            # code...
                            break;
                    }
                }
                    $task->setTlist($todolist);
                    $em->persist($task);
                    $em->flush();
                return $this->render('MtsBundle:Dashboard:dashboard.html.twig');

            }
        }

            return $this->render("MtsBundle:Dashboard:addTodo.html.twig", array(
                "korisnik" => $korisnik,
            ));
        }

    /**
     * @Route("/dashboard/edit", name="editTask")
     */
    public function editAction(Request $request)
    {
        $korisnik = $this->get("security.token_storage")->getToken()->getUser();
        $em= $this->getDoctrine()->getManager();

        if(isset($_POST['dialog_task_name'])) {
            $task = $em->getRepository('MtsBundle:Task')->findOneByName($_POST['dialog_task_name2']);
            $task->setName($_POST["dialog_task_name"]);
            //$task->setDeadline($_POST["dialog_task_deadline"]);
            if(isset($_POST["dialog_task_priority"])) {
                $priority_dialog = $_POST["dialog_task_priority"];
                switch ($priority_dialog) {
                    case 'high':
                        $task->setPriority("High");
                        break;
                    case 'normal':
                        $task->setPriority("Normal");
                        break;
                    case 'low':
                        $task->setPriority("Low");
                        break;
                    default:
                        # code...
                        break;
                }
            }

            $em->persist($task);
            $em->flush();


            echo "ok";
            return $this->render("MtsBundle:Dashboard:dashboard.html.twig", array(
                "korisnik" => $korisnik,
            ));
        }
        return $this->render("MtsBundle:Dashboard:dashboard.html.twig", array(
            "korisnik" => $korisnik,
        ));
    }
}