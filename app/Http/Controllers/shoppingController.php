<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use App\Models\shoppingModel;



class shoppingController extends Controller
{
    protected $user;
 
    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }
    public function index()
    {
        return shoppingModel::all();
    }
    public function show($id)
    {
        $product = $this->user->products()->find($id);
    
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, product with id ' . $id . ' cannot be found'
            ], 400);
        }
    
        return $product;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required|integer',
            'quantity' => 'required|integer'
        ]);
    
        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
    
        if ($this->user->products()->save($product))
            return response()->json([
                'success' => true,
                'product' => $product
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Sorry, product could not be added'
            ], 500);
    }

}
