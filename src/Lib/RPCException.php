<?php
/**
 * Created by PhpStorm.
 * User: lee
 * Date: 11/12/2017
 * Time: 3:15 PM
 */

namespace Jcsofts\LaravelEthereum\Lib;


class RPCException extends \Exception
{
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function __toString()
    {
        return __CLASS__ . ": ".(($this->code > 0)?"[{$this->code}]:":"")." {$this->message}\n";
    }
}