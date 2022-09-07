<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Models\Interests;
use App\Models\User_interest;
use App\Models\Tags;
use App\Models\User_tags;
use App\Models\Profile_images;
use App\Models\Preferences;
use App\Models\Country;

use App\Models\Membership;
use App\Models\Commings;






class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * @des: Manage  Users
     * @param:
     * @return: view-> admin/users/users.blade.php
     * @dev: Panda@developer@team
     * @date:2019/11/3
    */
    public function users()
    {
        $users               = User::get();
        
        return view('admin/users/index', compact('users'));

    }

    /**
     * @des: add  Users
     * @param: User Add Form Data
     * @return: view-> admin/users/add.blade.php  ///////  view-> admin/users/index.blade.php
     * @dev: Panda@developer@team
     * @date:2019/11/3
    */
    public function add(Request $request)
	{
        // dd($_POST);

		if(!$_POST){
            $interests                 = Interests::get();
            $tags                      = Tags::get();
            
            return view('admin/users/add', compact('interests', 'tags'));
		}else{


            $this->validate($request, [
                'pro-image' => 'required'
            ]);

            $user_exist             = User::where('email', $request->email)->first();

            if($user_exist){
                return redirect()->route('admin.user.register')->with('warning', 'Email Already Exists');
            }

            $user                   = new User;

            $user->name             = $request->name;
            $user->email            = $request->email;
            
            $user->password         = bcrypt($request->password);
            $user->status           = 0;//$request->status;
            
            $user->category         = $request->category;
            $user->country          = $request->country;
            $user->city             = $request->city;
            $user->phone_number     = $request->phone_number;
            $user->description      = $request->description;

            if($request->status != 2)$user->status           = $request->status;

            $user->save();

            $user_id = $user->id;

            
            if($user->category == 2){
                // female
                $preferences = new Preferences;
                $preferences->user_id   = $user_id;
                $preferences->gender= 0;
                $preferences->year  = $request->her_year;
                $preferences->hetero    = 0;
                $preferences->bi        = 0;
                $preferences->testing   = 0;
                if(isset($request->her_hetero) && $request->her_hetero == "on"){
                    $preferences->hetero = 1;
                }

                if(isset($request->her_bi) && $request->her_bi == "on"){
                    $preferences->bi = 1;
                }

                if(isset($request->her_testing) && $request->her_testing == "on"){
                    $preferences->testing = 1;
                }
                $preferences->save();

                // male
                $preferences = new Preferences;
                $preferences->user_id   = $user_id;
                $preferences->gender= 1;
                $preferences->year  = $request->his_year;

                $preferences->hetero    = 0;
                $preferences->bi        = 0;
                $preferences->testing   = 0;

                if(isset($request->his_hetero) && $request->his_hetero == "on"){
                    $preferences->hetero = 1;
                }

                if(isset($request->his_bi) && $request->his_bi == "on"){
                    $preferences->bi = 1;
                }

                if(isset($request->his_testing) && $request->his_testing == "on"){
                    $preferences->testing = 1;
                }
                $preferences->save();
            }else if($user->category == 1){
                // male
                $preferences = new Preferences;
                $preferences->user_id   = $user_id;
                $preferences->gender= 1;
                $preferences->year  = $request->his_year;

                $preferences->hetero    = 0;
                $preferences->bi        = 0;
                $preferences->testing   = 0;

                if(isset($request->his_hetero) && $request->his_hetero == "on"){
                    $preferences->hetero = 1;
                }

                if(isset($request->his_bi) && $request->his_bi == "on"){
                    $preferences->bi = 1;
                }

                if(isset($request->his_testing) && $request->his_testing == "on"){
                    $preferences->testing = 1;
                }
                $preferences->save();
            }else{
                // female
                $preferences = new Preferences;
                $preferences->user_id   = $user_id;
                $preferences->gender= 0;
                $preferences->year  = $request->her_year;
                $preferences->hetero    = 0;
                $preferences->bi        = 0;
                $preferences->testing   = 0;
                if(isset($request->her_hetero) && $request->her_hetero == "on"){
                    $preferences->hetero = 1;
                }

                if(isset($request->her_bi) && $request->her_bi == "on"){
                    $preferences->bi = 1;
                }

                if(isset($request->her_testing) && $request->her_testing == "on"){
                    $preferences->testing = 1;
                }
                $preferences->save();
            }

            if($request->hasfile('pro-image')) {
                // dd($request->file('pro-image'));
                foreach($request->file('pro-image') as $file){
                    $name=$file->getClientOriginalName();
                    $file->move(public_path().'/files/', $name);  
                    $data[] = $name;  
                }
            }
            
            foreach($data as $item){
                $file            = new Profile_images();
                $file->filename  = $item;
                $file->user_id   = $user_id;
                $file->save();
            }

            foreach($request->tags as $item){
                $user_tags          = new User_tags;
                $user_tags->user_id = $user_id;
                $user_tags->tag_id  = $item;

                $user_tags->save();
            }

            foreach($request->interests as $item){
                $user_interest              = new User_interest;
                $user_interest->user_id     = $user_id;
                $user_interest->interest_id = $item;

                $user_interest->save();
            }

            return redirect()->route('admin.users')
                    ->with('success','New User Added!');
		}
    }


    /**
     * @des: update  Users
     * @param: User Edit Form Data
     * @return: view-> admin/users/edit.blade.php  ///////   view-> admin/users/index.blade.php
     * @dev: Panda@developer@team
     * @date:2019/11/3
    */
    public function update(Request $request)
	{
		if(!$_POST){
            $user                   = User::find($request->id);
            $user_preferences       = Preferences::where('user_id', $request->id)->get();
            $tags                   = Tags::all();
            $user_tags              = User_tags::where('user_id', $request->id)->get();

            $interests              = Interests::all();
            $user_interests         = User_interest::where('user_id', $request->id)->get();
            // $country                = Country::get();
            
            // $memberships            = Membership::get();
			return view('admin/users/edit', compact('user', 'user_preferences', 'tags', 'user_tags', 'interests', 'user_interests', 'states'));
		}else{

            // $this->validate($request, [
            //     'pro-image' => 'required'
            // ]);

            // $user_exist             = User::where('email', $request->email)->first();

            // if($user_exist){
            //     return redirect()->route('admin.user.register')->with('warning', 'Email Already Exists');
            // }
                
            // dd($request);

            $user                   = User::find($request->id);

            $user->name             = $request->name;
            $user->email            = $request->email;
            
            if($request->password != "")$user->password         = bcrypt($request->password);
            
            $user->category         = $request->category;
            $user->country          = $request->country;
            $user->city             = $request->city;
            $user->phone_number     = $request->phone_number;
            $user->description      = $request->description;
            if($request->status != 2) $user->status           = $request->status;
            $user->save();

            $user_id = $user->id;

            
            if($user->category == 2){
                // female
                $preferences = Preferences::where('user_id', $user_id)->where('gender', 0)->first();
                // $preferences->user_id   = $user_id;
                // $preferences->gender    = 0;
                $preferences->year      = $request->her_year;
                $preferences->hetero    = 0;
                $preferences->bi        = 0;
                $preferences->testing   = 0;
                if(isset($request->her_hetero) && $request->her_hetero == "on"){
                    $preferences->hetero = 1;
                }

                if(isset($request->her_bi) && $request->her_bi == "on"){
                    $preferences->bi = 1;
                }

                if(isset($request->her_testing) && $request->her_testing == "on"){
                    $preferences->testing = 1;
                }
                $preferences->save();

                // male
                $preferences = Preferences::where('user_id', $user_id)->where('gender', 1)->first();
                // $preferences->user_id   = $user_id;
                // $preferences->gender= 1;
                $preferences->year  = $request->his_year;

                $preferences->hetero    = 0;
                $preferences->bi        = 0;
                $preferences->testing   = 0;

                if(isset($request->his_hetero) && $request->his_hetero == "on"){
                    $preferences->hetero = 1;
                }

                if(isset($request->his_bi) && $request->his_bi == "on"){
                    $preferences->bi = 1;
                }

                if(isset($request->his_testing) && $request->his_testing == "on"){
                    $preferences->testing = 1;
                }
                $preferences->save();
            }else if($user->category == 1){
                // male
                Preferences::where('user_id', $user_id)->where('gender', 0)->delete();

                $preferences = Preferences::where('user_id', $user_id)->where('gender', 1)->first();
                // $preferences->user_id   = $user_id;
                // $preferences->gender= 1;
                $preferences->year  = $request->his_year;

                // $preferences->hetero    = 0;
                // $preferences->bi        = 0;
                // $preferences->testing   = 0;

                if(isset($request->his_hetero) && $request->his_hetero == "on"){
                    $preferences->hetero = 1;
                }

                if(isset($request->his_bi) && $request->his_bi == "on"){
                    $preferences->bi = 1;
                }

                if(isset($request->his_testing) && $request->his_testing == "on"){
                    $preferences->testing = 1;
                }
                $preferences->save();
            }else{
                // female
                $preferences = Preferences::where('user_id', $user_id)->where('gender', 1)->delete();
                $preferences = Preferences::where('user_id', $user_id)->where('gender', 0)->first();

                $preferences->year  = $request->her_year;
                if(isset($request->her_hetero) && $request->her_hetero == "on"){
                    $preferences->hetero = 1;
                }

                if(isset($request->her_bi) && $request->her_bi == "on"){
                    $preferences->bi = 1;
                }

                if(isset($request->her_testing) && $request->her_testing == "on"){
                    $preferences->testing = 1;
                }
                $preferences->save();
            }

            // if($request->hasfile('pro-image')) {
            //     // dd($request->file('pro-image'));
            //     foreach($request->file('pro-image') as $file){
            //         $name=$file->getClientOriginalName();
            //         $file->move(public_path().'/files/', $name);  
            //         $data[] = $name;  
            //     }
            // }

            // $file= new Profile_images();
            // $file->filenames = json_encode($data);
            // $file->user_id   = $user_id;
            // $file->save();
            User_tags::where('user_id', $user_id)->delete();
            if(isset($request->tags)){
                foreach($request->tags as $item){
                    $user_tags = new User_tags;
                    
                    $user_tags->user_id = $user_id;
                    $user_tags->tag_id  = $item;

                    $user_tags->save();
                }
            }

            User_interest::where('user_id', $user_id)->delete();
            if(isset($request->interests)){
                foreach($request->interests as $item){
                    $user_interest = new User_interest;
                    $user_interest->user_id     = $user_id;
                    $user_interest->interest_id = $item;

                    $user_interest->save();
                }
            }
            return redirect()->route('admin.users')
                    ->with('success', $user->name."'s Profile Updated!");


		}

    }


    public function show(Request $request){
        $user_id = $request->id;

        $user               = User::find($user_id);
        
        
        $count              = User::where('id', $user_id)->get()->count();
        
        if($count!=0){
            $user_preferences   = Preferences::where('user_id', $user_id)->get();
    
    
            $userTags           = User_tags::where('user_id', $user_id)->get();
            $i                  = 0;
            $user_tags          = array();
            foreach($userTags as $item){
                $user_tags[$i++] = Tags::select('name')->find($item->tag_id);
            }
    
            $userInterests      = User_interest::where('user_id', $user_id)->get();
            $i                  = 0;
            $user_interests     = array();
            foreach($userInterests as $item){
                $user_interests[$i++] = Interests::select('name')->find($item->interest_id);
            }
    
            $user_photos = Profile_images::select('filename')->where('user_id', $user_id)->get();
    
            // dd($user_photos);    
    
    
            return view('admin/users/view', compact('user', 'user_preferences', 'user_tags', 'user_interests', 'user_photos'));
        }else{
            return view('admin/users/error');
        }
        
    }
    /**
     * @des: delete  Users
     * @param: User Edit Form Data
     * @return: view-> admin/users/index.blade.php
     * @dev: Panda@developer@team
     * @date:2019/11/3
    */
    public function delete(Request $request){
        User::find($request->did)->delete();
        
        Profile_images::where('user_id', $request->did)->delete();
        User_interest::where('user_id', $request->did)->delete();
        User_tags::where('user_id', $request->did)->delete();
        
        Commings::where('user_id', $request->did)->delete();
        
        return redirect()->route('admin.users')
                ->with('success','User Deleted!');
    }


}
