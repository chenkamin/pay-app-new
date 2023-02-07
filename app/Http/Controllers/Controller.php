<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Services\Payments;
class Controller extends BaseController{

    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function createPayment(Request $request  ){
        if($request->input('sale_price') == null || $request->input('currency') == null || $request->input('product_name') == null){
            return response()->json([
                "message" => "Please fill all the fields",
                "statusCode" => 400]);
        }
        try {
            $res =  Payments::createPayment($request);
            if(!is_null($res)){
                return response()->json(
                    ['message'=>'new payment created',
                        'statusCode'=>201
                    ] );
            }
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Something went wrong",
                "error" => $th,
                "statusCode" => 500]);
        }
    }

    public function getPayments(){
        try {
            $res = Payments::getPayments();
            return response()->json($res, 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Something went wrong",
                "error" => $th,
                "statusCode" => 500]);
        }

    }

    public function updatePayment($id, Request $request){
        try {
            $res  = Payments::updatePayment($id,$request);
            return response()->json($res  , 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Something went wrong",
                "error" => $th,
                "statusCode" => 500]);
        }
    }

    public function removePayment($id){
        try{
            $res = Payments::removePayment($id);
            if($res){
                return response()->json(null, 204);
            }else{
                return response()->json([
                    "message" => "Something went wrong",
                    "statusCode" => 500]);
            }
        }catch (\Throwable $th) {
            return response()->json([
                "message" => "Something went wrong",
                "error" => $th,
                "statusCode" => 500]);
        }
    }
}
