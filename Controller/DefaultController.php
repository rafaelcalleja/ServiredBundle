<?php

namespace RC\ServiredBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use RC\ServiredBundle\Entity\TPV;
use RC\ServiredBundle\Entity\Transaction;
use RC\ServiredBundle\Session\ServiredSession;
use RC\ServiredBundle\Transaction\Response as TransactionResponse;

class DefaultController extends Controller
{

    public function indexAction($amount, $id){

        /** @var $signature \RC\ServiredBundle\Service\Signature */
        $signature = $this->get('rc_servired.signature');

        /** @var $payment \RC\ServiredBundle\Entity\TPV */
        $payment = new TPV();


        $signature->setOrder($id);
        $payment = $signature->fillTPV($payment, $amount);

        if( $this->get('validator')->validate($payment) ){

            $this->get('rc_servired.session.manager')->create($amount, $id, $this->getTransactionById($id)->getId());
            return $this->render('RCServiredBundle:Default:index.html.twig', array('entity' => $payment));

        }


    }

    public function retryAction(){

        if( !$this->get('rc_servired.session.manager')->isActive() ) throw $this->createNotFoundException('Page not found');

        if ( $this->get('rc_servired.transaction.manager')->isOrderCompleted( $this->get('rc_servired.session.manager')->getCurrentOrder() ) ) throw new \Exception('Número de pedido repetido');

        return $this->indexAction( $this->get('rc_servired.session.manager')->get(ServiredSession::RC_SERVIRED_AMOUNT_KEY), $this->get('rc_servired.session.manager')->get(ServiredSession::RC_SERVIRED_ORDER_KEY) );


    }

    /*
     * Este controlador es llamado por la caixa asyncronamente, tras finalizar un pago correctamente
     * El parametro establecido en la configuracion como url debe ser accesible via internet, es decir, route id: rc_servired_done debe poder recibir una petición POST externa.
     */

    public function doneAction(){

        try{

            /** @var $request \Symfony\Component\HttpFoundation\Request */
            $request = $this->get('request');

            if ( $request->getMethod() != 'POST') throw $this->createNotFoundException('Page not found');

            $transId = $request->request->get('Ds_Order');
            $status = $request->request->get('Ds_Response');

            /** @var $transaction \RC\ServiredBundle\Entity\Transaction */
            $transaction = $this->getTransactionById($transId);

            $transaction->bind($request->request->all());

            /** @var $signature \RC\ServiredBundle\Service\Signature */
            $signature = $this->get('rc_servired.signature');

            if( $signature->getSingatureResponse($transaction->getDsAmount(), $transId, $status, $transaction->getDsCurrency()) !== $transaction->getDsSignature() ){
                throw new \Exception('Invalid Signature');
            }


            //TODO Guardamos transacciones erroneas, podriamos almacenar el texto del mensaje para su facil lectura.
            $this->get('rc_servired.transaction.manager')->update($transaction);

            return new RedirectResponse($this->container->getParameter('rc_servired.url'));

        }catch(\Exception $e){
            if(!$e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException ){

            }else{
                throw $e;
            }
            throw $e;
            return new Response('');
        }
    }

    public function successAction(){
        $this->get('rc_servired.session.manager')->remove();
        return new RedirectResponse($this->container->getParameter('rc_servired.url_ok'));

    }

    public function failedAction(){

           return new RedirectResponse($this->container->getParameter('rc_servired.url_ko'));

    }

    protected function getTransactionById($id){

        $transaction = $this->get('rc_servired.transaction.manager')->find($id);

        if(!$transaction instanceof Transaction){
            throw new \Exception('Unknown Transaction');
        }

        return $transaction;

    }


}
