<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Throwable;


class Payments
{
    /**
     * @param $request
     * @return int
     */
    public function createPayment($request) : int
    {
        try {
            $creationData = [
                "seller_payme_id" => "MPL14985-68544Z1G-SPV5WK2K-0WJWHC7N",
                "sale_price" => $request->input('sale_price'),
                "currency" => $request->input('currency'),
                "product_name" => $request->input('product_name'),
                "installments" => "1",
                "language" => "en"
            ];
            $res = self::httpPayment($creationData);
            $payment = self::insert($request, $res);
            return $payment;
        } catch (Throwable $th) {
            return 1;
        }
    }

    /**
     * @param $payment
     * @return \Illuminate\Http\Client\Response
     */
    public function httpPayment($payment) :\Illuminate\Http\Client\Response
    {
        try {
            return Http::post('https://sandbox.payme.io/api/generate-sale', $payment);
        } catch (Throwable $th) {
            throw $th;
        }
    }

    /**
     * @param $request
     * @param $httpRes
     * @return mixed
     * @throws Throwable
     */
    public function insert($request, $httpRes) : mixed
    {
        try {
            return Payment::create([
                "description" => $request->input('product_name'),
                "amount" => $request->input('sale_price'),
                "currency" => $request->input('currency'),
                "sale_number" => $httpRes['payme_sale_code'],
                "link" => $httpRes['sale_url']
            ]);
        } catch (Throwable $th) {
            throw $th;
        }
    }

    /**
     * @return Payment[]|\Illuminate\Database\Eloquent\Collection
     * @throws Throwable
     */
    public function getPayments() : \Illuminate\Database\Eloquent\Collection
    {
        try {
            $payments = Payment::all();
            return $payments;
        } catch (Throwable $th) {
            throw $th;
        }
    }

    /**
     * @param $id
     * @param $request
     * @return false
     * @throws Throwable
     */
    public function updatePayment($id, $request)
    {
        try {
            $payment = Payment::find($id);

            if (!$payment) {
                return false;
            }

            $payment->description = $request->description;
            $payment->amount = $request->amount;
            $payment->currency = $request->currency;
            $payment->save();
            return $payment;
        } catch (Throwable $th) {
            throw $th;
        }
    }

    /**
     * @param $id
     * @return bool
     * @throws Throwable
     */
    public function removePayment($id) :bool
    {
        try {
            $payment = Payment::find($id);
            if (!$payment) {
                return false;
            }
            $payment->delete();

            return true;
        } catch (Throwable $th) {
            throw $th;
        }
    }
}
