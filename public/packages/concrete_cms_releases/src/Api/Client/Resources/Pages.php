<?php

namespace PortlandLabs\Concrete\Releases\Api\Client\Resources;

class Pages extends AbstractResource
{

    public function add(array $requestBody): array
    {
        return json_decode(
            $this->client->post('/ccm/api/1.0/pages', ['body' => json_encode($requestBody)])->getBody()->getContents(),
            true
        )['data'];
    }

    public function addBlock($pageID, string $areaHandle, array $requestBody): array
    {
        $endpoint = '/ccm/api/1.0/pages/' . $pageID . '/' . urlencode($areaHandle);
        return json_decode(
            $this->client->post($endpoint, ['body' => json_encode($requestBody)])->getBody()->getContents(),
            true
        )['data'];
    }




}