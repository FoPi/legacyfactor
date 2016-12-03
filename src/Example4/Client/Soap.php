<?php
namespace Example4\Client;

/**
 * Soap
 *
 * @author Fodor Péter
 * @since 2016.12.02. 14:51
 */
class Soap implements CallableClient
{
    /**
     * @var \SoapClient
     */
    protected $client;

    public function __construct($soapUrl)
    {
        $this->client = $this->createClient($soapUrl);
    }

    /**
     * @param $functionName
     * @param $params
     *
     * @return mixed
     */
    public function call($functionName, $params)
    {
        return $this->client->__soapCall($functionName, $params);
    }

    /**
     * @param $url
     *
     * @return \SoapClient
     */
    private function createClient($url)
    {
        return new \SoapClient(
            $url,
            array(
                'encoding' => 'UTF-8'
            )
        );
    }

}