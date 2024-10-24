<?php

namespace App\Http\Controllers;

use App\Models\Log;
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

    public function sendScaleResponseMorning($scaleId)
    {
        // Obtém o dia da semana (0 = domingo,1 = segunda, ...,6 = sábado)
        $dayOfWeek = date('w'); // 'w' retorna o índice do dia da semana // Exibe a data atual e o dia da semana dd([

        $scaleReponseRepository = new ScaleResponsibleRepository(new ScaleResponsible());
        $scaleRepository = new ScaleRepository(new Scale());

        $scale = $scaleRepository->getScale($scaleId);
        $scaleResponsibles = $scaleReponseRepository->getScaleResponsiblesByScaleAndDay($scaleId, $scale->current_week, $dayOfWeek);

        foreach ($scaleResponsibles as $scaleResponsible) {
            if (isset($scaleResponsible->user->chat_id)) {
                $name = $scaleResponsible->user->name;
                $function = $scaleResponsible->function->name;
                $message = "Acorda logo meu filho, o sino já bateu, hoje para sua alegria, vossa senhoria *$name*, será responsável pela função de: \n\n !!!!*$function*!!!! \n\n Tenha um bom dia(Se puder)!";

                $this->telegram->sendMessage([
                    'chat_id' => $scaleResponsible->user->chat_id,
                    'text' => $message,
                    'parse_mode' => 'Markdown', // Definindo o modo de parse para Markdown
                ]);

                Log::create([
                    'description' => "Resposta enviada para: $name. Mensagem: $message",
                    'action' => 'Mensagem Telegram enviada',
                ]);
            }
        };
    }

    public function sendScaleResponseNight($scaleId)
    {
        // Obtém o dia da semana (0 = domingo,1 = segunda, ...,6 = sábado)
        $dayOfWeek = date('w'); // 'w' retorna o índice do dia da semana // Exibe a data atual e o dia da semana dd([

        $scaleReponseRepository = new ScaleResponsibleRepository(new ScaleResponsible());
        $scaleRepository = new ScaleRepository(new Scale());

        $scale = $scaleRepository->getScale($scaleId);
        $scaleResponsibles = $scaleReponseRepository->getScaleResponsiblesByScaleAndDay($scaleId, $scale->current_week, $dayOfWeek + 1);

        foreach ($scaleResponsibles as $scaleResponsible) {
            if (isset($scaleResponsible->user->chat_id)) {
                $name = $scaleResponsible->user->name;
                $function = $scaleResponsible->function->name;
                $message = "Boa noite caro *$name*, no dia de amanhã você será responsável pela função de: \n\n !!!!*$function*!!!! \n\n Boa noite! Espero que seus sonhos sejam tão bons quanto sua vida de oração!";

                $this->telegram->sendMessage([
                    'chat_id' => $scaleResponsible->user->chat_id,
                    'text' => $message,
                    'parse_mode' => 'Markdown', // Definindo o modo de parse para Markdown
                ]);

                Log::create([
                    'description' => "Resposta enviada para: $name. Mensagem: $message",
                    'action' => 'Mensagem Telegram enviada',
                ]);
            }
        };
    }

    public function sendReaderMessage($scaleId)
    {
        $dayOfWeek = date('w'); // 'w' retorna o índice do dia da semana // Exibe a data atual e o dia da semana dd([

        $scaleReponseRepository = new ScaleResponsibleRepository(new ScaleResponsible());
        $scaleRepository = new ScaleRepository(new Scale());

        $scale = $scaleRepository->getScale($scaleId);
        $scaleResponsibles = $scaleReponseRepository->getScaleResponsiblesByScaleAndDay($scaleId, $scale->current_week, $dayOfWeek);

        foreach ($scaleResponsibles as $scaleResponsible) {
            if ($scaleResponsible->function->id == '9c78b7c3-bfe0-4dd8-8cd0-13fa3773c1d1' && isset($scaleResponsible->user->chat_id)) {
                $message = "Se for a semana de copa da sua turma pode correr pra ligar a estufa se não vai todo mundo comer boia fria. \n\n Anda Logo meu filho!!!!";

                $this->telegram->sendMessage([
                    'chat_id' => $scaleResponsible->user->chat_id,
                    'text' => $message,
                    'parse_mode' => 'Markdown', // Definindo o modo de parse para Markdown
                ]);

                Log::create([
                    'description' => "Resposta enviada para: " . $scaleResponsible->user->name . "Mensagem: $message",
                    'action' => 'Mensagem Telegram enviada',
                ]);
            }
        };
    }

    public function updateCurrentWeek()
    {
        $scaleRepository = new ScaleRepository(new Scale());
        $scales = $scaleRepository->getAllScales();
        foreach ($scales as $scale) {
            $weeks = $scale->weeks;
            $currentWeek = $scale->current_week;
            if ($currentWeek == $weeks) {
                $scale->current_week = 1;
                $scale->save();
            } else {
                $scale->current_week = $scale->current_week + 1;
                $scale->save();
            }
        }
    }
}
