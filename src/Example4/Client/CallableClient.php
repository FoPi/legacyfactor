<?php
namespace Example4\Client;

/**
 * CallableClientInterface
 *
 * @author Fodor Péter
 * @since 2016.12.02. 14:49
 */
interface CallableClient
{
    public function call($functionName, $params);
}