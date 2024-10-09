<?php

namespace App\Http\Controllers\Api;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Traits\HandlesTransactions;
use App\Http\Controllers\Controller;
use App\Services\TransactionService;
use App\Http\Resources\TransactionResource;
use App\Http\Requests\Transaction\StoreTransactionRequest;
use App\Http\Requests\Transaction\UpdateTransactionRequest;

class TransactionController extends Controller
{
    use ApiResponseTrait, HandlesTransactions;

    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::paginate(10);
        return $this->successResponse(TransactionResource::collection($transactions), 'Transactions retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransactionRequest $request)
    {
        return $this->handleTransaction(function () use ($request) {
            $transaction = $this->transactionService->createTransaction($request->validated());
            return $this->successResponse(new TransactionResource($transaction), 'Transaction created successfully', 201);
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        return $this->successResponse(new TransactionResource($transaction), 'Transaction retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        return $this->handleTransaction(function () use ($request, $transaction) {
            $updatedTransaction = $this->transactionService->updateTransaction($transaction, $request->validated());
            return $this->successResponse(new TransactionResource($updatedTransaction), 'Transaction updated successfully');
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        return $this->handleTransaction(function () use ($transaction) {
            $this->transactionService->deleteTransaction($transaction);
            return $this->successResponse(null, 'Transaction deleted successfully', 204);
        });
    }
}
