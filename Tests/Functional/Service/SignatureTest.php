<?php

namespace RC\ServiredBundle\Tests\Functional\Service;

use RC\ServiredBundle\Entity\TPV;
use RC\ServiredBundle\Service\Signature;
use RC\ServiredBundle\Tests\Functional\BaseTestCase;

class SignatureTest extends BaseTestCase
{

    /** @var $signature Signature */
    protected $signature;

    public function setUp(){
        /* setup */
        $this->signature = $this->getContainer()->get('rc_servired.signature');
    }

    protected function tearDown(){
        $this->signature = null;
    }

    public function testExceptionGetSignature(){
        $this->setExpectedException('InvalidArgumentException');
        $this->signature->getSignature(100);
    }

    /**
     * Ejemplo
     *
     *   IMPORTE (Ds_Merchant_Amount) = 1235 (va multiplicado por 100 para ser igual que el
     *   Ds_Merchant_Amount).
     *   NÚMERO DE PEDIDO (Ds_Merchant_Order) = 29292929
     *   CÓDIGO COMERCIO (Ds_Merchant_MerchantCode) = 201920191
     *   MONEDA (Ds_Merchant_Currency) = 978
     *   CLAVE SECRETA = h2u282kMks01923kmqpo
     *   Cadena resultado: 123529292929201920191978h2u282kMks01923kmqpo
     *   Resultado SHA-1: c8392b7874e2994c74fa8bea3e2dff38f3913c46
     *
     **/
    public function testGetSignature(){

        $clave = 'h2u282kMks01923kmqpo';
        $name = '';
        $code = '201920191';
        $terminal = '1';
        $transactiontype = '';
        $provider = '';
        $paymethod = 'T';


        /** @var Signature*/
        $signature = new Signature($clave, $name, $code, $terminal, $transactiontype, $provider, $paymethod);
        $signature->setOrder(29292929);

        $signed = $signature->getSignature(1235/100, 978);
        $this->assertEquals($signed, strtoupper('c8392b7874e2994c74fa8bea3e2dff38f3913c46'));

    }

    /** Para operaciones con Ds_Merchant_TransactionType = 5 o R*/
    /**
     * Ejemplo
     *
     *   IMPORTE (Ds_Merchant_Amount) = 1235 (va multiplicado por 100 para ser igual que el
     *   Ds_Merchant_Amount).
     *   NÚMERO DE PEDIDO (Ds_Merchant_Order) = 29292929
     *   CÓDIGO COMERCIO (Ds_Merchant_MerchantCode) = 201920191
     *   MONEDA (Ds_Merchant_Currency) = 978
     *   SUMA TOTAL = 2470
     *   CLAVE SECRETA = h2u282kMks01923kmqpo
     *   Cadena resultado: 12352929292920192019197824705h2u282kMks01923kmqpo
     *   Resultado SHA-1: c8392b7874e2994c74fa8bea3e2dff38f3913c46
     *
     **/

    public function testGetSignatureType2(){

        $clave = 'h2u282kMks01923kmqpo';
        $name = '';
        $code = '201920191';
        $terminal = '1';
        $transactiontype = '5';
        $provider = '';
        $paymethod = 'T';

        /** @var Signature*/
        $signature = new Signature($clave, $name, $code, $terminal, $transactiontype, $provider, $paymethod);
        $signature->setOrder(29292929);
        $signature->setSumtotal(2470/100);

        $signed = $signature->getSignature(1235/100, 978);
        $this->assertEquals($signed, strtoupper(sha1('12352929292920192019197824705h2u282kMks01923kmqpo')));


    }


    public function testGetSignatureResponse(){

        $orderId = 1384616676;

        /** @var Signature*/
        $this->signature->setOrder($orderId);
        $this->signature->setUrl('http://demo.serviredbundle.com/tpv/done');

        $amount = 12;
        $response = "0000";
        $currency = 978;

        $signed_response =  $this->signature->getSingatureResponse($amount, $orderId, $response, $currency);
        $this->assertEquals($signed_response, '9CA221D0A516ACF980947869711AB4FBB2870239');


    }

    public function testFillTPV(){

        $orderId = 1384616676;
        $url = 'http://demo.serviredbundle.com/tpv/done';
        $entity = new TPV();
        $this->signature->setOrder($orderId);
        $this->signature->setUrl($url);

        $fill = $this->signature->fillTPV($entity, 12, 978);

        $this->assertEquals($entity->getDsMerchantMerchantURL(), $url);
        $this->assertEquals($entity->getDsMerchantTransactionType(), '0');
        $this->assertEquals($entity->getDsMerchantTerminal(), '001' );
        $this->assertEquals($entity->getDsMerchantMerchantCode(), '327234688');
        $this->assertEquals($entity->getDsMerchantOrder(), $orderId);
        $this->assertEquals($entity->getDsMerchantCurrency(), 978);
        $this->assertEquals($entity->getDsMerchantAmount(), 1200);
        $this->assertEquals($entity->getDsMerchantMerchantSignature(), $this->signature->getSignature(12, 978));
        $this->assertEquals($entity->getProvider(), 'https://sis-t.redsys.es:25443/sis/realizarPago');
        $this->assertEquals($entity->getDsMerchantUrlOK(), 'http://localhost/tpv/success');
        $this->assertEquals($entity->getDsMerchantUrlKO(), 'http://localhost/tpv/failed');
        $this->assertEquals($entity->getDsMerchantMerchantName(), 'TPV Servired Bundle');
        $this->assertEquals($entity->getDsMerchantPayMethods(), 'T');




    }




}
