<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Symfony\Contracts\HttpClient\HttpClientInterface;


#[Autoconfigure(tags: ['app.custom_service_tag'])]
class OmdbApiConsumer
{
    public function __construct(
        private HttpClientInterface $client,
    ) {
    }

    public function getByTitle(string $title): array
    {
        $response = $this->client->request(
            'GET',
            'http://www.omdbapi.com/?apikey=7b634d05&t='.$title,
        );
        $statusCode = $response->getStatusCode();
        return $response->toArray();
    }


}