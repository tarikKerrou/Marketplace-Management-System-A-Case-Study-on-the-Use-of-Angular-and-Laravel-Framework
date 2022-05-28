<?php

namespace App\Http\Controllers;
use App\Models\Produits;
use Illuminate\Http\Request;
use Illuminate\support\facades\Validator;

class ProduitsController extends Controller
{
    public function add(Request $request){
        $validator=Validator::make($request->all(),[
        'name'=>'required',
        'category'=>'required',
        'brand'=>'required',
        'desc'=>'required',
        'price'=>'required',
        'image'=>'required|image',
        
        ]);
        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()->all()],409);
        }
        $prdct=new Produits();
        $prdct->name=$request->name;
        $prdct->category=$request->category;
        $prdct->brand=$request->brand;
        $prdct->desc=$request->desc;
        $prdct->price=$request->price;
        $prdct->save();
        $url ="http://localhost:8000/storage";
        $file=$request->file( 'image');
        $extension=$file->getClientExtension();
        $path=$request->file ('image')->storeAs('proimages/',$prdct->id.'.'.$extension);
        $prdct->image=$path;
        $prdct->img=$url.$path;
        $prdct->save;



       
    }
    public function update(Request $request){
        $validator=Validator::make($request->all(),[
        'name'=>'required',
        'category'=>'required',
        'brand'=>'required',
        'desc'=>'required',
        'price'=>'required',
        'id'=>'required',
        
        
        ]);
        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()->all()],409);
        }
        $prdct=Produits::find($request->id);
        $prdct->name=$request->name;
        $prdct->category=$request->category;
        $prdct->brand=$request->brand;
        $prdct->desc=$request->desc;
        $prdct->price=$request->price;
        $prdct->save();
        return response()->json(['message'=>"product successfully updated "]);
     
}
public function delete(Request $request){
    $validator=Validator::make($request->all(),[
    
    'id'=>'required',
    
    
    ]);
    if($validator->fails()){
        return response()->json(['error'=>$validator->errors()->all()],409);
    }
    $prdct=Produits::find($request->id)->delete();
    
    return response()->json(['message'=>"product successfully delted "]);
 
}
public function show (Request $request){
    session(['keys'=>$request->keys]);
     
    $produits=Produits::where(function($p){
        $p->where('produits.id','LIKE','%'.session(':keys').'%')
        ->orwhere('produits.name','LIKE','%'.session(':keys').'%')
        ->orwhere('produits.price','LIKE','%'.session(':keys').'%')
        ->orwhere('produits.category','LIKE','%'.session(':keys').'%')
        ->orwhere('produits.brand','LIKE','%'.session(':keys').'%');
    })->select('produits.*')->get();
    return response()->json(['produits'=>$produits]);
}
}