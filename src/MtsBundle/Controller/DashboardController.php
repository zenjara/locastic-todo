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
use Symfony\Component\Validator\Constraints\Date;


class DashboardController extends Controller
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboardAction()
    {
        $korisnik = $this->get("security.token_storage")->getToken()->getUser();
        $todoLists = $korisnik->getTlists();

        if ($korisnik->getIsActive()) {
            return $this->render("MtsBundle:Dashboard:dashboard.html.twig", array(
                "korisnik" => $korisnik,
                "todoLists" => $todoLists,

            ));
        } else {
            return $this->render("MtsBundle:Dashboard:notActivated.html.twig", array(
                "korisnik" => $korisnik,
            ));
        }
    }

    /**
     * @Route("/dashboard/delete", name="delete")
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
     * @Route("/dashboard/complete", name="complete")
     */

    public function completeAction(Request $request)
    {
        $korisnik = $this->get("security.token_storage")->getToken()->getUser();
        $todoLists = $korisnik->getTlists();
        $em = $this->getDoctrine()->getManager();


        if(isset($_GET['id'])) {
            $task = $em->getRepository('MtsBundle:Task')->findOneById($_GET['id']);

            if (!$task) {
                throw $this->createNotFoundException(
                    'No task found for id '.$_GET['id']
                );
            }
            $task->setIsCompleted(true);
            $em->persist($task);
            $em->flush();


            echo "ok";
        }


        return $this->render('MtsBundle:Dashboard:dashboard.html.twig',array("korisnik" => $korisnik,
        "todoLists" => $todoLists,)
        );
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

                    for ($i = 1; $i < 6; $i++) {
                        if (isset($_POST["taskName{$i}"])) {
                            $task = new Task();
                            $task->setName($_POST["taskName{$i}"]);
                        }
                        if (isset($_POST["deadline{$i}"])) {
                            $task->setDeadline(new \DateTime($_POST["deadline{$i}"]));
                        }
                        if (isset($_POST["priority{$i}"])) {
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
                            $task->setTlist($todolist);
                            $em->persist($task);
                        }
                    }





//                $em= $this->getDoctrine()->getManager();
                $em->persist($todolist);

                $em->flush();
                return $this->Redirect("/dashboard");
            }
            if (isset($_POST["dialog_task_name"])) {

                $task = new Task();
                $todolist= $em->getRepository('MtsBundle:Tlist')->findOneById($_POST["dialog_list_id"]);

                $task->setName($_POST["dialog_task_name"]);
                $task->setDeadline(new \DateTime($_POST["dialog_task_deadline"]));
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
                return $this->render('MtsBundle:Dashboard:dashboard.html.twig',array(
                    "korisnik" => $korisnik,
                    "todoLists" => $korisnik->getTlists(),
                ));

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
            $task = $em->getRepository('MtsBundle:Task')->findOneById($_POST['dialog_task_id']);
            $task->setName($_POST["dialog_task_name"]);
            $task->setDeadline(new \DateTime($_POST["dialog_task_deadline"]));
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
                "todoLists" => $korisnik->getTlists(),
            ));
        }
        return $this->render("MtsBundle:Dashboard:dashboard.html.twig", array(
            "korisnik" => $korisnik,
            "todoLists" => $korisnik->getTlists(),
        ));
    }
}