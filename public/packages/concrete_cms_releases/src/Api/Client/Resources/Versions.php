<?php

namespace PortlandLabs\Concrete\Releases\Api\Client\Resources;

class Versions extends AbstractResource
{

    public function update($pageID, $pageVersionId, array $requestBody): array
    {
        $endpoint = '/ccm/api/1.0/page_versions/' . $pageID . '/' . $pageVersionId;
        return json_decode(
            $this->client->put($endpoint, ['body' => json_encode($requestBody)])->getBody()->getContents(),
            true
        )['data'];
    }

}