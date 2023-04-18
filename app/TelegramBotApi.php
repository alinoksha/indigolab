<?php

namespace Alinoksha\Indigolab;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class TelegramBotApi
{
    private const BASE_URL = 'https://api.telegram.org/bot';

    public function __construct(
        private readonly Client $client,
        private readonly Parameters $parameters
    ) {
    }

    public function sendMessage(int $chatId, string $message): void
    {
        $token = $this->parameters->get(Parameters::TELEGRAM_BOT_TOKEN);
        $this->client->post(self::BASE_URL . $token . '/sendMessage', [
            RequestOptions::JSON => [
                'chat_id' => $chatId,
                'text' => $message,
            ],
        ]);
    }
}
