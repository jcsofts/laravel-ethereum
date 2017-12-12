<?php
namespace Jcsofts\LaravelEthereum\Lib;
/**
 * Created by PhpStorm.
 * User: lee
 * Date: 11/12/2017
 * Time: 1:38 PM
 */
class Ethereum extends JsonRPC
{
    private function ether_request($method, $params=array())
    {
        try
        {
            $ret = $this->request($method, $params);
            return $ret->result;
        }
        catch(RPCException $e)
        {
            throw $e;
        }
    }

    private function decode_hex($input)
    {
        if(substr($input, 0, 2) == '0x')
            $input = substr($input, 2);

        if(preg_match('/[a-f0-9]+/', $input))
            return hexdec($input);

        return $input;
    }

    function web3_clientVersion()
    {
        return $this->ether_request(__FUNCTION__);
    }

    function web3_sha3($input)
    {
        return $this->ether_request(__FUNCTION__, array($input));
    }

    function net_version()
    {
        return $this->ether_request(__FUNCTION__);
    }

    function net_listening()
    {
        return $this->ether_request(__FUNCTION__);
    }

    function net_peerCount()
    {
        return $this->ether_request(__FUNCTION__);
    }

    function eth_protocolVersion()
    {
        return $this->ether_request(__FUNCTION__);
    }

    function eth_coinbase()
    {
        return $this->ether_request(__FUNCTION__);
    }

    function eth_mining()
    {
        return $this->ether_request(__FUNCTION__);
    }

    function eth_hashrate()
    {
        return $this->ether_request(__FUNCTION__);
    }

    function eth_gasPrice()
    {
        return $this->ether_request(__FUNCTION__);
    }

    function eth_accounts()
    {
        return $this->ether_request(__FUNCTION__);
    }

    function eth_blockNumber($decode_hex=FALSE)
    {
        $block = $this->ether_request(__FUNCTION__);

        if($decode_hex)
            $block = $this->decode_hex($block);

        return $block;
    }

    function eth_getBalance($address, $block='latest', $decode_hex=FALSE)
    {
        $balance = $this->ether_request(__FUNCTION__, array($address, $block));

        if($decode_hex)
            $balance = $this->decode_hex($balance);

        return $balance;
    }

    function eth_getStorageAt($address, $at, $block='latest')
    {
        return $this->ether_request(__FUNCTION__, array($address, $at, $block));
    }

    function eth_getTransactionCount($address, $block='latest', $decode_hex=FALSE)
    {
        $count = $this->ether_request(__FUNCTION__, array($address, $block));

        if($decode_hex)
            $count = $this->decode_hex($count);

        return $count;
    }

    function eth_getBlockTransactionCountByHash($tx_hash)
    {
        return $this->ether_request(__FUNCTION__, array($tx_hash));
    }

    function eth_getBlockTransactionCountByNumber($tx='latest')
    {
        return $this->ether_request(__FUNCTION__, array($tx));
    }

    function eth_getUncleCountByBlockHash($block_hash)
    {
        return $this->ether_request(__FUNCTION__, array($block_hash));
    }

    function eth_getUncleCountByBlockNumber($block='latest')
    {
        return $this->ether_request(__FUNCTION__, array($block));
    }

    function eth_getCode($address, $block='latest')
    {
        return $this->ether_request(__FUNCTION__, array($address, $block));
    }

    function eth_sign($address, $input)
    {
        return $this->ether_request(__FUNCTION__, array($address, $input));
    }

    function eth_sendTransaction($transaction)
    {
        if(!is_a($transaction, EthereumTransaction::class))
        {
            throw new ErrorException('Transaction object expected');
        }
        else
        {
            return $this->ether_request(__FUNCTION__, $transaction->toArray());
        }
    }

    function eth_call($message, $block)
    {
        if(!is_a($message, EthereumMessage::class))
        {
            throw new ErrorException('Message object expected');
        }
        else
        {
            return $this->ether_request(__FUNCTION__, $message->toArray());
        }
    }

    function eth_estimateGas($message, $block)
    {
        if(!is_a($message, EthereumMessage::class))
        {
            throw new ErrorException('Message object expected');
        }
        else
        {
            return $this->ether_request(__FUNCTION__, $message->toArray());
        }
    }

    function eth_getBlockByHash($hash, $full_tx=TRUE)
    {
        return $this->ether_request(__FUNCTION__, array($hash, $full_tx));
    }

    function eth_getBlockByNumber($block='latest', $full_tx=TRUE)
    {
        return $this->ether_request(__FUNCTION__, array($block, $full_tx));
    }

    function eth_getTransactionByHash($hash)
    {
        return $this->ether_request(__FUNCTION__, array($hash));
    }

    function eth_getTransactionByBlockHashAndIndex($hash, $index)
    {
        return $this->ether_request(__FUNCTION__, array($hash, $index));
    }

    function eth_getTransactionByBlockNumberAndIndex($block, $index)
    {
        return $this->ether_request(__FUNCTION__, array($block, $index));
    }

