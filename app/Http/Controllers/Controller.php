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
    public function createPayment(Request $request, Payments $paymentsService ){
        if($request->input('sale_price') == null || $request->input('currency') == null || $request->input('product_name') == null){
            return response([  "message" => "Something went wrong"],400);
        }
        try {
            $res =  $paymentsService->createPayment($request);
            if(!is_null($res)){
                return response([  "message" => "new payment created","res" =>$res],201);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Something went wrong",
                "error" => $th,
                "statusCode" => 500]);
        }
    }

    public function getPayments(Payments $paymentsService ){
        try {
            $res = $paymentsService->getPayments();
            return response()->json($res, 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Something went wrong",
                "error" => $th,
                "statusCode" => 500]);
        }

    }

    public function updatePayment($id, Request $request,Payments $paymentsService){
        try {
            $res  = $paymentsService->updatePayment($id,$request);
            if(!$res){
                return response( ['error' => 'payment not found'] ,404);

            }
            return response($res );
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Something went wrong",
                "error" => $th,
                "statusCode" => 500]);
        }
    }

    public function removePayment($id,Payments $paymentsService){
        try{
            $res = $paymentsService->removePayment($id);
            if(!$res){
                return response( ['error' => 'payment not found'] ,404);
            }
                return response(null, 204);
        }catch (\Throwable $th) {
            return response()->json([
                "message" => "Something went wrong",
                "error" => $th,
                "statusCode" => 500]);
        }
    }

    public function form($id){
       return view('form');
    }
}
