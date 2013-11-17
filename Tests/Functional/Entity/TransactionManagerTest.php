<?php
namespace RC\ServiredBundle\Tests\Functional\Entity;

use Doctrine\Common\Persistence\ObjectManager;
use RC\ServiredBundle\Entity\Transaction;
use RC\ServiredBundle\Entity\TransactionManager;
use RC\ServiredBundle\Tests\Functional\BaseTestCase;
use RC\ServiredBundle\Transaction\Response;

class TransactionManagerTest  extends BaseTestCase {


    /** @var TransactionManager */
    protected $manager;

    /** @var Transaction */
    protected $transaction;

    public function setUp(){
        $this->manager = $this->getContainer()->get('rc_servired.transaction.manager');
    }



    public function tearDown(){

        if( $this->transaction instanceof Transaction ){
            $this->manager->getEntityManager()->remove($this->transaction);
            $this->manager->getEntityManager()->flush();
        }

        $this->manager = null;
    }

    public function testGetEM(){

        $em = $this->manager->getEntityManager();
        $this->assertTrue($em instanceof ObjectManager);
    }

    public function testFindFailed(){
        $this->assertNull($this->manager->find(1));
    }

    public function testFindSuccess(){
        $new = new Transaction(12);

        $em = $this->manager->getEntityManager();
        $em->persist($new);
        $em->flush();

        $this->transaction = $this->manager->find(12);

        $this->assertTrue($this->transaction instanceof Transaction);
    }

    public function testIsOrderCompletedTrue(){

        $this->transaction = new Transaction(13);
        $this->transaction->setDsResponse('0000');

        $em = $this->manager->getEntityManager();
        $em->persist($this->transaction);
        $em->flush();

        $this->assertTrue($this->manager->isOrderCompleted(13));

    }

    public function testIsOrderCompletedFalse(){

        $this->transaction = new Transaction(14);

        $em = $this->manager->getEntityManager();
        $em->persist($this->transaction);
        $em->flush();

        $this->assertFalse($this->manager->isOrderCompleted(14));

    }

    public function testUpdateObject(){

        $this->transaction = new Transaction(15);
        $this->transaction->setDsCurrency(978);
        $this->manager->update($this->transaction);

        $recover = $this->manager->find(15);

        $this->assertEquals( $recover->getDsCurrency(), 978);

    }

    public function testUpdateException(){

        $this->setExpectedException('Doctrine\Common\Persistence\Mapping\MappingException');

        $obj = new \stdClass();
        $this->manager->update($obj);
    }

}