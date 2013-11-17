<?php
namespace RC\ServiredBundle\Tests\Resources\Transaction;

use RC\ServiredBundle\Event\PaymentEvent;
use RC\ServiredBundle\Transaction\Response;

class ResponseTest  {



    public function setUp(){

    }

    public function tearDown(){

    }

    public function testIsValid(){
        $this->assertTrue(Response::isValid('0000'));
        $this->assertTrue(Response::isValid('0099'));
    }

    public function testNotIsValid(){
        $this->assertFalse(Response::isValid('0100'));
        $this->assertFalse(Response::isValid('9999'));
    }

    public function testGetMessageValid(){
        $this->assertEqual(Response::getMessage('0010'), Response::CODE_0000);
    }

    public function testGetMessageNotValid(){
        $this->assertEqual(Response::getMessage('9913'), Response::CODE_FAILED);
        $this->assertEqual(Response::getMessage('99999'), Response::CODE_FAILED);
    }

    public function testGetMessageCodeExists(){
        $this->assertEqual(Response::getMessage('0912'), Response::CODE_0912);
        $this->assertEqual(Response::getMessage('0202'), Response::CODE_0202);
        $this->assertEqual(Response::getMessage('191'), Response::CODE_0191);
        $this->assertEqual(Response::getMessage(190), Response::CODE_0190);
    }

}