<?php
namespace RC\ServiredBundle\Service;

use Symfony\Component\Routing\Router;
use RC\ServiredBundle\Service\Signature;

class FactorySignature{

    /**
     * @var Router
     */
    protected $router;

    public function __construct($router){
        $this->router = $router;
    }

    public function create($clave, $name, $code, $terminal, $transactiontype, $provider, $paymethod){

        $signature = new Signature($clave, $name, $code, $terminal, $transactiontype, $provider, $paymethod);

        $signature->setUrl($this->router->generate('rc_servired_done', array(), true));
        $signature->setUrlOK($this->router->generate('rc_servired_success', array(), true));
        $signature->setUrlKO($this->router->generate('rc_servired_failed', array(), true));

        return $signature;
    }
}
