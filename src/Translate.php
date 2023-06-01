<?php

namespace Tsyvkunov\YandexCloudTranslate;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use RuntimeException;

class Translate
{
    protected Client $client;

    public string $format = 'PLAIN_TEXT';

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

    public function setHtmlFormat(): static
    {
        $this->format = 'HTML';
        return $this;
    }

    public function setPlaintTextFormat(): static
    {
        $this->format = 'PLAIN_TEXT';
        return $this;
    }

    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function translate($text, $targetLanguage = 'ru', $sourceLanguage = null)
    {
        $data = [
            'targetLanguageCode' => $targetLanguage,
            'texts' => [$text],
            'format' => $this->format
        ];

        if(!empty($sourceLanguage)) {
            $data['sourceLanguageCode'] = $sourceLanguage;
        }

        try {
            $response = $this->client->request(
                Client::URLS['translate'],
                'translate',
                $data
            );
        }catch (Exception $exception) {
            \Log::info('YandexException', [$exception->getMessage(), $exception]);
            throw new RuntimeException($exception);
        }

        return $response;
    }


}
