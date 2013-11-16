<?php
namespace RC\ServiredBundle\Tests\Functional\Session;


use RC\ServiredBundle\Tests\Functional\BaseTestCase;
use RC\ServiredBundle\Session\SessionManager;
use RC\ServiredBundle\Session\ServiredSession;

class SessionManagerTest extends BaseTestCase
{

    CONST TEST_KEY = 'rc/test/key';

    /** @var $session SessionManager */
    protected $session;

    public function setUp(){
        /* setup */
        $this->session = $this->getContainer()->get('rc_servired.session.manager');

        $amount = 1;
        $order = 2;
        $id = 3;

        $this->session->create($amount, $order, $id);

    }

    protected function tearDown(){
        $this->session = null;
    }

    public function testCreate(){

        $this->assertEquals(1, $this->session->get(ServiredSession::RC_SERVIRED_AMOUNT_KEY));
        $this->assertEquals(2, $this->session->get(ServiredSession::RC_SERVIRED_ORDER_KEY));
        $this->assertEquals(3, $this->session->get(ServiredSession::RC_SERVIRED_ID_KEY));

    }

    public function testGetCurrentId(){
        $this->assertEquals($this->session->getCurrentId(), 3);
    }

    public function testGetCurrentOrder(){
        $this->assertEquals($this->session->getCurrentOrder(), 2);
    }

    public function testRemove(){
        $this->session->remove();

        $this->assertNull($this->session->get(ServiredSession::RC_SERVIRED_AMOUNT_KEY));
        $this->assertNull($this->session->get(ServiredSession::RC_SERVIRED_ORDER_KEY));
        $this->assertNull($this->session->get(ServiredSession::RC_SERVIRED_ID_KEY));
    }

    public function testSetOrderException(){
        $this->setExpectedException('RuntimeException');

        $this->session->remove();
        $this->session->setOrder(4);
    }

    public function testSetOrder(){
        $this->session->setOrder(4);

        $this->assertEquals(4, $this->session->get(ServiredSession::RC_SERVIRED_ORDER_KEY));

    }

    public function testMagicMethod(){
        $this->session->set(self::TEST_KEY, true);
        $this->assertTrue($this->session->get(self::TEST_KEY));
    }

    public function testIsActive(){

        $this->assertTrue($this->session->isActive());
        $this->session->remove();
        $this->assertFalse($this->session->isActive());


    }

    public function testExceptionMagicMethod(){
        $this->setExpectedException('BadMethodCallException');
        $this->session->unknown('args');

    }


}