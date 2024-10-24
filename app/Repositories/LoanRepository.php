<?php

namespace App\Repositories;

use App\Models\Loan;
use Illuminate\Http\Request;

class LoanRepository
{
    protected $entity;

    function __construct(Loan $model)
    {
        $this->entity = $model;
    }

    public function getAllLoans()
    {
        return $this->entity->orderBy('status')->get();
    }

    public function createLoan($loan)
    {
        $this->entity->create($loan);
    }

    public function returnLoan($id)
    {
        $loan = $this->entity->find($id);
        $loan->status = 2;
        $loan->date_return = date('Y-m-d H:i:s');
        $loan->save();

        return $loan;
    }

    public function extendMin($id)
    {
        $loan = $this->entity->find($id);

        $newLimitDate = date('Y-m-d', strtotime('+7 days'));
        $loan->date_limit = $newLimitDate;
        $loan->save();

        $loan->date_limit = date('d/m/Y', strtotime($loan->date_limit));

        return $loan;
    }

    public function extendMax($id)
    {
        $loan = $this->entity->find($id);

        $newLimitDate = date('Y-m-d', strtotime('+15 days'));
        $loan->date_limit = $newLimitDate;
        $loan->save();

        $loan->date_limit = date('d/m/Y', strtotime($loan->date_limit));

        return $loan;
    }

    public function deleteCategory($category)
    {
        $category->delete();
    }

    public function getCategory($id)
    {

        return $this->entity->find($id);
    }

    public function getLateLoans()
    {
        return $this->entity->where('status', 1)->where('date_limit', '<', date('Y-m-d'))->get();
    }
}
