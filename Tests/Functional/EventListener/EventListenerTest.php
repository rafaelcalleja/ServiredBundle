<?php

namespace RC\ServiredBundle\Tests\Functional\EventListener;

use Doctrine\Common\EventManager;
use RC\ServiredBundle\Event\ServiredEvent;
use RC\ServiredBundle\Tests\Resources\Event\TransactionListenerTest;
use RC\ServiredBundle\Entity\Transaction;
use RC\ServiredBundle\Entity\TransactionManager;
use RC\ServiredBundle\EventListener\TransactionSubscriber;
use RC\ServiredBundle\Tests\Functional\BaseTestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;


class EventListenerTest extends BaseTestCase
{

    /** @var TransactionListenerTest */
    protected $listener;

    /** @var EventDispatcher */
    protected $dispatcher;

    /** @var TransactionManager */
    protected $manager;


    /** @var EventManager */
    protected $eventManager;


    public function setUp(){

        $this->manager = $this->getContainer()->get('rc_servired.transaction.manager');

        $this->listener = $this->getMock('RC\ServiredBundle\Tests\Resources\Event\TransactionListenerTest');
        $this->dispatcher = $this->getContainer()->get('event_dispatcher');

        $this->dispatcher->addListener(ServiredEvent::PRE_PAYMENT_SUCCESS, array($this->listener, 'prePaymentSuccess'));
        $this->dispatcher->addListener(ServiredEvent::PRE_PAYMENT_FAILED, array($this->listener, 'prePaymentFailed'));
        $this->dispatcher->addListener(ServiredEvent::POST_PAYMENT_SUCCESS, array($this->listener, 'postPaymentSuccess'));
        $this->dispatcher->addListener(ServiredEvent::POST_PAYMENT_FAILED, array($this->listener, 'postPaymentFailed'));


        $this->transaction = new Transaction(time());

    }

    public function tearDown(){
        $this->manager->getEntityManager()->remove($this->transaction);
        $this->manager->getEntityManager()->flush();
        $this->transaction = null;
        $this->listener = null;
        $this->dispatcher = null;
    }

    public function testDispatcherHasListener() {
        $this->assertTrue($this->dispatcher->hasListeners(ServiredEvent::PRE_PAYMENT_SUCCESS));
        $this->assertTrue($this->dispatcher->hasListeners(ServiredEvent::PRE_PAYMENT_FAILED));
        $this->assertTrue($this->dispatcher->hasListeners(ServiredEvent::POST_PAYMENT_SUCCESS));
        $this->assertTrue($this->dispatcher->hasListeners(ServiredEvent::POST_PAYMENT_FAILED));
    }



    public function testPaymentSuccess(){

        $this->listener
            ->expects($this->once())
            ->method('prePaymentSuccess');

        $this->listener
            ->expects($this->once())
            ->method('postPaymentSuccess');

        $this->transaction->setDsResponse('0000');
        $this->manager->update($this->transaction);
    }

    public function testPaymentFailed(){

        $this->listener
            ->expects($this->once())
            ->method('prePaymentFailed');

        $this->listener
            ->expects($this->once())
            ->method('postPaymentFailed');

        $this->transaction->setDsResponse('9999');
        $this->manager->update($this->transaction);
    }





}