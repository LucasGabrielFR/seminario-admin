<?php

namespace App\Http\Controllers;

use App\Models\Phrase;
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
        $text = $update->getMessage()->getText();

        $randomPhrase = Phrase::inRandomOrder()->first();

        switch ($text) {
            case '/ajuda':
                $this->sendMessage($update->getMessage()->getChat()->getId(), 'Aqui estão os comandos disponíveis: /ajuda, /propedeutico, /discipulado');
                break;
            default:
                $chatId = $update->getMessage()->getChat()->getId();
                $userName = $update->getMessage()->getFrom()->getFirstName() . ' ' . $update->getMessage()->getFrom()->getLastName();

                // Responder com uma mensagem formatada
                $message = "Olá *$userName*, eu sou o bot do Seminário São José. Irei repassar as informações necessárias para o Lucas, Obrigado!!.\n\n";
                $message .= '"' . $randomPhrase->phrase . '"' . "\n\n" . $randomPhrase->author; // Usando Markdown para destacar o ChatID

                $this->telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text' => $message,
                    'parse_mode' => 'Markdown', // Definindo o modo de parse para Markdown
                ]);

                $adminMessage = "Ola *$userName*, eu sou o bot do Seminário São José. Seguem as informações do usuário *$userName*:\n\n";
                $adminMessage .= "ChatID: `{$chatId}`"; // Usando Markdown para destacar o ChatID
                $this->telegram->sendMessage([
                    'chat_id' => '6803564176',
                    'text' => $adminMessage,
                    'parse_mode' => 'Markdown', // Definindo o modo de parse para Markdown
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
