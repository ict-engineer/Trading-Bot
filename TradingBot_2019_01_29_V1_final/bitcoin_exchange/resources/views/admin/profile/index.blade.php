@extends('layouts/admin')
@section('admin-content')
@include('admin/common/side')

<div class="pcoded-content">
   <div class="pcoded-inner-content">
      <div class="main-body">
         <div class="page-wrapper">
            <div class="page-header">
               <div class="page-header-title">
                  <h3>Perfil de usuario</h3>
               </div>
               <div class="page-header-breadcrumb">
                  <ul class="breadcrumb-title">
                     <li class="breadcrumb-item">
                        <a href="{{route('admin.dashboard')}}">
                        <i class="icofont icofont-home"></i>
                        </a>
                     </li>
                  </ul>
               </div>
            </div>
            <div class="page-body">
               <div class="row">

                <div class="col-sm-12">

                    <div class="card">
                        <div class="card-header table-card-header">
                            <div class="row">
                                <div class="col-sm-9 text-left">
                                    <h5>User Profile</h5>
                                </div>
                                <div class="col-sm-3 text-right">
                                    <span class="text-danger">(*) Necessary Field.</span>
                                </div>
                            </div>
                        </div>

                        <div class="card-block">

                            <br>

                            @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <!--<strong>Whoops!</strong> There were some problems with your input.<br><br>-->
                                <strong>Ooops !</strong>  There are some errors.<br><br>
                                <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                                </ul>
                            </div>
                            @endif

                            @if(session('success'))
                                <div class="alert alert-success">
                                {{ session('success') }}
                                    {{-- <span id='close' onclick='this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode); return false;'>x</span> --}}
                                </div>
                            @endif

                            @if(session('warning'))
                                <div class="alert alert-warning">
                                    {{ session('warning') }}
                                    {{-- <span id='close' onclick='this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode); return false;'>x</span> --}}
                                </div>
                            @endif

                            <div class="row" style="follow:left;">
                                <div class="col-sm-1" style="follow:left;">
                                </div>

                                <div class="col-sm-10" style="follow:left">

                                    <form method="POST" action="{{url('admin/profile')}}" onsubmit="return validateForm();" accept-charset="UTF-8" class="form-horizontal bordered" role="form" enctype="multipart/form-data">
                                            {{ csrf_field() }}


                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Email<span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="email" name="email" id="email" value="{{$user->email}}" class="form-control" placeholder="email...">
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Password<span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="password" name="password" id="password" class="form-control" placeholder="password...">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Confirm Password<span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirme contraseña...">
                                            </div>
                                        </div>


                                        <br>


                                        <div class="form-group row">
                                            <div class="col-sm-12 text-center">
                                                <button type="submit" id="updateuserbtn" class="btn btn-info btn-round">Update</button>
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

        $(document).on('change', '#country', function(){

                $.ajax({
                    type:"POST",
                    url: "/admin/getCity/" + $(this).val() ,
                    success: function(result){
                        if(result.status == '1'){
                            //console.log(result.data);
                            var html = "<option value=''>Select State</option>";
                            for(var i = 0; i < result.data.length; i++){
                                var item = result.data[i];

                                html += "<option value='" + item.id + "'>";
                                html += item.name + "</option>";
                            }
                            $('select[name=\'city\']').html(html);

                        }else{
                            //console.log("Connect Error!");
                        }
                    }
                });
        });



        function validateForm(){

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
    </script>

@stop
