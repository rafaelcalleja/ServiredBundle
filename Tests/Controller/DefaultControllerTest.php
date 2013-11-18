<?php

namespace RC\ServiredBundle\Tests\Controller;

use RC\ServiredBundle\Entity\Transaction;
use RC\ServiredBundle\Entity\TransactionManager;
use RC\ServiredBundle\Tests\Functional\BaseTestCase;
use RC\ServiredBundle\Exception\NotFoundTransactionException;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\EventListener\ExceptionListener;


class DefaultControllerTest extends BaseTestCase
{

    /** @var Client */
    protected $client;

    protected $route_index, $route_done, $route_success, $route_failed, $route_retry;

    /** @var Transaction */
    protected $transaction;

    /** @var TransactionManager */
    protected $manager;


    public function setUp(){

        $this->client = static::createClient();
        $this->route_index = $this->getContainer()->get('router')->generate('rc_servired_payment', array('amount' => 10, 'id' => 1), false);
        $this->route_done = $this->getContainer()->get('router')->generate('rc_servired_done', array(), false);
        $this->route_success = $this->getContainer()->get('router')->generate('rc_servired_success', array(), false);
        $this->route_failed = $this->getContainer()->get('router')->generate('rc_servired_failed', array(), false);
        $this->route_retry = $this->getContainer()->get('router')->generate('rc_servired_retry', array(), false);

        $this->manager = $this->getContainer()->get('rc_servired.transaction.manager');



    }

    public function tearDown(){

        if( $this->transaction instanceof Transaction ){
            $this->manager->getEntityManager()->remove($this->transaction);
            $this->manager->getEntityManager()->flush();
        }

        $this->transaction = null;
        $this->manager = null;
        $this->client = null;
    }




    /**
     * @expectedException \RC\ServiredBundle\Exception\NotFoundTransactionException
     * @expectedExceptionMessage Transaction not found
     */
    public function testNoTransactionPrevCreated()
    {
        // store the current error_log, and disable it temporarily
        $errorLog = ini_set('error_log', file_exists('/dev/null') ? '/dev/null' : 'nul');

        $crawler = $this->client->request('GET', $this->route_index);

        // restore the old error_log
        ini_set('error_log', $errorLog);

    }


    public function testCreateTransAndRedirectToTpv()
    {
        $this->transaction = new Transaction(1);
        $this->manager->update($this->transaction);

        /** @var $crawler */
        $crawler = $this->client->request('GET', $this->route_index);
        $this->assertEquals($crawler->filter('body:contains(form)')->count(), 1);


    }
}
