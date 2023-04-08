<?php

namespace Tsyvkunov\YandexCloudTranslate;

use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use RuntimeException;

class Client
{
    public const URLS = [
        'token' => 'https://iam.api.cloud.yandex.net/iam/v1/tokens',
        'translate' => 'https://translate.api.cloud.yandex.net/translate/v2/',
    ];

    protected ?array $headers;

    protected ?string $folderId;

    public function setFolderId($folderId): static
    {
        $this->folderId = $folderId;
        return $this;
    }

    public function getFolderId(): ?string
    {
        return $this->folderId;
    }

    public function addHeader($key, $value): static
    {
        $this->headers[$key] = $value;
        return $this;
    }

    public function addAuthHeader($key, $value): static
    {
        $this->headers['Authorization'] = $key.' '.$value;
        return $this;
    }

    public function getHeaders(): ?array
    {
        return $this->headers;
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function getIAMToken($OAuthToken)
    {
        $data = $this->request(
            self::URLS['token'],
            '',
            [
                'yandexPassportOauthToken' => $OAuthToken,
            ]
        );

        return $data->iamToken;
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function request($url, $uri, array $params)
    {
        if(count($this->headers) < 1) {
            throw new RuntimeException('Empty headers');
        }

        if(!empty($this->folderId)) {
            $params['folder_id'] = $this->folderId;
        }

        $client = new GuzzleClient(['base_uri' => $url]);
        $response = $client->post($uri, [
            'headers' => $this->headers,
            'json' => $params
        ]);

        return json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
    }
}
