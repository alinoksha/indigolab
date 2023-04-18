<?php

namespace Alinoksha\Indigolab\Actions;

use Alinoksha\Indigolab\Parameters;
use Alinoksha\Indigolab\Repositories\UserRepository;
use Alinoksha\Indigolab\Services\AuthManager;
use Alinoksha\Indigolab\TelegramBotApi;

class HookAction
{
    public function __construct(
        private readonly Parameters $parameters,
        private readonly TelegramBotApi $telegramBotApi,
        private readonly UserRepository $userRepository,
        private readonly AuthManager $authManager
    ) {
    }

    public function handle(): void
    {
        $secret = $_GET['secret'] ?? null;
        if ($secret !== $this->parameters->get(Parameters::HOOK_SECRET)) {
            exit();
        }

        $rawInput = file_get_contents('php://input');
        if (empty($rawInput)) {
            exit();
        }

        $json = json_decode($rawInput, true);
        if (!is_array($json)) {
            exit();
        }

        $chatId = $json['message']['chat']['id'];
        if ($json['message']['text'] === '/start') {
            $this->telegramBotApi->sendMessage($chatId, '/auth Чтобы получить ссылку для авторизации');
            exit();
        } elseif ($json['message']['text'] !== '/auth') {
            exit();
        }

        $from = $json['message']['from'];

        $user = $this->userRepository->findByTelegramId($from['id']);
        if ($user === null) {
            $user = $this->userRepository->createFromTelegramData($from);
        }

        $this->telegramBotApi->sendMessage($chatId, sprintf(
            '%s://%s/auth.php?hash=%s',
            $_SERVER['REQUEST_SCHEME'],
            $_SERVER['HTTP_HOST'],
            $this->authManager->generate($user->id)
        ));
    }
}
