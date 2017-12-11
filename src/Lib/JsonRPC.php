<?php
namespace Jcsofts\LaravelEthereum\Lib;
use GuzzleHttp\Client;

/**
 * Created by PhpStorm.
 * User: lee
 * Date: 11/12/2017
 * Time: 1:38 PM
 */


class JsonRPC
{
    protected $host, $port, $version;
    protected $id = 0;
    private $client;

    function __construct($host, $port, $version="2.0")
    {
        $this->host = $host;
        $this->port = $port;
        $this->version = $version;
        $this->client=new Client([
            'base_uri' => $this->host.":".$this->port
        ]);
    }

    function request($method, $params=array())
    {
        $data = array();
        $data['jsonrpc'] = $this->version;
        $data['id'] = $this->id++;
        $data['method'] = $method;
        $data['params'] = $params;

        try {
            $res = $this->client->request("POST",'', [
                'headers'  => ['content-type' => 'application/json'],
                'json' => $data
            ]);
            $formatted=json_decode($res->getBody()->getContents());

            //print_r($formatted);
            if(isset($formatted->error))
            {
                throw new RPCException($formatted->error->message, $formatted->error->code);
            }
            else
            {
                return $formatted;
            }
        } catch (ClientException $e) {
            throw $e;
        }
    }

    function format_response($response)
    {
        return @json_decode($response);
    }
}