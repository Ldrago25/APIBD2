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
        
    }
}
