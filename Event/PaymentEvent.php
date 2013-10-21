<?php
namespace RC\ServiredBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class PaymentEvent extends Event
{

    protected $entity_manager;
    protected $transaction;
    protected $id;
    protected $status;

    public function __construct($transaction, $id, $status, $entity_manager){
        $this->transaction = $transaction;
        $this->id = $id;
        $this->status = $status;
        $this->entity_manager = $entity_manager;
    }

    /**
     * @return mixed
     */
    public function getEntityManager()
    {
        return $this->entity_manager;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getTransaction()
    {
        return $this->transaction;
    }


}