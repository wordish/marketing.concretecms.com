<?php

namespace PortlandLabs\Concrete\Releases\Api\Client;

use PortlandLabs\Concrete\Releases\Api\Client\Resources\Account;
use PortlandLabs\Concrete\Releases\Api\Client\Resources\Pages;
use PortlandLabs\Concrete\Releases\Api\Client\Resources\Versions;

class Client
{

    /**
     * @var \GuzzleHttp\Client
     */
    protected $wrappedClient;

    public function __construct(array $config)
    {
        $this->wrappedClient = new \GuzzleHttp\Client($config);
    }

    public function __call($name, $arguments)
    {
        return $this->wrappedClient->$name(...$arguments);
    }

    public function account(): Account
    {
        return new Account($this);
    }

    public function pages(): Pages
    {
        return new Pages($this);
    }

    public function versions(): Versions
    {
        return new Versions($this);
    }

}