<?php

namespace PortlandLabs\Concrete\Releases\Api\Client\Resources;

class Account extends AbstractResource
{

    public function read(): array
    {
        return json_decode(
            $this->client->request('GET', '/ccm/api/1.0/account')->getBody()->getContents(),
            true
        )['data'];
    }



}