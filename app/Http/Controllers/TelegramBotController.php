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

        if ($update->isType('command')) {
            $command = $update->getCommand();

            switch ($command) {
                case '/ajuda':
                    $this->sendMessage($update->getMessage()->getChat()->getId(), 'Aqui estão os comandos disponíveis: /ajuda, /propedeutico, /discipulado');
                    break;
                default:
                    $this->sendMessage($update->getMessage()->getChat()->getId(), 'Nenhuma opção encontrada.');
                    break;
            }
        }

        if ($update->isType('message')) {
            // Processar a mensagem recebida
            $chatId = $update->getMessage()->getChat()->getId();
            $text = $update->getMessage()->getText();

            // Responder com uma mensagem
            $this->telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => "Você disse: " . $text,
            ]);
        }
    }

    public function sendMessage($chatId, $message)
    {
        $this->telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => $message,
        ]);
    }

    public function sendCustomMessage(Request $request)
    {
        $chatId = $request->input('chat_id'); // Obtenha o chat_id do request
        $message = $request->input('message'); // Obtenha a mensagem do request

        $this->sendMessage($chatId, $message);
    }

    public function setWebhook()
    {
        $webhookUrl = env('APP_URL') . '/telegram/webhook'; // Defina a URL do seu webhook

        $response = $this->telegram->setWebhook(['url' => $webhookUrl]);

        return response()->json($response);
    }
}
