<?php

namespace App\Http\Controllers;

use App\Services\Payments;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{


    public function createPayment(Request $request, Payments $paymentsService)
    {
        if ($request->input('sale_price') == null || $request->input('currency') == null || $request->input('product_name') == null) {
            return response(["message" => "Something went wrong"], 400);
        }
        try {
            $res = $paymentsService->createPayment($request);
            if (!is_null($res)) {
                return response(["message" => "new payment created", "res" => $res], 201);
            }
        } catch (\Exception $th) {
            return response([
                "message" => "Something went wrong",
                "error" => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * @param Payments $paymentsService
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPayments(Payments $paymentsService): \Illuminate\Http\JsonResponse
    {
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

    /**
     * @param $id
     * @param Request $request
     * @param Payments $paymentsService
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function updatePayment($id, Request $request, Payments $paymentsService) : \Illuminate\Http\Response
    {
        try {
            $res = $paymentsService->updatePayment($id, $request);
            if (!$res) {
                return response(['error' => 'payment not found'], 404);
            }
            return response($res);
        } catch (\Throwable $th) {
            return response([
                "message" => "Something went wrong",
                "error" => $th,
                "statusCode" => 500]);
        }
    }

    /**
     * @param $id
     * @param Payments $paymentsService
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function removePayment($id, Payments $paymentsService) : \Illuminate\Http\Response
    {
        try {
            $res = $paymentsService->removePayment($id);
            if (!$res) {
                return response(['error' => 'payment not found'], 404);
            }
            return response(null, 204);
        } catch (\Throwable $th) {
            return response([
                "message" => "Something went wrong",
                "error" => $th,
                "statusCode" => 500]);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function form($id) : \Illuminate\Contracts\View\View
    {
        return view('form');
    }
}
