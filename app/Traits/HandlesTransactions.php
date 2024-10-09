<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Exception;

trait HandlesTransactions
{
    public function handleTransaction(callable $callback)
    {
        try {
            return DB::transaction($callback);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Something went wrong',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
