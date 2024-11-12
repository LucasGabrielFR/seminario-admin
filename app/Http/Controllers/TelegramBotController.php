<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Log;
use App\Models\Phrase;
use App\Models\Scale;
use App\Models\ScaleResponsible;
use App\Repositories\LoanRepository;
use App\Repositories\ScaleRepository;
use App\Repositories\ScaleResponsibleRepository;
use Illuminate\Http\Request;
use Telegram\Bot\Api;

class TelegramBotController extends Controller
{
    protected $telegram;
    protected $scaleRepository;
    protected $scaleResponsibleRepository;

    public function __construct()
    {
        $this->telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $this->scaleRepository = new ScaleRepository(new Scale());
        $this->scaleResponsibleRepository = new ScaleResponsibleRepository(new ScaleResponsible());
    }

    public function webhook(Request $request)
    {
        $update = $this->telegram->getWebhookUpdate();
        $text = $update->getMessage()->getText();
        $chatId = $update->getMessage()->getChat()->getId();
        $userName = $this->getUserName($update);

        $randomPhrase = Phrase::inRandomOrder()->first();
        $message = '';

        switch ($text) {
            case '/ajuda':
                $message = $this->helpMessage();
                break;

            case '/propedeutico':
                return $this->sendScale('92319507-326b-4675-8422-323a15ee8341', 'Propedeutico', $chatId);

            case '/discipulado':
                return $this->sendScale('916fddb3-8d04-4317-baec-45f167abf4ed', 'Discipulado', $chatId);

            case '/cadastro':
                $message = $this->registrationMessage($userName, $randomPhrase, $chatId);
                break;

            case '/frases':
                $message = '"' . $randomPhrase->phrase . '"' . "\n\n" . $randomPhrase->author;
                break;

            default:
                $message = $this->defaultMessage($userName, $randomPhrase);
        }

        $this->sendMessage($chatId, $message);
    }

    private function getUserName($update)
    {
        return $update->getMessage()->getFrom()->getFirstName() . ' ' . $update->getMessage()->getFrom()->getLastName();
    }

    private function helpMessage()
    {
        return 'Aqui estão os comandos disponíveis: /ajuda, /propedeutico, /discipulado, /cadastro, /frases';
    }

    private function registrationMessage($userName, $randomPhrase, $chatId)
    {
        $message = "Ola *$userName*. Seus dados serão enviados ao adminstrador. Obrigado!!\n\n";
        $message .= '"' . $randomPhrase->phrase . '"' . "\n\n" . $randomPhrase->author;

        // Sending to admin
        $this->sendMessage('6803564176', "Ola Lucas. Seguem as informações do usuário *$userName*:\n\nChatID: `{$chatId}`");

        return $message;
    }

    private function defaultMessage($userName, $randomPhrase)
    {
        return "Olá *$userName*, eu sou o bot do Seminário São José. Estou aqui para te auxiliar.\n\n" .
               "Caso seja sua primeira vez por aqui, use o comando /cadastro para que o adminstrador te adicione no sistema de mensagens automáticas.\n\n" .
               "Caso queira saber mais sobre o bot, use o comando /ajuda.\n\n" .
               '"' . $randomPhrase->phrase . '"' . "\n\n" . $randomPhrase->author;
    }

    public function sendMessage($chatId, $message)
    {
        $this->telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'Markdown',
        ]);
    }

    public function setWebhook()
    {
        $webhookUrl = env('APP_URL') . '/telegram/webhook';
        return response()->json($this->telegram->setWebhook(['url' => $webhookUrl]));
    }

    public function sendScaleResponseMorning()
    {
        $this->sendScaleResponse('morning');
    }

    public function sendScaleResponseNight()
    {
        $this->sendScaleResponse('night');
    }

    private function sendScaleResponse($type)
    {
        $dayOfWeek = date('w');
        $scales = $this->scaleRepository->getActiveScales();

        foreach ($scales as $scale) {
            $shiftDay = ($type === 'morning') ? $dayOfWeek : $dayOfWeek + 1;
            $this->notifyResponsible($scale, $shiftDay);
        }
    }

    private function notifyResponsible($scale, $shiftDay)
    {
        $scaleResponsibles = $this->scaleResponsibleRepository->getScaleResponsiblesByScaleAndDay($scale->id, $scale->current_week, $shiftDay);
        $randomPhrase = Phrase::inRandomOrder()->first();

        foreach ($scaleResponsibles as $scaleResponsible) {
            if (isset($scaleResponsible->user->chat_id)) {
                $name = $scaleResponsible->user->name;
                $function = $scaleResponsible->function->name;

                $message = $this->generateResponsibilityMessage($name, $function, $randomPhrase, $shiftDay);

                $this->telegram->sendMessage([
                    'chat_id' => $scaleResponsible->user->chat_id,
                    'text' => $message,
                    'parse_mode' => 'Markdown',
                ]);

                $this->logMessage($name, $function, $shiftDay);
            }
        }
    }

    private function generateResponsibilityMessage($name, $function, $randomPhrase, $shiftDay)
    {
        $greeting = ($shiftDay == date('w')) ? "Acorda logo meu filho, o sino já bateu" : "Boa noite caro";

        return "$greeting, hoje para sua alegria, vossa senhoria *$name*, será responsável pela função de: \n\n !!!!*$function*!!!! \n\n" .
               '"' . $randomPhrase->phrase . '"' . "\n\n" . $randomPhrase->author;
    }

    private function logMessage($name, $function, $shiftDay)
    {
        $timeOfDay = ($shiftDay == date('w')) ? "Mensagem da Manhã" : "Mensagem da Noite";
        Log::create([
            'description' => "Função do dia enviada para: $name. $timeOfDay. Funcão: $function.",
            'action' => 'Mensagem Telegram enviada',
        ]);
    }

    public function sendLateLoansMessage()
    {
        $loansRepository = new LoanRepository(new Loan());
        $loans = $loansRepository->getLateLoans();

        foreach ($loans as $loan) {
            $this->notifyUserOfLateLoan($loan);
        }
    }

    private function notifyUserOfLateLoan($loan)
    {
        $user = $loan->user;
        $name = $user->name;
        $book = $loan->book;
        $dateLimit = date('d/m/Y', strtotime($loan->date_limit));

        $message = "Caríssimo $name, você tem um empréstimo atrasado desde o dia $dateLimit !! Não seja um caloteiro, devolva o livro:  \n\n $book->name";

        if (isset($user->chat_id)) {
            $this->sendMessage($user->chat_id, $message);

            Log::create([
                'description' => "Empréstimo atrasado: $name. Livro: $book->name. Data limite: $dateLimit.",
                'action' => 'Mensagem Telegram enviada',
            ]);
        }
    }

    private function sendScale($scaleId, $scaleName, $chatId)
    {
        $dayOfWeek = date('w');
        $scale = $this->scaleRepository->getScale($scaleId);
        $scaleResponsibles = $this->scaleResponsibleRepository->getScaleResponsiblesByScaleAndDay($scaleId, $scale->current_week, $dayOfWeek);

        $message = "Olá, segue a escala da turma *$scaleName*: \n\n";
        foreach ($scaleResponsibles as $scaleResponsible) {
            if (isset($scaleResponsible->user)) {
                $message .= "*{$scaleResponsible->user->name}* - {$scaleResponsible->function->name} \n";
            }
        }

        $this->sendMessage($chatId, $message);
    }
}
