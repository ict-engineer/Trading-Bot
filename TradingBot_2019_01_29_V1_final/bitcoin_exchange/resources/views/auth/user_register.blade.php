@extends('layouts.app')
@section('content')
{{-- multiple image upload --}}
<link rel="stylesheet" href="{{ asset('css/multiple_image.css')}}">
<style>
    body{
        background-color:#cfe2f8;
    }
</style>
<script src="{{ asset('js/multiple_image.js')}}"></script>

{{-- end --}}
<div class="pcoded-content">
   <div class="pcoded-inner-content">
      <div class="main-body container">
         <div class="page-wrapper" style="background-color: skyblue;">


            <div class="page-header">
               <div class="page-header-title">
                  <!--<h4>User Register</h4>-->
                  <h4>Registro de usuario</h4>
               </div>
               
            </div>


            <div class="page-body">
               <div class="row">

                <div class="col-sm-12">

                    <div class="card">
                        <div class="card-header table-card-header align-items-center">
                            <div class="row">
                                <div class="col-sm-9 text-left">
                                    <h5>Formulario de Registro</h5>
                                </div>
                                <div class="col-sm-3 text-right">
                                    <span class="text-danger">(*) Campos obligatorios.</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-block">
                            <br>

                            @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Campo necesario.</strong><br><br>
                                <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                                </ul>
                            </div>
                            @endif

                            <!--@if(session('success'))-->
                            <!--    <div class="alert alert-success">-->
                            <!--    {{ session('success') }}-->
                            <!--        {{-- <span id='close' onclick='this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode); return false;'>x</span> --}}-->
                            <!--    </div> -->
                            <!--@endif-->

                            <!--@if(session('warning'))-->
                            <!--    <div class="alert alert-warning">-->
                            <!--        {{ session('warning') }}-->
                            <!--        {{-- <span id='close' onclick='this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode); return false;'>x</span> --}}-->
                            <!--    </div>                                -->
                            <!--@endif-->

                            <div class="row" style="follow:left;">
                                <div class="col-sm-1" style="follow:left;">
                                </div>

                                <div class="col-sm-10" style="follow:left">
                                    <?php 
                                    if(isset($offer_id)){
                                    ?>
                                    <form method="POST" action="{{url('user_offer_register')}}" onsubmit="return validateForm();" accept-charset="UTF-8" class="form-horizontal bordered" id="user_profile" role="form" enctype="multipart/form-data">
                                        <input type="hidden" value="{{$offer_id}}" name="offer_id">
                                        {{ csrf_field() }}
                                    <?php
                                    }
                                    else{
                                    ?>        
                                
                                    <form method="POST" action="{{url('user_register')}}" onsubmit="return validateForm();" accept-charset="UTF-8" class="form-horizontal bordered" id="user_profile" role="form" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                    <?php
                                    }
                                    ?>
                                        {{-- <input type="hidden" value="{{ csrf_field() }}" name="remember_token"> --}}

                                        <div class="form-group row">
                                            <!--<label class="col-sm-2 col-form-label">Name<span class="text-danger">*</span></label>-->
                                            <label class="col-sm-2 col-form-label">Nombre/Nick<span class="text-danger">*</span></label>
                                            
                                            <div class="col-sm-10">
                                                <!--<input type="text" name="name" value="{{old('name')}}" class="form-control" placeholder="Write  Name..." required>-->
                                                <input type="text" name="name" value="{{old('name')}}" class="form-control" placeholder="Escriba nombre..." required>
                                                
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Password<span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="password" name="password" id="password" value="" class="form-control" placeholder="password..." required>
                                            </div>
                                        </div>
        
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Confirmar Password<span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirme password..." required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 form-check-label">Categoría:<span class="text-danger">*</span></label>
                                            <div class="col-sm-10" style="float:left;">
                                                <div class="form-check col-sm-4" style="float:left;">
                                                    <input type="radio" class="form-check-input" id="couple" name="category" value="2" @if(is_array(old('category')) && in_array("2", old('category'))) checked @endif>
                                                    <!--<label class="form-check-label" for="couple">Couple</label>-->
                                                    <label class="form-check-label" for="couple">Pareja</label>
                                                    
                                                </div>
                                                

                                                <div class="form-check col-sm-4" style="float:left;">
                                                    <input type="radio" class="form-check-input" id="woman" name="category" value="0"  @if(is_array(old('category')) && in_array("0", old('category'))) checked @endif>
                                                    <!--<label class="form-check-label" for="woman">Woman alone</label>-->
                                                    <label class="form-check-label" for="woman">Mujer sola</label>
                                                    
                                                </div>


                                                <div class="form-check col-sm-4" style="float:left;">
                                                    <input type="radio" class="form-check-input" id="man" name="category" value="1"  @if(is_array(old('category')) && in_array("1", old('category'))) checked @endif>
                                                    <!--<label class="form-check-label" for="man">Man alone</label>-->
                                                    <label class="form-check-label" for="man">Hombre solo</label>
                                                    
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <!--<label class="col-sm-2 col-form-label">Country<span class="text-danger">*</span></label>-->
                                            <label class="col-sm-2 col-form-label">Pais<span class="text-danger">*</span></label>
                                        
                                            <div class="col-sm-10">
                                                <input type="text" name="country"  value="{{old('country')}}" class="form-control" placeholder="Escriba Pais..." required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <!--<label class="col-sm-2 col-form-label">City<span class="text-danger">*</span></label>-->
                                            <label class="col-sm-2 col-form-label">Ciudad<span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" name="city" value="{{old('city')}}" class="form-control" placeholder="Escriba ciudad..." required>
                                            </div>
                                        </div>
        

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Mail<span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="email" name="email" value="{{old('email')}}" class="form-control" placeholder="Escriba Mail..." required>
                                            </div>
                                        </div>


                                        <div class="container">
                                            <fieldset class="form-group">
                                                <!--<a href="javascript:void(0)" onclick="image_function();">Profile Image</a><span class="text-danger">*</span>-->
                                                <a href="javascript:void(0)" onclick="image_function();">Imágenes para mostrar (4 max. La primera será la de perfil)</a><span class="text-danger">*</span>
                                                
                                                <input type="file" id="pro-image" name="pro-image[]" style="display: none;" accept="image/png, image/jpeg" class="form-control" multiple>
                                            </fieldset>
                                            <div class="preview-images-zone">
                                            </div>
                                        </div>

                                        <br>
                                        <div class="form-group row">
                                            <!--<label class="col-sm-2 col-form-label">Phone Number</label>-->
                                            <label class="col-sm-2 col-form-label">teléfono</label>
                                            <div class="col-sm-10">
                                                <!--<input type="text" name="phone_number" value="{{old('phone_number')}}" class="form-control" placeholder="Write  Phone Number...">-->
                                                <input type="text" name="phone_number" value="{{old('phone_number')}}" class="form-control" placeholder="Escriba teléfono de contacto (Nunca será publicado)...">
                                            </div>
                                        </div>
        
                                        

                                        <div class="form-group green-border-focus">
                                            <!--<label for="description">Description (200 Charater Available)<span class="text-danger">*</span></label>-->
                                            <label for="description">Descripción<span class="text-danger">*</span></label>
                                            <textarea class="form-control" name="description" id="description" rows="2" maxlength="200">{{old('description')}}</textarea>
                                        </div>


                                        {{-- Woman alone --}}
                                        <div id = "she_alone" style="display: none">
                                            <!--<label class="col-sm-2 col-form-label">She:</label>-->
                                            <label class="col-sm-2 col-form-label">Ella:</label> 
                                            <div class="form-group row">
                                                <!--<label class="col-sm-1 col-form-label">Year:</label>-->
                                                <label class="col-sm-3 col-form-label">Año de nacimiento:</label>
                                                
                                                <input type="number" name="her_year" value="{{old('her_year')}}" id="her_year" class="form-control col-sm-1">

                                                <!--<label class="col-sm-2 col-form-label text-right">Preferences:</label>-->
                                                <label class="col-sm-2 col-form-label text-right">Preferencias:</label>
                                                
                                                <div class="custom-checkbox" style="margin-right:1rem;cursor:pointer;">
                                                    <input type="checkbox" class="col-control-input" id="her_hetero" name="her_hetero"  @if(old('her_hetero') == "1" )) checked @endif>
                                                    <label class="col-form-label" for="her_hetero">Hetero</label>
                                                </div>

                                                <div class="custom-checkbox" style="margin-right:1rem;cursor:pointer;">
                                                    <input type="checkbox" class="col-control-input" name="her_bi" id="her_bi" @if(old('her_bi') == "1" )) checked @endif>
                                                    <label class="col-form-label" for="her_bi">Bi</label>
                                                </div>

                                                <div class="custom-checkbox" style="margin-right:1rem;cursor:pointer;">
                                                    <input type="checkbox" class="col-control-input" name="her_testing" @if(old('her_testing') == "1" )) checked @endif>
                                                    <!--<label class="col-form-label" for="her_testing">Testing everything </label>-->
                                                    <label class="col-form-label" for="her_testing">Probando...</label>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        {{-- end of woman --}}

                                        {{-- Man alone --}}
                                        <div id = "he_alone" style="display: none">
                                            <label class="col-sm-2 col-form-label">EL:</label>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Año de nacimiento:</label>
                                                <input type="number" name="his_year" id="his_year" class="form-control col-sm-1" value="{{old('his_year')}}">

                                                <label class="col-sm-2 col-form-label text-right">Preferencias:</label>

                                                <div class="custom-checkbox" style="margin-right:1rem;cursor:pointer;">
                                                    <input type="checkbox" class="col-control-input" name="his_hetero" id="his_hetero" @if(old('his_hetero') == "1" )) checked @endif>
                                                    <label class="col-form-label">Hetero</label>
                                                </div>

                                                <div class="custom-checkbox" style="margin-right:1rem;cursor:pointer;">
                                                    <input type="checkbox" class="col-control-input" name="his_bi" id="his_bi" @if(old('his_bi') == "1" )) checked @endif> 
                                                    <label class="col-form-label">Bi</label>
                                                </div>

                                                <div class="custom-checkbox" style="margin-right:1rem;cursor:pointer;">
                                                    <input type="checkbox" class="col-control-input" name="his_testing" id="his_testing" @if(old('his_testing') == "1" )) checked @endif>
                                                    <label class="col-form-label">Probando...</label>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- end of Man --}}
                                        

                                        <!--<label class="col-form-label">Tags:(Select one or more)<span class="text-danger">*</span></label>-->
                                        <label class="col-form-label">Búscamos (Seleccionar una o más)<span class="text-danger">*</span></label>
                                        
                                        <div class="form-group row">
                                            @foreach($tags as $item)
                                            
                                            <div class="custom-checkbox" style="margin-right:1rem;cursor:pointer;">
                                                <!--<input type="checkbox" class="col-control-input" name="tags[]" value="{{$item->id}}" @if(is_array(old('tags')) && in_array($item->id, old('tags'))) checked @endif>-->
                                                <input type="checkbox" class="col-control-input" name="Buscamos[]" value="{{$item->id}}" @if(is_array(old('Buscamos')) && in_array($item->id, old('Buscamos'))) checked @endif>
                                                
                                                <label class="col-form-label">{{$item->name}}</label>
                                            </div>
                                            @endforeach
                                        </div>



                                        <!--<label class="col-form-label">Interests:(Select one or more)<span class="text-danger">*</span></label>-->
                                        <label class="col-form-label">Intereses (Seleccionar uno o más)<span class="text-danger">*</span></label>
                                        
                                        <div class="form-group row">
                                            @foreach($interests as $item)
                                            <div class="custom-checkbox" style="margin-right:1rem;cursor:pointer;">
                                                <!--<input type="checkbox" class="col-control-input" name="interests[]"  value="{{$item->id}}" @if(is_array(old('interests')) && in_array($item->id, old('interests'))) checked @endif>-->
                                                <input type="checkbox" class="col-control-input" name="Intereses[]"  value="{{$item->id}}" @if(is_array(old('Intereses')) && in_array($item->id, old('Intereses'))) checked @endif>
                                                <label class="col-form-label">{{$item->name}}</label>
                                            </div>
                                            @endforeach
                                        </div>


                                        <div class="form-group custom-checkbox" style="margin-right:1rem;cursor:pointer;margin-left:-1.5%;"> 
                                            <input type="checkbox"  class="col-control-input" name="terms" required>
                                            <a href="http://viajeswingers.com/terminosycondidiones.php" target="_blank">
                                                <label class="col-form-label" style="color:#2793db;cursor:pointer;">Acepto política de privacidad y condiciones del sistema.</label>
                                            </a>
                                        </div>

                                        <!--<div class="row">-->
                                        <!--    <div class="col-md-4"></div>-->
                                        <!--    <div class="form-group col-md-4">-->
                                        <!--        <div class="captcha">-->
                                        <!--            <span>{!! captcha_img() !!}</span>-->
                                        <!--            <button type="button" class="btn btn-success"  id="refresh"><i class="fa fa-refresh"></i></button>-->
                                        <!--        </div>-->
                                        <!--    </div>-->
                                        <!--</div>-->

                                        <!--<div class="row">-->
                                        <!--    <div class="col-md-4"></div>-->
                                        <!--    <div class="form-group col-md-4">-->
                                        <!--        <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha" name="captcha">-->
                                        <!--    </div>-->
                                        <!--</div>-->
                                        
                                        
                                        
                                        <div class="form-grou row">
                                            <div class="col-md-4 offset-md-4">
                                                <div class="g-recaptcha" data-sitekey="6LdVzIMUAAAAAPKQTZNDhEN5s6Al2BonnUFkHo4W"></div>
                                                @if($errors->has('g-recaptcha-response'))
                                                    <span class="invalid-feedback" style="display:block">
                                                        <strong>{{$errors->first('g-recaptcha-response')}}</strong>
                                                    </span>
                                                
                                                @endif
                                            </div>
                                        </div>
                                        
                                        
                                        
                                        
                                        <!--<div class="form-grou row">-->
                                        <!--    <div class="col-md-4 offset-md-4">-->
                                        <!--        <div class="g-recaptcha" data-sitekey="6LdVzIMUAAAAAPKQTZNDhEN5s6Al2BonnUFkHo4W">-->
                                        <!--            <div style="width: 304px; height: 78px;">-->
                                        <!--                <div>-->
                                        <!--                    <iframe src="https://www.google.com/recaptcha/api2/anchor?k=6LdOLRgTAAAAAPYECt9KLIL_LLwOuuuHAUw7QUTm&amp;co=aHR0cHM6Ly9jc3AtZXhwZXJpbWVudHMuYXBwc3BvdC5jb206NDQz&amp;hl=en&amp;v=r20160926121436&amp;size=normal&amp;cb=g72al0v10dxg" title="recaptcha widget" width="304" height="78" role="presentation" frameborder="0" scrolling="no" name="undefined"></iframe>-->
                                        <!--                </div>-->
                                        <!--                <textarea id="g-recaptcha-response" name="g-recaptcha-response" class="g-recaptcha-response" style="width: 250px; height: 40px; border: 1px solid #c1c1c1; margin: 10px 25px; padding: 0px; resize: none;  display: none; "></textarea>-->
                                        <!--            </div>-->
                                        <!--        </div>-->
                                        <!--   </div>-->
                                        <!--</div>-->
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        <br>
                                        
                                        
                                        

                                        <div class="form-group row">
                                            <div class="col-sm-12 text-center">
                                                <!--<button type="submit" id="registeruserbtn" class="btn btn-info btn-round">Register</button>-->
                                                <button type="submit" id="registeruserbtn" class="btn btn-info btn-round">Registrase</button>
                                                
                                                &nbsp;&nbsp;&nbsp;
                                                <!--<a href="/" class="btn btn-default btn-round">Cancel</a>-->
                                                <a href="/" class="btn btn-default btn-round">Cancelar</a>
                                                
                                            </div>
                                        </div>
                                    </form>





                                </div>

                                <div class="col-sm-1" style="follow:left;">
                                </div>
                            </div>
                        </div>
                    </div>
               </div>
            </div>

         </div>
         <div id="styleSelector"></div>
      </div>
   </div>
