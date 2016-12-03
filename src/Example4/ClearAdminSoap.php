<?php
namespace Example4;

use Example4\Client\CallableClient;
use Example4\Client\Soap;

/**
 * Created by PhpStorm.
 * User: gabornagy
 * Date: 2016. 12. 01.
 * Time: 10:56
 */
class ClearAdminSoap
{

    /** @var String */
    protected $url = 'http://soaptest.example.com/reseller.wsdl';

    /** @var array */
    protected $errors = array();

    /**
     * @var CallableClient
     */
    protected $client;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->client = $this->createClient();
    }

    /**
     * @param $value1
     * @param $value2
     *
     * @return mixed
     */
    public function addOssze($value1, $value2)
    {
        $params = [
            "values" => [
                "a" => (int) $value1,
                "b" => (int) $value2
            ]
        ];

        return $this->client->call("AddOssze", $params);
    }

    /**
     * @return Soap
     */
    protected function createClient()
    {
        return new Soap($this->url);
    }
}