<?php

namespace src\Translate;

class IbmHttp implements HttpInterface
{
    /**
     * @var string $apiUri contains uri for query.
     */
    protected $apiUri;

    /**
     * @var string $apiKey contain key for basic auth.
     */
    protected $apiKey;

    function __construct($apiUri, $apiKey) {
        $this->apiUri = $apiUri;
        $this->apiKey = $apiKey;
    }

    /**
     *
     * @param array $postData example
     * [
     *    'text' => ['Почта или телефон', 'Пароль'],
     *    'model_id' => 'ru-en'
     * ]
     */
    public function request(array $postData)
    {
        $baseUri = $this->apiUri;
        $apiKey = $this->apiKey;
        $client = new \GuzzleHttp\Client([
            'base_uri' => $baseUri
        ]);
        $response = $client->request(
            'POST',
            'translate?version=2018-05-01',
            [
                'auth' => [
                    'apikey',
                    $apiKey,
                ],
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => $postData,
            ]
        );

        $body = $response->getBody()->getContents();

        return $body;
    }
}