    function eth_getTransactionReceipt($tx_hash)
    {
        return $this->ether_request(__FUNCTION__, array($tx_hash));
    }

    function eth_getUncleByBlockHashAndIndex($hash, $index)
    {
        return $this->ether_request(__FUNCTION__, array($hash, $index));
    }

    function eth_getUncleByBlockNumberAndIndex($block, $index)
    {
        return $this->ether_request(__FUNCTION__, array($block, $index));
    }

    function eth_getCompilers()
    {
        return $this->ether_request(__FUNCTION__);
    }

    function eth_compileSolidity($code)
    {
        return $this->ether_request(__FUNCTION__, array($code));
    }

    function eth_compileLLL($code)
    {
        return $this->ether_request(__FUNCTION__, array($code));
    }

    function eth_compileSerpent($code)
    {
        return $this->ether_request(__FUNCTION__, array($code));
    }

    function eth_newFilter($filter, $decode_hex=FALSE)
    {
        if(!is_a($filter, EthereumFilter::class))
        {
            throw new ErrorException('Expected a Filter object');
        }
        else
        {
            $id = $this->ether_request(__FUNCTION__, $filter->toArray());

            if($decode_hex)
                $id = $this->decode_hex($id);

            return $id;
        }
    }

    function eth_newBlockFilter($decode_hex=FALSE)
    {
        $id = $this->ether_request(__FUNCTION__);

        if($decode_hex)
            $id = $this->decode_hex($id);

        return $id;
    }

    function eth_newPendingTransactionFilter($decode_hex=FALSE)
    {
        $id = $this->ether_request(__FUNCTION__);

        if($decode_hex)
            $id = $this->decode_hex($id);

        return $id;
    }

    function eth_uninstallFilter($id)
    {
        return $this->ether_request(__FUNCTION__, array($id));
    }

    function eth_getFilterChanges($id)
    {
        return $this->ether_request(__FUNCTION__, array($id));
    }

    function eth_getFilterLogs($id)
    {
        return $this->ether_request(__FUNCTION__, array($id));
    }

    function eth_getLogs($filter)
    {
        if(!is_a($filter, EthereumFilter::class))
        {
            throw new ErrorException('Expected a Filter object');
        }
        else
        {
            return $this->ether_request(__FUNCTION__, $filter->toArray());
        }
    }

    function eth_getWork()
    {
        return $this->ether_request(__FUNCTION__);
    }

    function eth_submitWork($nonce, $pow_hash, $mix_digest)
    {
        return $this->ether_request(__FUNCTION__, array($nonce, $pow_hash, $mix_digest));
    }

    function db_putString($db, $key, $value)
    {
        return $this->ether_request(__FUNCTION__, array($db, $key, $value));
    }

    function db_getString($db, $key)
    {
        return $this->ether_request(__FUNCTION__, array($db, $key));
    }

    function db_putHex($db, $key, $value)
    {
        return $this->ether_request(__FUNCTION__, array($db, $key, $value));
    }

    function db_getHex($db, $key)
    {
        return $this->ether_request(__FUNCTION__, array($db, $key));
    }

    function shh_version()
    {
        return $this->ether_request(__FUNCTION__);
    }

    function shh_post($post)
    {
        if(!is_a($post, WhisperPost::class))
        {
            throw new \ErrorException('Expected a Whisper post');
        }
        else
        {
            return $this->ether_request(__FUNCTION__, $post->toArray());
        }
    }

    function shh_newIdentity()
    {
        return $this->ether_request(__FUNCTION__);
    }

    function shh_hasIdentity($id)
    {
        return $this->ether_request(__FUNCTION__);
    }

    function shh_newFilter($to=NULL, $topics=array())
    {
        return $this->ether_request(__FUNCTION__, array(array('to'=>$to, 'topics'=>$topics)));
    }

    function shh_uninstallFilter($id)
    {
        return $this->ether_request(__FUNCTION__, array($id));
    }

    function shh_getFilterChanges($id)
    {
        return $this->ether_request(__FUNCTION__, array($id));
    }

    function shh_getMessages($id)
    {
        return $this->ether_request(__FUNCTION__, array($id));
    }

    function personal_newAccount($passphrase){
        return $this->ether_request(__FUNCTION__, array($passphrase));
    }

    function personal_listAccounts(){
        return $this->ether_request(__FUNCTION__);
    }

    function personal_unlockAccount($address,$passphrase,$duration=300){
        return $this->ether_request(__FUNCTION__, array($address,$passphrase,$duration));
    }

    function personal_lockAccount($address){
        return $this->ether_request(__FUNCTION__, array($address));
    }

    function personal_ecRecover($message, $signature){
        return $this->ether_request(__FUNCTION__, array($message,$signature));
    }

    function personal_importRawKey($keydata, $passphrase){
        return $this->ether_request(__FUNCTION__, array($keydata,$passphrase));
    }

    function personal_sendTransaction(EthereumTransaction $transaction,$passphrase){
        $params=$transaction->toArray();
        array_push($params,$passphrase);
        return $this->ether_request(__FUNCTION__, $params);
    }
}