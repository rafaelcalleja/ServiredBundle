<?php
namespace RC\ServiredBundle\Transaction;

class Response{

    CONST CODE_0000 = 'Transacción Autorizada para pagos y preautorizaciones';
    CONST CODE_0900 = 'Transacción Autorizada para devoluciones y confirmaciones';
    CONST CODE_0101 = 'Tarjeta Caducada';
    CONST CODE_0102 = 'Tarjeta en excepción transitoria o bajo sospecha de fraude';
    CONST CODE_0116 = 'Disponible Insuficiente';
    CONST CODE_0118 = 'Tarjeta no Registrada';
    CONST CODE_0180 = 'Tarjeta ajena al servicio';
    CONST CODE_0184 = 'Error en la autenticación del titular';
    CONST CODE_0190 = 'Denegación sin especificar motivo';
    CONST CODE_0191 = 'Fecha de caducidad errónea';
    CONST CODE_0202 = 'Tarjeta en excepción transitoria o bajo sospecha de fraude con retirada de tarjeta';
    CONST CODE_0912 = 'Emisor no Disponible';
    CONST CODE_FAILED = 'Transacción denegada';

    public static function isValid($code){
        return intval($code) < 100 ;
    }

    public static function getMessage($code){

        if(self::isValid($code)) return self::CODE_0000;

        $strcode = 'CODE_'.str_pad($code, 4, "0", STR_PAD_LEFT);
        if( defined('self::'.$strcode) ) return constant('self::'.$strcode);

        if( intval($code) > 912 && intval($code) <= 9912  ) return self::CODE_0912;

        return self::CODE_FAILED;
    }

}