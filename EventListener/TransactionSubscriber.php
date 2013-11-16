<?php
namespace RC\ServiredBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use RC\ServiredBundle\Entity\Transaction;
use RC\ServiredBundle\Event\ServiredEvent;
use RC\ServiredBundle\Event\PaymentEvent;
use RC\ServiredBundle\Transaction\Response;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class TransactionSubscriber implements EventSubscriber {

    /** @var  $dispatcher \Symfony\Component\EventDispatcher\EventDispatcher */
    protected $dispatcher;

    public function __construct(EventDispatcherInterface $dispatcher){
        $this->dispatcher = $dispatcher;
    }

    public function getSubscribedEvents(){

        return array(
            'prePersist',
            'postPersist',
        );

    }

    public function prePersist(LifecycleEventArgs $args){
        $this->index($args, 'PRE');
    }

    public function postPersist(LifecycleEventArgs $args){
        $this->index($args, 'POST');
    }

    public function index(LifecycleEventArgs $args, $prefix = 'PRE')
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        if ($entity instanceof Transaction) {
            $event = new PaymentEvent($entity, $entity->getDsOrder(), $entity->getDsResponse(), $entityManager);
            $status = ( Response::isValid($entity->getDsResponse()) ) ? 'SUCCESS' : 'FAILED';

            $raise = constant('RC\ServiredBundle\Event\ServiredEvent::'.$prefix.'_PAYMENT_'.$status);
            $this->dispatcher->dispatch($raise, $event);
        }
    }


}