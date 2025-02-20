<?php

namespace App\Http\Controllers;

use App\Models\Config as ModelsConfig;
use App\Models\Loan;
use App\Models\Log;
use App\Models\Phrase;
use App\Models\Scale;
use App\Models\ScaleResponsible;
use App\Models\User;
use App\Repositories\ConfigRepository;
use App\Repositories\LoanRepository;
use App\Repositories\ScaleRepository;
use App\Repositories\ScaleResponsibleRepository;
use Illuminate\Http\Request;
use PSpell\Config;
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
        $chatId = $update->getMessage()->getChat()->getId();

        switch ($text) {
            case '/ajuda':
                $this->sendMessage($update->getMessage()->getChat()->getId(), 'Aqui estão os comandos disponíveis: /ajuda, /propedeutico, /discipulado, /cadastro, /frases');
                break;
            case '/propedeutico':
                // $this->sendScale('92319507-326b-4675-8422-323a15ee8341', 'Propedeutico', $chatId);
                break;
            case '/discipulado':
                $this->sendScale('c3fdcda2-b9d6-49b9-87d4-ecbb120019a1', 'Discipulado', $chatId);
                break;
            case '/cadastro':
                $userName = $update->getMessage()->getFrom()->getFirstName() . ' ' . $update->getMessage()->getFrom()->getLastName();

                $message = "Ola *$userName*. Seus dados serão enviados ao adminstrador. Obrigado!!\n\n";
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
                break;
            case '/frases':
                $this->sendMessage($update->getMessage()->getChat()->getId(), '"' . $randomPhrase->phrase . '"' . "\n\n" . $randomPhrase->author);
                break;
            default:
                $userName = $update->getMessage()->getFrom()->getFirstName() . ' ' . $update->getMessage()->getFrom()->getLastName();

                // Responder com uma mensagem formatada
                $message = "Olá *$userName*, eu sou o bot do Seminário São José. Estou aqui para te auxiliar.\n\n";
                $message .= "Caso seja sua primeira vez por aqui, use o comando /cadastro para que o adminstrador te adicione no sistema de mensagens automáticas.\n\n";
                $message .= "Caso queira saber mais sobre o bot, use o comando /ajuda.\n\n";
                $message .= '"' . $randomPhrase->phrase . '"' . "\n\n" . $randomPhrase->author; // Usando Markdown para destacar o ChatID

                $this->telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text' => $message,
                    'parse_mode' => 'Markdown', // Definindo o modo de parse para Markdown
                ]);
        }
    }

    public function sendMessage($chatId, $message)
    {
        $configRepo = new ConfigRepository(new ModelsConfig());
        $sendTelegramMessageConfig = $configRepo->getSendTelegramMessageConfig();

        if ($sendTelegramMessageConfig->value == 1) {
            $this->telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => $message,
            ]);
        }
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

    public function sendScaleResponseMorning()
    {
        // Obtém o dia da semana (0 = domingo,1 = segunda, ...,6 = sábado)
        $dayOfWeek = date('w'); // 'w' retorna o índice do dia da semana // Exibe a data atual e o dia da semana dd([

        $scaleReponseRepository = new ScaleResponsibleRepository(new ScaleResponsible());
        $scaleRepository = new ScaleRepository(new Scale());

        $scales = $scaleRepository->getActiveScales();

        foreach ($scales as $scale) {
            $scaleResponsibles = $scaleReponseRepository->getScaleResponsiblesByScaleAndDay($scale->id, $scale->current_week, $dayOfWeek);

            $randomPhrase = Phrase::inRandomOrder()->first();

            foreach ($scaleResponsibles as $scaleResponsible) {
                if (isset($scaleResponsible->user->chat_id)) {
                    $name = $scaleResponsible->user->name;
                    $function = $scaleResponsible->function->name;
                    $message = "Acorda logo meu filho, o sino já bateu, hoje para sua alegria, vossa senhoria *$name*, será responsável pela função de: \n\n !!!!*$function*!!!! \n\n";
                    $message .= '"' . $randomPhrase->phrase . '"' . "\n\n" . $randomPhrase->author;

                    $this->telegram->sendMessage([
                        'chat_id' => $scaleResponsible->user->chat_id,
                        'text' => $message,
                        'parse_mode' => 'Markdown', // Definindo o modo de parse para Markdown
                    ]);

                    Log::create([
                        'description' => "Função do dia enviada para: $name. Mensagem da Manhã. Funcão: $function.",
                        'action' => 'Mensagem Telegram enviada',
                    ]);
                }
            };
        }
    }

    public function sendScaleResponseNight()
    {
        // Obtém o dia da semana (0 = domingo,1 = segunda, ...,6 = sábado)
        $dayOfWeek = date('w'); // 'w' retorna o índice do dia da semana // Exibe a data atual e o dia da semana dd([

        $scaleReponseRepository = new ScaleResponsibleRepository(new ScaleResponsible());
        $scaleRepository = new ScaleRepository(new Scale());

        $scales = $scaleRepository->getActiveScales();

        foreach ($scales as $scale) {
            $scaleResponsibles = $scaleReponseRepository->getScaleResponsiblesByScaleAndDay($scale->id, $scale->current_week, $dayOfWeek + 1);

            $randomPhrase = Phrase::inRandomOrder()->first();

            foreach ($scaleResponsibles as $scaleResponsible) {
                if (isset($scaleResponsible->user->chat_id)) {
                    $name = $scaleResponsible->user->name;
                    $function = $scaleResponsible->function->name;
                    $message = "Boa noite caro *$name*, no dia de amanhã você será responsável pela função de: \n\n !!!!*$function*!!!! \n\n ";
                    $message .= '"' . $randomPhrase->phrase . '"' . "\n\n" . $randomPhrase->author; // Usando Markdown para destacar o ChatID

                    $this->telegram->sendMessage([
                        'chat_id' => $scaleResponsible->user->chat_id,
                        'text' => $message,
                        'parse_mode' => 'Markdown', // Definindo o modo de parse para Markdown
                    ]);

                    Log::create([
                        'description' => "Função do dia seguinte enviada para: $name. Mensagem da Noite. Funcão: $function.",
                        'action' => 'Mensagem Telegram enviada',
                    ]);
                }
            };
        }
    }

    public function sendReaderMessage()
    {
        $dayOfWeek = date('w'); // 'w' retorna o índice do dia da semana // Exibe a data atual e o dia da semana dd([

        $scaleReponseRepository = new ScaleResponsibleRepository(new ScaleResponsible());
        $scaleRepository = new ScaleRepository(new Scale());

        $scales = $scaleRepository->getActiveScales();

        foreach ($scales as $scale) {
            $scaleResponsibles = $scaleReponseRepository->getScaleResponsiblesByScaleAndDay($scale->id, $scale->current_week, $dayOfWeek);

            foreach ($scaleResponsibles as $scaleResponsible) {
                if ($scaleResponsible->function->id == '9c78b7c3-bfe0-4dd8-8cd0-13fa3773c1d1' && isset($scaleResponsible->user->chat_id)) {
                    $message = "Se for a semana de copa da sua turma pode correr pra ligar a estufa se não vai todo mundo comer boia fria. \n\n Anda Logo meu filho!!!!";

                    $this->telegram->sendMessage([
                        'chat_id' => $scaleResponsible->user->chat_id,
                        'text' => $message,
                        'parse_mode' => 'Markdown', // Definindo o modo de parse para Markdown
                    ]);

                    $name = $scaleResponsible->user->name;

                    Log::create([
                        'description' => "Mensagem de lembrete para: $name. Mensagem da estufa",
                        'action' => 'Mensagem Telegram enviada',
                    ]);
                }
            };
        }
    }

    public function updateCurrentWeek()
    {
        $dayOfWeek = date('w');

        if ($dayOfWeek == 0) {
            $scaleRepository = new ScaleRepository(new Scale());
            $scales = $scaleRepository->getActiveScales();
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

    public function sendLateLoansMessage()
    {
        $configRepo = new ConfigRepository(new ModelsConfig());
        $sendTelegramMessageConfig = $configRepo->getSendTelegramMessageConfig();

        if ($sendTelegramMessageConfig->value == 1) {
            $loansRepository = new LoanRepository(new Loan());

            $loans = $loansRepository->getLateLoans();

            foreach ($loans as $loan) {
                $user = $loan->user;
                $name = $user->name;
                $book = $loan->book;
                $title = $book->name;
                $dateLimit = $loan->date_limit;
                $dateLimit = date('d/m/Y', strtotime($dateLimit));
                $message = "Caríssimo $name, você tem um empréstimo atrasado desde o dia $dateLimit !! Não seja um caloteiro, devolva o livro:  \n\n $title";

                if (isset($user->chat_id)) {
                    $this->telegram->sendMessage([
                        'chat_id' => $user->chat_id,
                        'text' => $message,
                        'parse_mode' => 'Markdown', // Definindo o modo de parse para Markdown
                    ]);

                    Log::create([
                        'description' => "Empréstimo atrasado: $name. Livro: $title. Data limite: $dateLimit.",
                        'action' => 'Mensagem Telegram enviada',
                    ]);
                }
            }
        }
    }

    public function sendAllFunctionsNightMessage()
    {
        $dayOfWeek = date('w'); // 'w' retorna o índice do dia da semana // Exibe a data atual e o dia da semana dd([

        $scaleReponseRepository = new ScaleResponsibleRepository(new ScaleResponsible());
        $scaleRepository = new ScaleRepository(new Scale());

        $scales = $scaleRepository->getActiveScales();

        foreach ($scales as $scale) {
            $scaleResponsibles = $scaleReponseRepository->getScaleResponsiblesByScaleAndDay($scale->id, $scale->current_week, $dayOfWeek + 1);

            $randomPhrase = Phrase::inRandomOrder()->first();

            $group = $scaleReponseRepository->getScaleResponsibleGroup($scale->id);

            $message = "";
            $message .= "Boa noite Zé Perequete, segue a escala geral de amanhã: \n\n";
            foreach ($scaleResponsibles as $scaleResponsible) {
                if (isset($scaleResponsible->user)) {
                    $name = $scaleResponsible->user->name;
                    $function = $scaleResponsible->function->name;

                    $message .= "*$name* - $function \n";
                }
            };

            $message .= "\n\n" . $randomPhrase->phrase . "\n\n" . $randomPhrase->author;

            try {
                foreach ($group as $member) {
                    if (isset($member->user->chat_id)) {
                        $name = $member->user->name;
                        $this->telegram->sendMessage([
                            'chat_id' => $member->user->chat_id,
                            'text' => $message,
                            'parse_mode' => 'Markdown', // Definindo o modo de parse para Markdown
                        ]);

                        Log::create([
                            'description' => "Escala geral enviada para: $name. Mensagem da Noite.",
                            'action' => 'Mensagem Telegram enviada',
                        ]);
                    }
                }
            } catch (\Exception $e) {
                Log::create([
                    'description' => "Escala geral enviada para: $name. Mensagem da Noite. Erro: $e",
                    'action' => 'Falha ao Enviar Mensagem',
                ]);
            }
        }
    }

    public function sendAllFunctionsMorningMessage()
    {
        $dayOfWeek = date('w'); // 'w' retorna o índice do dia da semana // Exibe a data atual e o dia da semana dd([

        $scaleReponseRepository = new ScaleResponsibleRepository(new ScaleResponsible());
        $scaleRepository = new ScaleRepository(new Scale());

        $scales = $scaleRepository->getActiveScales();

        foreach ($scales as $scale) {
            $scaleResponsibles = $scaleReponseRepository->getScaleResponsiblesByScaleAndDay($scale->id, $scale->current_week, $dayOfWeek);

            $group = $scaleReponseRepository->getScaleResponsibleGroup($scale->id);

            $randomPhrase = Phrase::inRandomOrder()->first();

            $message = "";
            $message .= "Bom dia projeto de padre, segue a escala geral de hoje: \n\n";
            foreach ($scaleResponsibles as $scaleResponsible) {
                if (isset($scaleResponsible->user)) {
                    $name = $scaleResponsible->user->name;
                    $function = $scaleResponsible->function->name;

                    $message .= "*$name* - $function \n";
                }
            };

            $message .= "\n\n" . $randomPhrase->phrase . "\n\n" . $randomPhrase->author;

            try {
                foreach ($group as $member) {
                    if (isset($member->user->chat_id) && isset($member->user->name)) {

                        $name = $member->user->name;
                        $this->telegram->sendMessage([
                            'chat_id' => $member->user->chat_id,
                            'text' => $message,
                            'parse_mode' => 'Markdown', // Definindo o modo de parse para Markdown
                        ]);

                        Log::create([
                            'description' => "Escala geral enviada para: $name. Mensagem da Manhã.",
                            'action' => 'Mensagem Telegram enviada',
                        ]);
                    }
                }
            } catch (\Exception $e) {
                Log::create([
                    'description' => "Escala geral enviada para: $name. Mensagem da Manhã. Erro: $e",
                    'action' => 'Falha ao Enviar Mensagem',
                ]);
            }
        }
    }

    private function sendScale($scaleId, $scaleName, $chatId)
    {
        $dayOfWeek = date('w'); // 'w' retorna o índice do dia da semana // Exibe a data atual e o dia da semana dd([

        $scaleReponseRepository = new ScaleResponsibleRepository(new ScaleResponsible());
        $scaleRepository = new ScaleRepository(new Scale());

        $scale = $scaleRepository->getScale($scaleId);
        $scaleResponsibles = $scaleReponseRepository->getScaleResponsiblesByScaleAndDay($scaleId, $scale->current_week, $dayOfWeek);

        $message = "";
        $message .= "Olá, segue a escala da turma *$scaleName*: \n\n";
        foreach ($scaleResponsibles as $scaleResponsible) {
            if (isset($scaleResponsible->user)) {
                $name = $scaleResponsible->user->name;
                $function = $scaleResponsible->function->name;

                $message .= "*$name* - $function \n";
            }
        };

        $this->telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'Markdown', // Definindo o modo de parse para Markdown
        ]);
    }
}
