<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use App\Entity\Comments;

  /**
    * Cette classe est un écouteur d'évenements qui va écouter toues les opérations post de l'application, 
    * et executera la méthode public function setCurrentUser à chaque fois qu'un post opération est fait
    */
    
final class CurrentUserSubscriber implements EventSubscriberInterface
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * CurrentUserSubscriber constructor.
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => [['setCurrentUser', EventPriorities::PRE_WRITE]],
        ];
    }

    public function setCurrentUser(ViewEvent $event)
    {
    /**
    * Pour débugger, faire un dump de tes variables ici
    */
    
        $object = $event->getControllerResult();
        if ($object instanceof Comments) {        
        $object->setAuteur($this->tokenStorage->getToken()->getUser());
        $object->setPublishedAt(new \Datetime('now'));
        $event->setControllerResult($object);
        }
        // if ($object instanceof Valeur) {        
        // $object->setAuthor($this->tokenStorage->getToken()->getUser());
        // $event->setControllerResult($object);
        // }
        if ($object instanceof Property){
            // $object->setUser($this->tokenStorage->getToken()->getUser());
            // $event->setControllerResult($object);
        }
    }
}