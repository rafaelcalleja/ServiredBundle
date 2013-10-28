<?php
namespace RC\ServiredBundle\Entity;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\RegistryInterface;


class TransactionManager{

    const TRANSACTION_CLASS = 'RC\ServiredBundle\Entity\Transaction';

    /** @var \Symfony\Bridge\Doctrine\RegistryInterface $registry */
    protected $registry;

    protected $entityManager;

    /**
     * @param \Symfony\Bridge\Doctrine\RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry){
        $this->registry = $registry;

        $this->entityManager = $this->getEntityManager();
    }


    /**
     * {@inheritdoc}
     */
    public function findBy(array $criteria = array())
    {
        return $this->getEntityManager()->getRepository(self::TRANSACTION_CLASS)->findBy($criteria);
    }

    /**
     * {@inheritdoc}
     */
    public function findOneBy(array $criteria = array())
    {
        return $this->getEntityManager()->getRepository(self::TRANSACTION_CLASS)->findOneBy($criteria);
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityManager(){

        if( $this->entityManager instanceof ObjectManager ) return $this->entityManager;

        $em = $this->registry->getManagerForClass(self::TRANSACTION_CLASS);

        if (!$em) {
            throw new \RuntimeException(sprintf('No entity manager defined for class %s', self::TRANSACTION_CLASS));
        }

        return $em;
    }

    /**
     * {@inheritdoc}
     */
    public function update($object)
    {
        try {

            $entityManager = $this->getEntityManager();
            $entityManager->persist($object);
            $entityManager->flush();

        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function find($id){
       return $this->findOneBy(array('Ds_Order' => $id));
    }

    public function isOrderCompleted($id){

        $transaction = $this->find($id);

        if( !$transaction instanceof Transaction ) return false;

        $status = $transaction->getDsResponse();

        return !empty( $status ) ;

    }



}