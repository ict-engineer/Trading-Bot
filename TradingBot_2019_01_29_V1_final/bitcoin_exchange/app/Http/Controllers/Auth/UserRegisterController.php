<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Models\Interests;
use App\Models\User_interest;
use App\Models\Tags;
use App\Models\User_tags;
use App\Models\Profile_images;
use App\User;
use App\Models\Preferences;
use PhpParser\Node\Stmt\TraitUseAdaptation\Precedence;
use Auth;

use App\Mail\SendMailVerify;
use App\Mail\AdminUserRegisterNotify;
use App\Mail\NuevoUsuario;
use App\Rules\Captcha;

class UserRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    public function login(Request $request){
        // dd($request);

        $this->validate($request, [
            'user_email'        =>'required|email',
            'user_password'     =>'required'    
        ]);

        $userInfo1 = array(
            'email'     => $request->user_email,
            'password'  => $request->user_password,
            'status'    => '1'
        );


        $userInfo2 = array(
            'email'     => $request->user_email,
            'password'  => $request->user_password,
            'status'    => '0'
        );


        if(Auth::attempt($userInfo2)){
            return redirect()->back()->with("success", "éxito");
        }
        else if(Auth::attempt($userInfo1)){
            return redirect()->back()->with("success", "éxito");
        }
        else{
            return redirect()->back()->with("error", "Error en datos");
        }
    }

    public function logout(){
        Auth::logout();
        // return back()->with("success", "successfully logout");
        return back()->with("success", "Sesi��n cerrada");
        
    }

    public function showRegisterForm(Request $request){

        if(!$_POST){
            $interests                 = Interests::get();
            $tags                      = Tags::get();
            
            return view('auth.user_register', compact('interests', 'tags'));
		}else{
            // dd($_POST);  
            // dd($request);
            // dd($_POST['category']);
            $this->validate($request, [
                'Buscamos'=>'required',
                'Intereses'=>'required',
                'g-recaptcha-response' => new Captcha(),
            ]);

            $user_exist             = User::where('email', $request->email)->first();
            // dd($user_exist);

            if($user_exist){
                // return redirect()->route('user.register')->with('warning', 'Email Already Exists');
                return redirect()->route('user.register')->with('warning', 'Ya existe el correo electrónico');

            }

            $user                   = new User;

            $user->name             = $request->name;
            $user->email            = $request->email;
            
            $user->password         = bcrypt($request->password);
            $user->status           = 0;//$request->status;
            $user->verify_code      = md5(uniqid(rand(), true));
            // $user->category         = $request->category;
            $user->category         = $request->category;
            $user->country          = $request->country;
            $user->city             = $request->city;
            $user->phone_number     = $request->phone_number;
            $user->description      = $request->description;
            $user->remember_token   = $request->_token;
            $user->save();
        
            
            
            
            
            $admin_email    = "admin@viajeswingers.com";
            // $admin_email    = "alexander950223@gmail.com";
            $mail           = new NuevoUsuario($user);
            Mail::to($admin_email)->send($mail);
            
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

            // if($request->hasfile('pro-image')) {
            //     // dd($request->file('pro-image'));
            //     foreach($request->file('pro-image') as $file){
            //         $name=$user_id.'-'.$user->name.'-'.$user->category.'-'.$file->getClientOriginalName();
            //         $file->move(public_path().'/files/', $name);  
            //         $data[] = $name;  
            //     }
            // }

            // foreach($data as $item){
            //     $file            = new Profile_images();
            //     $file->filename  = $item;
            //     $file->user_id   = $user_id;
            //     $file->save();
            // }
            
            
            
            $cookie = request()->cookie();
            $token = $cookie["XSRF-TOKEN"];
            $user_photos    = Profile_images::where('user_id', $token)->get();
            
            foreach($user_photos as $user_photo){
                $user_photo->user_id = $user_id;
                $user_photo->save();
            }
            







            foreach($request->Buscamos as $item){
                $user_tags = new User_tags;
                $user_tags->user_id = $user_id;
                $user_tags->tag_id  = $item;

                $user_tags->save();
            }

            foreach($request->Intereses as $item){
                $user_interest = new User_interest;
                $user_interest->user_id     = $user_id;
                $user_interest->interest_id = $item;

                $user_interest->save();
            }
            return back()->with('success', 'Registrado correctamente.');
		}
    }




    public function show_offerRegisterForm($id){
            // dd($id);
        
      
            $interests                 = Interests::get();
            $tags                      = Tags::get();
            $offer_id                  = $id;    
            return view('auth.user_register', compact('interests', 'tags', 'offer_id'));
	
    }
    
    
    public function show_offerRegister(Request $request){
            // dd($request);
            
            $offer_id   = $request->offer_id;
        
            $this->validate($request, [
                'pro-image' => 'required',
                'Buscamos'=>'required',
                'Intereses'=>'required',
                'g-recaptcha-response' => new Captcha(),
            ]);

            $user_exist             = User::where('email', $request->email)->first();
            // dd($user_exist);

            if($user_exist){
                // return redirect()->route('user.register')->with('warning', 'Email Already Exists');
                return redirect()->route('user.register')->with('warning', 'Ya existe el correo electrónico');

            }

            $user                   = new User;

            $user->name             = $request->name;
            $user->email            = $request->email;
            
            $user->password         = bcrypt($request->password);
            $user->status           = 0;//$request->status;
            $user->verify_code      = md5(uniqid(rand(), true));
            // $user->category         = $request->category;
            $user->category         = $request->category;
            $user->country          = $request->country;
            $user->city             = $request->city;
            $user->phone_number     = $request->phone_number;
            $user->description      = $request->description;
            $user->remember_token   = $request->_token;
            $user->save();
        
            
            // $server_name            = $_SERVER['SERVER_NAME'];
            
            // // Verify mail to user
            // $user_email     = $user->email;
            // $url            = $server_name."/verify/".$user->verify_code;
            // $mail           = new SendMailVerify($url, $user->name);
            // Mail::to($user_email)->send($mail);
            
            // dd($url);
            // send mail to Admin
            // $admin_email    = "zvatal@gmail.com";
            // $admin_email    = "blackcat20180000@gmail.com";
            $mail           = new NuevoUsuario($user);
            // Mail::to($admin_email)->send($mail);
            
            // send mail to Company
            $company_email = "admin@viajeswingers.com";
            Mail::to($company_email)->send($mail);
            
            
            
            
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
                    $name=$user_id.'-'.$user->name.'-'.$user->category.'-'.$file->getClientOriginalName();
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


            foreach($request->Buscamos as $item){
                $user_tags = new User_tags;
                $user_tags->user_id = $user_id;
                $user_tags->tag_id  = $item;

                $user_tags->save();
            }

            foreach($request->Intereses as $item){
                $user_interest = new User_interest;
                $user_interest->user_id     = $user_id;
                $user_interest->interest_id = $item;

                $user_interest->save();
            }
            // return back()->with('success', 'Registrado correctamente.');
            return redirect('show_offer/'.$offer_id)->with('success', 'Registrado correctamente.');
		
    }
    
    

    // public function backtoOffer(){
    //     return back();
    // }

    public function imageUpload(Request $request){
        dd($request);
    }
}
