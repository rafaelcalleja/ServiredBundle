<?php
namespace RC\ServiredBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class TPV
{

    /**
     * @Assert\NotBlank()
     */
    protected $Ds_Merchant_Amount;

    /**
     * @Assert\NotBlank()
     */
    protected $Ds_Merchant_Currency;

    /**
     * @Assert\NotBlank()
     */
    protected $Ds_Merchant_Order;

    /**
     * @Assert\NotBlank()
     */
    protected $Ds_Merchant_MerchantCode;

    /**
     * @Assert\NotBlank()
     */
    protected $Ds_Merchant_Terminal;

    /**
     * @Assert\NotBlank()
     */
    protected $Ds_Merchant_TransactionType;

    /**
     * @Assert\NotBlank()
     */
    protected $Ds_Merchant_MerchantURL;

    /**
     * @Assert\NotBlank()
     */
    protected $Ds_Merchant_MerchantSignature;

    /**
     * @Assert\NotBlank()
     */
    protected $provider;

    /**
     * @Assert\NotBlank()
     */
    protected $Ds_Merchant_UrlOK;

    /**
     * @Assert\NotBlank()
     */
    protected $Ds_Merchant_UrlKO;

    /**
     * @Assert\NotBlank()
     */
    protected $Ds_Merchant_MerchantName;

    /**
     * @Assert\NotBlank()
     */
    protected $Ds_Merchant_PayMethods;


    public function getDsMerchantPayMethods(){
        return $this->Ds_Merchant_PayMethods;
    }

    public function setDsMerchantPayMethods($value){
        $this->Ds_Merchant_PayMethods = $value;
    }


    public function getDsMerchantMerchantSignature(){
        return $this->Ds_Merchant_MerchantSignature;
    }

    public function setDsMerchantMerchantSignature($value){
        $this->Ds_Merchant_MerchantSignature = $value;
    }

    public function getDsMerchantAmount(){
        return $this->Ds_Merchant_Amount;
    }

    public function setDsMerchantAmount($value){
        $this->Ds_Merchant_Amount = $value;
    }

    public function getDsMerchantCurrency(){
        return $this->Ds_Merchant_Currency;
    }

    public function setDsMerchantCurrency($value){
        $this->Ds_Merchant_Currency = $value;
    }

    public function getDsMerchantOrder(){
        return $this->Ds_Merchant_Order;
    }

    public function setDsMerchantOrder($value){
        $this->Ds_Merchant_Order = $value;
    }

    public function getDsMerchantMerchantCode(){
        return $this->Ds_Merchant_MerchantCode;
    }

    public function setDsMerchantMerchantCode($value){
        $this->Ds_Merchant_MerchantCode = $value;
    }

    public function getDsMerchantTerminal(){
        return $this->Ds_Merchant_Terminal;
    }

    public function setDsMerchantTerminal($value){
        $this->Ds_Merchant_Terminal = $value;
    }

    public function setDsMerchantMerchantURL($value){
        $this->Ds_Merchant_MerchantURL = $value;
    }

    public function getDsMerchantMerchantURL(){
        return $this->Ds_Merchant_MerchantURL;
    }

    public function setDsMerchantTransactionType($value){
        $this->Ds_Merchant_TransactionType = $value;
    }

    public function getDsMerchantTransactionType(){
        return $this->Ds_Merchant_TransactionType;
    }

    public function setProvider($value){
        $this->provider = $value;
    }

    public function getProvider(){
        return $this->provider;
    }

    public function setDsMerchantUrlOK($value){
        $this->Ds_Merchant_UrlOK = $value;
    }

    public function getDsMerchantUrlOK(){
        return $this->Ds_Merchant_UrlOK;
    }

    public function setDsMerchantUrlKO($value){
        $this->Ds_Merchant_UrlKO = $value;
    }

    public function getDsMerchantUrlKO(){
        return $this->Ds_Merchant_UrlKO;
    }

    public function setDsMerchantMerchantName($value){
        $this->Ds_Merchant_MerchantName = $value;
    }

    public function getDsMerchantMerchantName(){
        return $this->Ds_Merchant_MerchantName;
    }





}