<?php
namespace RC\ServiredBundle\Tests\Functional\Transaction;

use RC\ServiredBundle\Tests\Functional\BaseTestCase;
use RC\ServiredBundle\Transaction\Response;

class ResponseTest extends BaseTestCase  {



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
        $this->assertEquals(Response::getMessage('0010'), Response::CODE_0000);
    }

    public function testGetMessageNotValid(){
        $this->assertEquals(Response::getMessage('9913'), Response::CODE_FAILED);
        $this->assertEquals(Response::getMessage('99999'), Response::CODE_FAILED);
    }

    public function testGetMessageCodeExists(){
        $this->assertEquals(Response::getMessage('0912'), Response::CODE_0912);
        $this->assertEquals(Response::getMessage('0202'), Response::CODE_0202);
        $this->assertEquals(Response::getMessage('191'), Response::CODE_0191);
        $this->assertEquals(Response::getMessage(190), Response::CODE_0190);
    }

}