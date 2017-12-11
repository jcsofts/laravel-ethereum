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

    /**
     * EthereumTransaction constructor.
     * @param $from
     * @param null $to
     * @param null $value
     * @param null $gas
     * @param null $gasPrice
     * @param null $data
     * @param null $nonce
     */
    function __construct($from, $to=null, $value=null, $gas=null, $gasPrice=null, $data=null, $nonce=NULL)
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
        $arr=['from'=>$this->from];
        if(!empty($this->to)){
            $arr['to']=$this->to;
        }
        if(!empty($this->value)){
            $arr['value']=$this->value;
        }
        if(!empty($this->gas)){
            $arr['gas']=$this->gas;
        }
        if(!empty($this->gasPrice)){
            $arr['gasPrice']=$this->gasPrice;
        }
        if(!empty($this->data)){
            $arr['data']=$this->data;
        }
        if(!empty($this->nonce)){
            $arr['nonce']=$this->nonce;
        }


        return array($arr);
    }
}