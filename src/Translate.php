<?php

namespace Tsyvkunov\YandexCloudTranslate;

use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class Translate
{
    protected Client $client;

    public function __construct($token = null, $folderId = null)
    {
        $this->client = new Client();

        if (!empty($token)) {
            if (!empty($folderId)) {
                $IAMToken = $this->client->getIAMToken($token);
                $this->client->addAuthHeader('Bearer', $IAMToken);
                $this->client->setFolderId($folderId);
            } else {
                $this->client->addAuthHeader('Bearer', $token);
            }
        }
    }

    public function makeApi($apiKey): static
    {
        $this->client->addAuthHeader('Api-Key', $apiKey);
        return $this;
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function translate($texts, $targetLanguage = 'ru', $sourceLanguage = null)
    {
        $data = [
            'targetLanguageCode' => $targetLanguage,
            'texts' => $texts
        ];

        if(!empty($sourceLanguage)) {
            $data['sourceLanguageCode'] = $sourceLanguage;
        }

        return $this->client->request(
            Client::URLS['translate'],
            'translate',
            $data
        );
    }


}
