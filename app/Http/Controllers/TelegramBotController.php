<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Api;

class TelegramBotController extends Controller
{
    protected $telegram;

    public function __construct()
    {
        $this->telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
    }

    public function webhook(Request $request)
    {
        $update = $this->telegram->getWebhookUpdate();

        // Processar a mensagem recebida
        $chatId = $update->getMessage()->getChat()->getId();
        $text = $update->getMessage()->getText();

        // Responder com uma mensagem
        $this->telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => "Você disse: " . $text,
        ]);
    }

    public function sendMessage($chatId, $message)
    {
        $this->telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => $message,
        ]);
    }

    public function sendCustomMessage()
    {
        $chatId = '6803564176'; // Obtenha o chat_id do request
        $message = 'Olá Lucas'; // Obtenha a mensagem do request

        $this->sendMessage($chatId, $message);
    }
}