</div>


<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }); 

    $('#refresh').click(function(){
        console.log("captcha test");
        $.ajax({
            type:'GET',
            url:'{{ route('refresh.captcha')}}',
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            success:function(data){
                $(".captcha span").html(data.captcha);
            }
        });
    });
    
    $('input[type=radio][name=category]').on('change', function(){
        $("#his_year").val("");
        $("#his_hetero").attr("checked", false);
        $("#his_hetero").attr("checked", false);
        $("#his_bi").attr("checked", false);
        $("#his_testing").attr("checked", false);
        
        $("#her_year").val("");
        $("#her_hetero").attr("checked", false);
        $("#her_hetero").attr("checked", false);
        $("#her_bi").attr("checked", false);
        $("#her_testing").attr("checked", false);

        if($("#couple").prop("checked")){
            $("#he_alone").css("display", "block");
            $("#she_alone").css("display", "block");
        }
        
        if($("#man").prop("checked")){
            $("#he_alone").css("display", "block");
            $("#she_alone").css("display", "none");
        }
        
        if($("#woman").prop("checked")){
            $("#he_alone").css("display", "none");
            $("#she_alone").css("display", "block");
        }

    });


    function validateForm(){
        if(checkIfEmailInString($("#description").val())){
            alert("Email Not Allowed in description.");
            return false;
        }

        if(checkIfPhoneInString($("#description").val())){
            alert("Phone Not Allowed in description.");
            return false;
        }

        if($('#password').val() == $('#confirm_password').val()){
            console.log($('form'));
            // $('form').submit();
        }else{

            alert("Must be matched password and confirm password!");
            // console.log($("#pro-image").val());
            console.log($("terms").val());

            return false;
        }
    }

    function checkIfEmailInString(text) { 
        var re = /(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))/;
        return re.test(text);
    }

    function checkIfPhoneInString(text){
        var phoneExp = /(?:(?:\+?1\s*(?:[.-]\s*)?)?(?:\(\s*([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9])\s*\)|([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9]))\s*(?:[.-]\s*)?)?([2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]{2})\s*(?:[.-]\s*)?([0-9]{4})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?/img;
        return phoneExp.text(text);
    }


    function image_function(){
        var img_count = $(".preview-images-zone div").length/4;
        if(img_count == 4){
            alert("Over 4 Images!");
        }else{
            $('#pro-image').click();
        }
    }

    
    var formdata = new FormData();
    $("#pro-image").on("change", function(){
        var img_count = $(".preview-images-zone div").length/4;
        if(img_count == 4){
            alert("Over 4 Images!");
        }

        // length = document.getElementById("pro-image").files.length;
        // alert(length);

        // for(i=0; i<length; i++){
        //     //file = $("#pro-image").prop('files')[i];
        //     file = document.getElementById("pro-image").files[i];
        //     console.log(file);
        //     formdata.append("pro-image[]", file);
        // }

        // console.log(formdata);    

        // $.ajax({
        //     url: '{{ route('profile.upload') }}',
        //     type: "POST",
        //     data: formdata,
        //     contentType: false, // The content type used when sending data to the server.
        //     cache: false, // To unable request pages to be cached
        //     processData: false,
        //     success: function(res){

        //     }
        // })
    })
    
   
</script>
   

@stop
