<?php

namespace App\Http\Controllers;

use App\Items;
use App\Rules\UpperCase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Panoscape\Vuforia\Facades\VuforiaWebService;

class ItemsController extends Controller
{
    public function index()
    {
        $allItems = Items::all();
        return view('welcome', ['allItems' => $allItems]);

        //return view('welcome');
    }
    public function addTarget(Request $request){

        $this->validate($request,[
            'picture'=>'mimes:jpeg,jpg,png|required|max:2000',
            'model'=>['required', 'max:20000', new Uppercase()],

        ]);
        $tname=str_random(25);

        $currentTime = Carbon::now()->timestamp;
        $image = $request->file('picture');
        $pic_name = $currentTime . '.' . $image->getClientOriginalExtension();
        $path_pic = '/public/' . $currentTime . '/picture';
        $upload_pic = Storage::putFileAs($path_pic, $image, $pic_name);
        $picture_url = public_path('storage/' . $currentTime . '/picture/' . $pic_name);



        $model = $request->file('model');
        $model_name = $currentTime . '.' . $model->getClientOriginalExtension();
        $path_model = '/public/' . $currentTime . '/model';
        $upload_model = Storage::putFileAs($path_model, $model, $model_name);
        $model_url = asset('storage/' . $currentTime . '/model/' . $model_name);

        $assetsFolderPath=public_path('storage/'.$currentTime);
        if(file_exists($assetsFolderPath)){
            VuforiaWebService::addTarget([
                'name' => $tname,
                'width' => 320,
                'path' => $picture_url
            ]);

            //return response()->json(['message1' => 'ok bro'], 201);
        }else{
            return response()->json(['message2' => [$picture_url]], 201);

        }
        $items=new Items();
        $items->name=$tname;
        $items->picture=asset('storage/' . $currentTime . '/picture/' . $pic_name);
        $items->model=$model_url;
        $items->save();
        //return response()->json(['message1' => 'ok bro'], 201);
        return redirect('/');



    }
    public function publishItem()
    {
        $specific_items= Items::all();;
        Storage::put('/public/project/manifest.json', json_encode(['contents'=>$specific_items],JSON_UNESCAPED_SLASHES));
        return back()->withInput();
        //return DB::table('items')->get();
    }
    public function manifest(){
        $storeData= DB::table('storedata')->get();
        return (json_encode($storeData ,JSON_UNESCAPED_SLASHES));
    }

}
