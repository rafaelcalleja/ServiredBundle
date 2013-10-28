<?php
namespace RC\ServiredBundle\Session;

use Symfony\Component\HttpFoundation\Session\Session;
use RC\ServiredBundle\Session\ServiredSession;

class SessionManager {

    /** @var $session Symfony\Component\HttpFoundation\Session\Session */
    protected $session;

    /** @param $session Symfony\Component\HttpFoundation\Session\Session */
    public function __construct(Session $session){
        $this->session = $session;
    }

    public function create($amount, $order, $id){
        $this->session->set(ServiredSession::RC_SERVIRED_AMOUNT_KEY, $amount);
        $this->session->set(ServiredSession::RC_SERVIRED_ORDER_KEY, $order);
        $this->session->set(ServiredSession::RC_SERVIRED_ID_KEY, $id);
    }

    public function remove(){
        $this->session->remove(ServiredSession::RC_SERVIRED_AMOUNT_KEY);
        $this->session->remove(ServiredSession::RC_SERVIRED_ORDER_KEY);
        $this->session->remove(ServiredSession::RC_SERVIRED_ID_KEY);
    }

    public function isActive(){
        return ( $this->session->get(ServiredSession::RC_SERVIRED_AMOUNT_KEY) && $this->session->get(ServiredSession::RC_SERVIRED_ORDER_KEY) && $this->session->get(ServiredSession::RC_SERVIRED_ID_KEY) );
    }

    public function get($key){
        return $this->session->get($key);
    }

    public function set($key, $value){
        return $this->session->set($key, $value);
    }

    public function getCurrentId(){
        return $this->get(ServiredSession::RC_SERVIRED_ID_KEY);
    }

    public function getCurrentOrder(){
        return $this->get( ServiredSession::RC_SERVIRED_ORDER_KEY );
    }

    public function setOrder($value){
        if( !$this->isActive() ) throw new \RuntimeException('No puede establecer un ID si no existe una transaccion activa');

        $this->set( ServiredSession::RC_SERVIRED_ORDER_KEY, $value);
    }



}