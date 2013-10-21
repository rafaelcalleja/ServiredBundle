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

            $this->get('session')->set(ServiredSession::TPV_LAST_IMPORTE_KEY, $amount);
            $this->get('session')->set(ServiredSession::TPV_LAST_ID_KEY, $id);
            return $this->render('RCServiredBundle:Default:index.html.twig', array('entity' => $payment));

        }


    }

    public function retryAction(){

        if(!$this->get('session')->get(ServiredSession::TPV_LAST_IMPORTE_KEY) || !$this->get('session')->get(ServiredSession::TPV_LAST_ID_KEY)) throw $this->createNotFoundException('Page not found');

        return $this->indexAction($this->get('session')->get(ServiredSession::TPV_LAST_IMPORTE_KEY), $this->get('session')->get(ServiredSession::TPV_LAST_ID_KEY));


    }

    /*
     * Este controlador es llamado por la caixa asyncronamente, tras finalizar un pago correctamente
     * El parametro establecido en la configuracion como url debe ser accesible via internet, es decir, URL debe poder recibir una peticion POST externa.
     */

    public function doneAction(){

        try{

            /** @var $request \Symfony\Component\HttpFoundation\Request */
            $request = $this->get('request');

            if ( $request->getMethod() != 'POST') throw $this->createNotFoundException('Page not found');

            $transId = $request->request->get('Ds_Order');
            $status = $request->request->get('Ds_Response');


            $em = $this->get('doctrine')->getManagerForClass('RC\ServiredBundle\Entity\Transaction');
            $repository = $em->getRepository('RCServiredBundle:Transaction');
            /** @var $transaction \RC\ServiredBundle\Entity\Transaction */
            $transaction = $repository->findOneBy(array('Ds_Order' => $transId));

            if(!$transaction instanceof Transaction){
                throw new \Exception('Unknown Transaction');
            }

            $transaction->bind($request->request->all());

            /** @var $signature \RC\ServiredBundle\Service\Signature */
            $signature = $this->get('rc_servired.signature');

            if( $signature->getSingatureResponse($transaction->getDsAmount(), $transId, $status, $transaction->getDsCurrency()) !== $transaction->getDsSignature() ){
                throw new \Exception('Invalid Signature');
            }


            //TODO Guardamos transacciones erroneas, podriamos almacenar el texto del mensaje para su facil lectura.
            $em->persist($transaction);
            $em->flush();


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

        $this->get('session')->remove(ServiredSession::TPV_LAST_IMPORTE_KEY);
        $this->get('session')->remove(ServiredSession::TPV_LAST_ID_KEY);
        return new RedirectResponse($this->container->getParameter('rc_servired.url_ok'));

    }

    public function failedAction(){

           return new RedirectResponse($this->container->getParameter('rc_servired.url_ko'));

    }
}
