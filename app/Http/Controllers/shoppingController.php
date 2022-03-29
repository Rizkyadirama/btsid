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
        $product = shoppingModel::where('id', $id)->get();
    
        if ($product->count() < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, product with id ' . $id . ' cannot be found'
            ], 400);
        }
    
        return $product;
    }

    public function store(Request $request)
    {
        
        $produk = ShoppingModel::create([
            'Name'=> $request->name,
        ]);

    
        if ($produk)
            return response()->json([
                'success' => true,
                'product' => $produk
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Sorry, product could not be added'
            ], 500);
    }


    public function update(Request $request, $id){
        $product = shoppingModel::find($id);
    
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, product not found'
            ], 400);
        }
        
        $product->Name  = $request->name;
        $updated = $product->save();
    
        if ($updated) {
            return response()->json([
                'success' => true,
                'product' => $product
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, product could not be updated'
            ], 500);
        }
    }

    public function delete($id){
        $product = shoppingModel::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, product not found'
            ], 400);
        }

        if ($product->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Product could not be deleted'
            ], 500);
        }
    }
    

}
