<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;
use App\Models\Payment;


class Payments {

    public  function createPayment($request){
        try {
            $creationData = [
                "seller_payme_id"=>"MPL14985-68544Z1G-SPV5WK2K-0WJWHC7N",
                "sale_price"=>$request->input('sale_price'),
                "currency"=>$request->input('currency'),
                "product_name"=> $request->input('product_name'),
                "installments"=>"1",
                "language"=> "en"
            ];
            $res = self::httpPayment($creationData);
            $payment = self::insert($request,$res);
            return $payment ;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

     public function httpPayment($payment){
        try {
            return Http::post('https://sandbox.payme.io/api/generate-sale' , $payment );
        } catch (\Throwable $th) {
            throw $th ;
        }
    }

     public function insert($request,$httpRes){
        try {
            $payment = Payment::create([
                "description"=> $request->input('product_name'),
                "amount"=> $request->input('sale_price'),
                "currency"=> $request->input('currency'),
                "sale_number" =>$httpRes['payme_sale_code'],
                "link" => $httpRes['sale_url']
            ]);
            return $payment;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

     public function getPayments(){
        try {
            $payments = Payment::all();
            return $payments ;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

     public function updatePayment($id,$request){
        try {
            $payment= Payment::find($id);
            if (!$payment) {
                return false;
            }
            $payment->description = $request->description;
            $payment->amount = $request->amount;
            $payment->currency = $request->currency;
            $payment->save();
            return $payment;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

     public function removePayment($id){
        try {
            $payment = Payment::find($id);
            if (!$payment) {
                return false;
            }
            $payment->delete();
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
