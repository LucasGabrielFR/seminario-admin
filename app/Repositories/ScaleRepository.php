<?php

namespace App\Repositories;

use App\Models\Scale;
use Illuminate\Http\Request;

class ScaleRepository
{
    protected $entity;

    function __construct(Scale $model)
    {
        $this->entity = $model;
    }

    public function getAllScales()
    {
        return $this->entity->get();
    }

    public function createScale(Scale $scale)
    {
        $scale->save();
    }

    function getScale($id)
    {
        return $this->entity->find($id);
    }

    function getActiveScales()
    {
        return $this->entity->where('status', 1)->get();
    }

    function updateScale(Request $request, $id)
    {
        $scale = $this->entity->find($id);
        $scale->update($request->all());
    }

    function deleteScale($id)
    {
        $scale = $this->entity->find($id);
        $scale->delete();
    }
}
