<?php
/**
 * Created by PhpStorm.
 * User: lee
 * Date: 11/12/2017
 * Time: 3:19 PM
 */

namespace Jcsofts\LaravelEthereum\Lib;


class EthereumTransaction
{
    private $to, $from, $gas, $gasPrice, $value, $data, $nonce;

    function __construct($from, $to, $gas, $gasPrice, $value, $data='', $nonce=NULL)
    {
        $this->from = $from;
        $this->to = $to;
        $this->gas = $gas;
        $this->gasPrice = $gasPrice;
        $this->value = $value;
        $this->data = $data;
        $this->nonce = $nonce;
    }

    function toArray()
    {
        return array(
            array
            (
                'from'=>$this->from,
                'to'=>$this->to,
                'gas'=>$this->gas,
                'gasPrice'=>$this->gasPrice,
                'value'=>$this->value,
                'data'=>$this->data,
                'nonce'=>$this->nonce
            )
        );
    }
}