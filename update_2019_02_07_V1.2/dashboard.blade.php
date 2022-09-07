@extends('layouts/admin')
@section('admin-content')
@include('admin/common/side')
<link rel="stylesheet" href="{{asset('admin_assets/assets/css/customSelect.css')}}">


<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{asset('admin_assets/assets/css/select2-bootstrap4.min.css')}}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<div class="pcoded-content">
   <div class="pcoded-inner-content">
      <div class="main-body">
         <div class="page-wrapper">
            <div class="page-header">
               <div class="page-header-title">
                  <h4>Dashboard</h4>
               </div>
               <div class="page-header-breadcrumb">
                  <ul class="breadcrumb-title">
                     <li class="breadcrumb-item">
                        <a href="{{route('admin.dashboard')}}">
                        <i class="icofont icofont-home"></i>
                        </a>
                     </li>
                     <li class="breadcrumb-item"><a href="#!">Pages</a></li>
                     <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                  </ul>
               </div>
            </div>
            <div class="page-body">
                <div class="card">
                    <div class="exchangeBtnArea">
                        <button id="exchangeAddBtn">Add Exchange</button>
                        <button id="runAllBtn">Run All</button>
                        <button id="runReal">Real Time</button>

                        <br>
                        <span class="label profitArea">0</span>
                    </div>

                    <div id="exchanges">

                    </div>
                </div>
            </div>

         </div>
         <div id="styleSelector"></div>
      </div>
   </div>
</div>
<script src="{{asset('admin_assets/assets/js/orderbooktable.js')}}"
@stop
