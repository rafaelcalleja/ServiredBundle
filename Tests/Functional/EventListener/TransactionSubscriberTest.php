<?php

namespace RC\ServiredBundle\Tests\Functional\EventListener;

use Doctrine\Common\EventManager;
use RC\ServiredBundle\Entity\Transaction;
use RC\ServiredBundle\Entity\TransactionManager;
use RC\ServiredBundle\EventListener\TransactionSubscriber;
use RC\ServiredBundle\Tests\Functional\BaseTestCase;


class TransactionSubscriberTest extends BaseTestCase
{

    /** @var Transaction */
    protected $transaction;

    /** @var TransactionSubscriber */
    protected $subscriber;

    /** @var TransactionManager */
    protected $manager;


    /** @var EventManager */
    protected $eventManager;


    public function setUp(){

        $this->manager = $this->getContainer()->get('rc_servired.transaction.manager');
        $this->eventManager = $this->manager->getEntityManager()->getEventManager();


        $this->transaction = new Transaction(time());

        $this->subscriber = $this->getMockBuilder('RC\ServiredBundle\EventListener\TransactionSubscriber')
            ->setMethods(array())
            ->setConstructorArgs( array($this->getContainer()->get('event_dispatcher')) )
            ->getMock();

        $this->subscriber
            ->expects($this->once())
            ->method('getSubscribedEvents')
            ->will($this->returnValue(array(
                'prePersist',
                'postPersist',
            )));

        $this->eventManager->addEventSubscriber($this->subscriber);
    }

    public function tearDown(){
        $this->manager->getEntityManager()->remove($this->transaction);
        $this->manager->getEntityManager()->flush();
        $this->transaction = null;
        $this->subscriber = null;
        $this->manager = null;
        $this->eventManager = null;
    }

    public function testEventManagerHasSubscriber(){

        $this->eventManager->removeEventSubscriber( $this->getContainer()->get('rc_servired.subscriber') );
        $this->assertTrue($this->eventManager->hasListeners('prePersist'));
        $this->assertTrue($this->eventManager->hasListeners('postPersist'));
    }

    public function testPreTransaction(){


        $this->subscriber
            ->expects($this->once())
            ->method('prePersist');

        $this->transaction->setDsResponse('0000');
        $this->manager->update($this->transaction);
    }

    public function testPostTransaction(){


        $this->subscriber
            ->expects($this->once())
            ->method('postPersist');

        $this->transaction->setDsResponse('9999');
        $this->manager->update($this->transaction);
    }

}