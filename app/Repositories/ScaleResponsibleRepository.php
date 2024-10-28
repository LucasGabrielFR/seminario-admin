<?php

namespace App\Repositories;

use App\Models\ScaleResponsible;
use Illuminate\Http\Request;

class ScaleResponsibleRepository
{
    protected $entity;

    function __construct(ScaleResponsible $model)
    {
        $this->entity = $model;
    }

    public function createScaleResponsible($request)
    {
        $this->entity->create($request->all());
    }

    function getScaleResponsible($id)
    {
        return $this->entity->find($id);
    }

    public function getScaleResponsiblesByScale($id)
    {
        return $this->entity->where('scale_id', $id)->get();
    }

    function deleteScaleResponsible($id)
    {
        $scaleResponsible = $this->entity->find($id);
        $scaleResponsible->delete();
    }

    public function deleteScaleResponsiblesByScale($id)
    {
        $this->entity->where('scale_id', $id)->delete();
    }

    public function getScaleResponsiblesByScaleAndDay($id, $currentWeek, $day)
    {
        return $this->entity->where('scale_id', $id)->where('week', $currentWeek)->where('day', $day)->get();
    }

    public function getScaleResponsibleGroup($id)
    {
        $users = $this->entity->where('scale_id', $id)->get();
        return $users->unique('user_id')->values();
    }
}
