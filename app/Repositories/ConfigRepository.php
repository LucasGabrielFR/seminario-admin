<?php

namespace App\Repositories;

use App\Models\Config;
use Illuminate\Http\Request;

class ConfigRepository
{
    protected $entity;

    public function __construct(Config $model)
    {
        $this->entity = $model;
    }

    public function getSendTelegramMessageConfig()
    {
        return $this->entity->where('name', 'send_telegram_message')->first();
    }
}
