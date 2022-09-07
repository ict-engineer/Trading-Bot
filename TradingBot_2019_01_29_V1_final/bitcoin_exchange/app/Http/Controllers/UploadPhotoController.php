<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\Profile_images;
class UploadPhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    public function uploadProfile(Request $request){
        $cookie = request()->cookie();
        $token = $cookie["XSRF-TOKEN"];
        
        
        if(isset($request['files'])){
            $i = 0;
            foreach($request['files'] as $file){
                $i++;
                $prefix = rand(1, 999999).'_'.$i;
                $name=$prefix.'-'.$file->getClientOriginalName();
                $file->move(public_path().'/files/', $name);  
                $data[] = $name;  
            }

            foreach($data as $item){
                $file            = new Profile_images();
                $file->filename  = $item;
                $file->user_id   = $token;
                $file->save();
            }
         }
     }
     
     
    //  load
     public function fetchProfile(Request $request){
         $cookie = request()->cookie();
         $token = $cookie["XSRF-TOKEN"];
         
         $profiles   = Profile_images::where('user_id', $token)->get();
        
         $result = "";
         
         foreach($profiles as $profile){
             $result .="<div class='preview-image preview-show-".$profile->id."'>"
                            ."<div class='image-cancel' data-no='".$profile->id."'>x</div>"
                            ."<div class='image-zone'><img id='pro-img-".$profile->id."' src='".asset("files/$profile->filename")."'></div>"
                            ."<div class='tools-edit-image'><a href='javascript:void(0)' data-no='".$profile->id."' class='btn btn-light btn-edit-image'>edit</a></div>"
                        ."</div>";
                        
                        
            
         }  
         echo $result;
     }
     
     
     public function deleteProfile(Request $request){
        
         $image_id = $request->image_id;
         
         if(isset($image_id)){
            $image = Profile_images::find($image_id);
            $image_name = $image->filename;
            
            $file_path  = app_path("files/$image_name");
            // if(File::delete($file_path)){
                $image->delete();
            // }
        }
     }
     
     
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
