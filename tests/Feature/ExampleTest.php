<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Services\Payments;



class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
//    protected function setUp(): void
//    {
//        parent::setUp();
//        $body = [
//            "seller_payme_id"=>"MPL14985-68544Z1G-SPV5WK2K-0WJWHC7N",
//            "sale_price"=>123,
//            "currency"=>'ILS',
//            "product_name"=> 'T-shirt',
//            "installments"=>"1",
//            "language"=> "en"
//        ];
//    }
    public function testCreatePaymentSuccess()
    {
        $body = [
            "seller_payme_id" => "MPL14985-68544Z1G-SPV5WK2K-0WJWHC7N",
            "sale_price" => 123,
            "currency" => 'ILS',
            "product_name" => 'T-shirt',
            "installments" => "1",
            "language" => "en"
        ];

        $this
            ->postJson("/payment", $body)->assertStatus(201)
            ->assertJson(["message" => 'new payment created',]);
    }

    public function testCreatePaymentFail(){
        $body = [
            "language" => "en"
        ];
        $this->postJson("/payment", $body)->assertStatus(400)
            ->assertJson(["message" => 'Something went wrong',]);
    }

    public function testReadData(){
        $res =  $this->getJson("/payments")->assertStatus(200);
        $this->assertEquals('T-shirt', $res[0]['description']);
    }
    public function testUpdateDataSuccess(){
        $body =[
            "description"=>"T-shirt",
            "amount"=> "12670",
            "currency"=> "ILS"
        ];
        $this->putJson("/payment/6",$body)->assertStatus(200)
        ->assertJson( ["currency"=> "ILS"]);
    }

    public function testUpdateDataFail(){
        $body =[
            "description"=>"drum",
            "amount"=> "12670",
            "currency"=> "ILS"
        ];
        $this->putJson("/payment/100000000000000",$body)->assertStatus(404)
            ->assertJson( ['error' => 'payment not found']);
    }

    public function testRemoveDataSuccess(){
        $res = json_decode($this->getJson("/payments")->getContent());
        $id = end($res)->id;
        $this->deleteJson("/payment/$id")->assertStatus(204);
    }

    public function testRemoveDataFail(){
        $id  = 100000000000;
        $this->deleteJson("/payment/$id")->assertStatus(404);
    }

}
