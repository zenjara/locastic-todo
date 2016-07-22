<?php
/**
 * Created by PhpStorm.
 * User: IvanMatas
 * Date: 7/20/2016
 * Time: 7:52 PM
 */

namespace MtsBundle\Listener;


use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use DateTime;
use MtsBundle\Entity\Korisnik;
class Listener
{
    protected $context;
    protected $em;
    public function __construct(SecurityContext $context, Doctrine $doctrine)
    {
        $this->context = $context;
        $this->em = $doctrine->getEntityManager();
    }
    /**
     * On each request we want to update the user's last activity datetime
     *
     * @param \Symfony\Component\HttpKernel\Event\FilterControllerEvent $event
     * @return void
     */
    public function onCoreController(FilterControllerEvent $event)
    {
//        $korisnik = $this->context->get("security.token_storage")->getToken()->getUser();
        $user = $this->context->getToken()->getUser();
        if($user instanceof Korisnik)
        {
            //here we can update the user as necessary
            $user->setLastLoggedInAt(new DateTime());
            $this->em->persist($user);
            $this->em->flush($user);
        }
    }
}