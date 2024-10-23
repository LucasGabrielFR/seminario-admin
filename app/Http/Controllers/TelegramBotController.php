<?php

namespace App\Http\Controllers;

use App\Models\Phrase;
use App\Models\Scale;
use App\Models\ScaleResponsible;
use App\Repositories\ScaleRepository;
use App\Repositories\ScaleResponsibleRepository;
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

                $adminMessage = "Ola Lucas. Seguem as informações do usuário *$userName*:\n\n";
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

    public function sendScaleResponse($scaleId)
    {
        // Obtém o dia da semana (0 = domingo,1 = segunda, ...,6 = sábado)
        $dayOfWeek = date('w'); // 'w' retorna o índice do dia da semana // Exibe a data atual e o dia da semana dd([

        $scaleReponseRepository = new ScaleResponsibleRepository(new ScaleResponsible());
        $scaleRepository = new ScaleRepository(new Scale());

        $scale = $scaleRepository->getScale($scaleId);
        $scaleResponsibles = $scaleReponseRepository->getScaleResponsiblesByScaleAndDay($scaleId, $scale->current_week, $dayOfWeek);
        dd($scaleResponsibles);
    }
}
