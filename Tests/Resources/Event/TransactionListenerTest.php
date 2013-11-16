<?php
namespace RC\ServiredBundle\Tests\Resources\Event;

use RC\ServiredBundle\Event\PaymentEvent;

class TransactionListenerTest  {

    protected $event;

    public function __construct(){

    }

    public function prePaymentSuccess(PaymentEvent $event){
        $this->event =  $event;
    }

    public function prePaymentFailed(PaymentEvent $event){
        $this->event =  $event;
    }

    public function postPaymentSuccess(PaymentEvent $event){
        $this->event =  $event;
    }

    public function postPaymentFailed(PaymentEvent $event){
        $this->event =  $event;
    }

    public function getEvent(){
        return $this->event;
    }


}
