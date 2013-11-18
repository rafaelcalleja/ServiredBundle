<?php
namespace RC\ServiredBundle\Exception;

class NotFoundTransactionException extends TransactionException
{

    public function __construct($message = null, \Exception $previous = null, $code = 0)
    {
        parent::__construct(404, $message, $previous, $code);
    }
}
