<?php

namespace App\Http\Controllers;

use App\Models\AccountBank;
use App\Models\Transaction;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Object_;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $transaction = new Transaction($request->all());

        if($transaction->transactionType == 1){
            $accountTo = AccountBank::find($transaction->to);
            if($accountTo) {
                $accountTo->balance += $transaction->amount;
                $accountTo->save();
                $transaction->from = null;
                $transaction->save();
                return Response("Deposit success");
            } else {
                return Response("Account not found");
            }

        }
        if($transaction->transactionType == 2){
            $accountTo = AccountBank::find($transaction->to);
            if($accountTo) {
                if($accountTo->balance >= $transaction->amount){
                    $accountTo->balance -= $transaction->amount;
                    $accountTo->save();
                    $transaction->from = null;
                    $transaction->save();
                    return Response("Withdrawal success");
                } else {
                    return Response("Insufficient balance");
                }

            } else {
                return Response("Account not found");
            }

        }
        if($transaction->transactionType == 3){
            $accountFrom = AccountBank::find($transaction->from);
            $accountTo = AccountBank::find($transaction->to);

            if($accountTo && $accountFrom) {
                if($accountFrom->balance >= $transaction->amount){
                    $accountFrom->balance -= $transaction->amount;
                    $accountTo->balance += $transaction->amount;
                    $accountFrom->save();
                    $accountTo->save();
                    $transaction->save();
                    return Response("Transfer success");
                } else {
                    return Response("Insufficient balance");
                }

            } else {
                return Response("Account not found");
            }

        }
    }

    /**
     * 1deposit
     * 2withdrawal
     * 3transfer
     */

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $post)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function checkingAndCleaner(Request $request)
    {
        ///logica para checkear transacciones con cuentas y limpiar datos
        $allAccountBanks=AccountBank::all();
        $arrayAccountError=[];
        foreach($allAccountBanks as $item){
            $valueBalanceAccount=$item->balance;
            $valueBalanceTransactionsT=0;
            $valueBalanceTransactionsTo=0;
            $valueBalanceTransactionsFrom=0;
            $flag=false;
            $transactionsTo=Transaction::where('to', $item->id)->get();
            $transactionsFrom=Transaction::where('from', $item->id)->get();
            foreach ($transactionsTo as $itemT) {
            $flag=true;
            $valueBalanceTransactionsTo+=$itemT->	amount;
            }
            foreach ($transactionsFrom as $itemT) {
                $valueBalanceTransactionsFrom+=$itemT->	amount;
            }

            if($flag){
                $valueBalanceTransactionsT= $valueBalanceTransactionsTo -  $valueBalanceTransactionsFrom;
            }
            if($valueBalanceTransactionsT>0 && ( $valueBalanceAccount !=  $valueBalanceTransactionsT)){
                array_push($arrayAccountError,['idAccountBank'=>$item->id,'balanceAccount'=>$valueBalanceAccount,'balanceTransactionTotal'=>$valueBalanceTransactionsT]);
            }
        }

        foreach($allAccountBanks as $item){
            $transactionsForTo=Transaction::where('to', $item->id)->get();
            $transactionsForFrom=Transaction::where('from', $item->id)->get();
            $item->balance=0;
            foreach ($transactionsForTo as $key ) {
                $key->delete();
            }
            foreach ($transactionsForFrom as $key ) {
                $key->delete();
            }
            $item->save();
        }
        return response()->json([
            'data' => $arrayAccountError
        ]);
    }
    public function checkingTransaction(Request $request)
    {
        ///logica para checkear transacciones con cuentas y limpiar datos
        $allAccountBanks=AccountBank::all();
        $arrayAccountError=[];
        foreach($allAccountBanks as $item){
            $valueBalanceAccount=$item->balance;
            $valueBalanceTransactions=0;
            $flag=false;
            $transactions=Transaction::where('to', $item->id)->get();
            foreach ($transactions as $itemT) {
            $flag=true;
            $valueBalanceTransactions+=$itemT->	amount;
            }
            if($flag &&  $valueBalanceAccount!=$valueBalanceTransactions){
                array_push($arrayAccountError,['idAccountBank'=>$item->id,'balanceAccount'=>$valueBalanceAccount,'balanceTransactionTotal'=>$valueBalanceTransactions]);
            }
        }
        return response()->json([
            'data' => $arrayAccountError
        ]);
    }
}
