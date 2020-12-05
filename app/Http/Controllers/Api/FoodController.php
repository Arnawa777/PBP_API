<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Food;
//use Illuminate\Support\Facades\Auth;

class FoodController extends Controller
{
    public function index(){
        $foods = Food::all(); //mengambil semua data food

        if(count($foods) > 0){
            return response([
                'message' => 'Retreive All Food Success',
                'data' => $foods
            ],200);
        } //return data semua food dalam bentuk json

        return response([
            'message' => 'Empty Food',
            'data' => null
        ],404); //return message data food kosong
    }

    public function show($id){
        $food = Product::find($id); //mencari data Food berdasarkan id

        if(!is_null($food)){
            return response([
                'message' => 'Retreive Food Success',
                'data' => $food
            ],200); //return data Food yang ditemukan dalam bentuk json
        }

        return response([
            'message' => 'Food Not Found',
            'data' => null
        ],404); //return message saat data Food tidak ditemukan
    }

    public function store(Request $request){
        $storeData = $request->all(); //mengambil semua input dari api client
        $validate = Validator::make($storeData, [
            'food_name' => 'required|string',
            'price' => 'required|numeric',
            'image_food' => 'required|string'
        ]); //membuat rule validasi input

        if($validate->fails())
            return response(['message' => $validate->errors()],400); //return error invalid input
        
            $food = Food::create($storeData); //menambah data Food baru
            return response([
                'message' => 'Add Food Success',
                'data' => $food,
            ],200); //return data Food baru dalam bentuk json
    }

    public function destroy($id){
        $food = Food::find($id); //mencari data Food berdasarkan id

        if(is_null($food)){
            return response([
                'message' => 'Food Not Found',
                'data' => null
            ], 404); //return message saat data Food tidak ditemukan
        }

        if($food->delete()){
            return response([
                'message' => 'Delete Food Success',
                'data' => $food,
            ],200); //return message saat berhasil menghapus data Food
        } 
        return response([
            'message' => 'Delete Food Failed',
            'data' => null,
        ],400); //return message saat gagal menghapus data Food
    }
    public function update(Request $request, $id){
        $food = Food::find($id);
        if(is_null($food)){
            return response([
                'message' => 'Food Not Found',
                'data' => null
            ],404); //return message saat data Food tidak ditemukan
        }

        $updateData = $request->all(); //mengambil semua input dari api client
        $validate = Validator::make($updateData, [
            'food_name' => 'required|string',
            'price' => 'required|numeric',
            'image_food' => 'required|string'
        ]); //membuat rule validasi input

        if($validate->fails())
            return response(['message' => $validate->errors()],400);  //return error invalid input

        $food->food_name = $updateData['food_name'];
        $food->price = $updateData['price'];
        $food->image_food = $updateData['image_food'];

        if($food->save()){
            return response([
                'message' => 'Update Food Success',
                'data' => $food,
            ],200); //return data Food yang telah di edit dalam bentuk json
        }
        return response([
            'message' => 'Update Food Failed',
            'data' => null,
        ],400); //return message saat Food gagal di edit
    }
}
