<?php
namespace RC\ServiredBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="transaction")
 */
class Transaction
{


    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     *
     * @ORM\Column(type="string", length=100 , nullable=true)
     */
    protected $Ds_Response;


    /**
     *
     * @ORM\Column(type="string", length=100 , nullable=true)
     */
    protected $Ds_Card_Country;

    /**
     *
     * @ORM\Column(type="string", length=100 , nullable=true)
     */
    protected $Ds_Date;

    /**
     * @ORM\Column(type="string", length=100 , nullable=true)
     */
    protected $Ds_SecurePayment;

    /**
     * @ORM\Column(type="string", length=100 , nullable=true)
     */
    protected $Ds_Signature;

    /**
     * @ORM\Column(type="string", length=100 , nullable=true)
     */
    protected $Ds_Order;

    /**
     * @ORM\Column(type="string", length=100 , nullable=true)
     */
    protected $Ds_TransactionType;

    /**
     * @ORM\Column(type="string", length=100 , nullable=true)
     */
    protected $Ds_Hour;

    /**
     * @ORM\Column(type="string", length=100 , nullable=true)
     */
    protected $Ds_AuthorisationCode;

    /**
     * @ORM\Column(type="string", length=100 , nullable=true)
     */
    protected $Ds_Currency;

    /**
     * @ORM\Column(type="string", length=100 , nullable=true)
     */
    protected $Ds_ConsumerLanguage;

    /**
     * @ORM\Column(type="string", length=100 , nullable=true)
     */
    protected $Ds_MerchantCode;

    /**
     * @ORM\Column(type="string", length=100 , nullable=true)
     */
    protected $Ds_Amount;

    /**
     * @ORM\Column(type="string", length=100 , nullable=true)
     */
    protected $Ds_Terminal;

    public function __construct($orderId){
        $this->Ds_Order = $orderId;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDsResponse(){
        return $this->Ds_Response;
    }

    public function setDsResponse($Ds_Response){
        $this->Ds_Response = $Ds_Response;
    }

    public function getDsCardCountry(){
        return $this->Ds_Card_Country;
    }

    public function setDsCardCountry($Ds_Card_Country){
        $this->Ds_Card_Country = $Ds_Card_Country;
    }

    public function getDsDate(){
        return $this->Ds_Date;
    }

    public function setDsDate($Ds_Date){
        $this->Ds_Date = $Ds_Date;
    }

    public function getDsSecurePayment(){
        return $this->Ds_SecurePayment;
    }

    public function setDsSecurePayment($Ds_SecurePayment){
        $this->Ds_SecurePayment = $Ds_SecurePayment;
    }

    public function getDsSignature(){
        return $this->Ds_Signature;
    }

    public function setDsSignature($Ds_Signature){
        $this->Ds_Signature = $Ds_Signature;
    }

    public function getDsOrder(){
        return $this->Ds_Order;
    }

    public function getDs_Order(){
        return $this->Ds_Order;
    }

    public function setDsOrder($Ds_Order){
        $this->Ds_Order = $Ds_Order;
    }

    public function getDsTransactionType(){
        return $this->Ds_TransactionType;
    }

    public function setDsTransactionType($Ds_TransactionType){
        $this->Ds_TransactionType = $Ds_TransactionType;
    }

    public function getDsHour(){
        return $this->Ds_Hour;
    }

    public function setDsHour($Ds_Hour){
        $this->Ds_Hour = $Ds_Hour;
    }

    public function getDsAuthorisationCode(){
        return $this->Ds_AuthorisationCode;
    }

    public function setDsAuthorisationCode($Ds_AuthorisationCode){
        $this->Ds_AuthorisationCode = $Ds_AuthorisationCode;
    }

    public function getDsCurrency(){
        return $this->Ds_Currency;
    }

    public function setDsCurrency($Ds_Currency){
        $this->Ds_Currency = $Ds_Currency;
    }

    public function getDsConsumerLanguage(){
        return $this->Ds_ConsumerLanguage;
    }

    public function setDsConsumerLanguage($Ds_ConsumerLanguage){
        $this->Ds_ConsumerLanguage = $Ds_ConsumerLanguage;
    }

    public function getDsMerchantCode(){
        return $this->Ds_MerchantCode;
    }

    public function setDsMerchantCode($Ds_MerchantCode){
        $this->Ds_MerchantCode = $Ds_MerchantCode;
    }

    public function getDsAmount(){
        return (is_numeric($this->Ds_Amount)) ? number_format($this->Ds_Amount / 100, 2, ',', '.') : 0 ;
    }

    public function setDsAmount($Ds_Amount){
        $this->Ds_Amount = $Ds_Amount ;
    }

    public function getDsTerminal(){
        return $this->Ds_Terminal;
    }

    public function setDsTerminal($Ds_Terminal){
        $this->Ds_Terminal = $Ds_Terminal;
    }

    public function bind($data){
        foreach($data as $k => $v){
            if( property_exists($this, $k)){
                $this->$k = $v;
            }
        }
    }


}