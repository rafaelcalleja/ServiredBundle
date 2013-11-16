<?php 
namespace RC\ServiredBundle\Service;

use Symfony\Component\Config\Definition\Exception\Exception;

class Signature {

	protected $clave;
	protected $name;
	protected $code;
	protected $terminal;
	protected $transactiontype;
	protected $url;
	protected $order;
	protected $provider;
	protected $url_ok;
	protected $url_ko;
    protected $paymethod;
	protected $sumtotal;

	public function __construct($clave, $name, $code, $terminal, $transactiontype, $provider, $paymethod){
		$this->clave = $clave;
		$this->name = $name;
		$this->code = $code;
		$this->terminal = $terminal;
		$this->transactiontype = $transactiontype;
		$this->provider = $provider;
        $this->paymethod = $paymethod;
	}
	
	public function getSignature($amount, $currency = 978){

        if(!$this->getOrder()){
            throw new \InvalidArgumentException(sprintf('Error en %s: antes debes usar setOrder($order)  ',__FUNCTION__));
        }

        $message = function( $amount, $currency ) {

            switch($this->transactiontype){
                case 5:
                case 'R':
                    return  ( $amount * 100 ).$this->getOrder().$this->code.$currency.$this->getSumtotal().$this->transactiontype.$this->url.$this->clave;
                    break;
                default:
                    return  ( $amount * 100 ).$this->getOrder().$this->code.$currency.$this->transactiontype.$this->url.$this->clave;
                    break;
            }

        };

		return strtoupper(sha1($message($amount, $currency)));
	}


    public function getSingatureResponse($amount, $orderId, $response, $currency = 978){
        $message = ( $amount * 100 ).$orderId.$this->code.$currency.$response.$this->clave;
        return strtoupper(sha1($message));
    }
	
	public function fillTPV($entity, $amount, $currency = 978){

        if( !$this->url_ok  ){
            throw new \InvalidArgumentException('Debes establecer el parametro url_ok via setUrlOK');
        }

        if( !$this->url_ko ){
            throw new \InvalidArgumentException('Debes establecer el parametro url_ko via setUrlKO');
        }

        if( !$this->url ){
            throw new \InvalidArgumentException('Debes establecer el parametro url via setUrl');
        }

        if(!$this->getOrder()){
            throw new \InvalidArgumentException('Debes establecer $order via setOrder, antes de llamar a '.__FUNCTION__);
        }

		$entity->setDsMerchantTransactionType($this->transactiontype);
		$entity->setDsMerchantMerchantURL($this->url);
		$entity->setDsMerchantTerminal($this->terminal);
		$entity->setDsMerchantMerchantCode($this->code);
		$entity->setDsMerchantOrder($this->getOrder());
		$entity->setDsMerchantCurrency($currency);
		$entity->setDsMerchantAmount(( $amount * 100 ));
		$entity->setDsMerchantMerchantSignature($this->getSignature($amount, $currency));
		$entity->setProvider($this->provider);
		$entity->setDsMerchantUrlOK($this->url_ok);
		$entity->setDsMerchantUrlKO($this->url_ko);
		$entity->setDsMerchantMerchantName($this->name);
		$entity->setDsMerchantPayMethods($this->paymethod);
		
		return $entity;
	}
	
	public function setOrder($value){
		$this->order = $value;
	}
	
	public function getOrder(){
		return $this->order;
	}

    public function setUrlKO($value){
        $this->url_ko = $value;
    }

    public function setUrlOK($value){
        $this->url_ok = $value;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getSumtotal()
    {
        return $this->sumtotal;
    }

    /**
     * @param mixed $sumtotal
     */
    public function setSumtotal($sumtotal)
    {
        $this->sumtotal = $sumtotal * 100;
    }



}