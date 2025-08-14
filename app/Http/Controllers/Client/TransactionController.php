<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transactions\GetTransactionRequest;
use App\Services\Client\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function __construct(private TransactionService $transactionService) {}

    public function index(GetTransactionRequest $request)
    {
        $params = array_merge(
            $request->validated(),
            ['user_id' => Auth::guard('user')->id()]
        );

        $items = $this->transactionService->search($params);

        return view('client.pages.transactions.index', compact('items'));
    }

    public function show(int|string $id)
    {
        $item = $this->transactionService->show($id);
        return view('client.pages.transactions.show', compact('item'));
    }

    public function edit(int|string $code)
    {
        $item = $this->transactionService->show($code);
        return view('client.pages.transactions.edit', compact('item'));
    }

    public function update(int|string $code)
    {

    }

    public function confirm() {
        
    }
}
