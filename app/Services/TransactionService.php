<?php

namespace App\Services;

use App\Models\Transaction;

class TransactionService
{
    public function createTransaction(array $data)
    {
        return Transaction::create($data);
    }

    public function updateTransaction(Transaction $transaction, array $data)
    {
        $transaction->update($data);
        return $transaction;
    }

    public function deleteTransaction(Transaction $transaction)
    {
        $transaction->delete();
    }
}



