@extends('layouts.default')
@section('content')
<div class="container">
    <!-- message from controller-->
    @if ($errors->any())
        <div class="alert alert-danger" id="response">
            {{ implode('', $errors->all()) }}
        </div>
    @endif 
    @if (session('status'))
    <div class="alert alert-success" id="response"> 
        {{ session('status') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger" id="response">
        {{ session('error') }}
    </div>
    @endif
    <div class="alert alert-danger" id="valid">*You can only upload a maximum of 3 files</div>
    <div class="card">
        <div class="card-body">
            <h3 class="card-title">Banner<span class="badge badge-secondary">Adding</span></h3>
            <div class="col">
                <div id="gallery"></div>
            </div>            
        </div>
        <div class="card-body">
            <form enctype="multipart/form-data" method="post" action="{{url('/banner/banner')}}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="imageInput">รูปภาพ Banner</label>
                    <input name="carousel[]" type="file" id="imageInput" multiple required>
                </div>
                <div class="col">
                    <div class="form-group">
                        <input type="submit" value="เพิ่ม Banner" class="btn btn-outline-primary"/>  
                    </div>  
                </div> 
            </form>
        </div>
        
        <div class="card-body">
        <input type="hidden" id="bannerTarget" value="@if($carousels) {{$carousels}} @endif"/>
        <table class="table table-hover" id="banner" 
            data-toggle="table" 
            data-pagination = "true"
            data-page-size="3">
                <thead>
                    <tr>
                        <th data-formatter="viewbannerFormatter"></th>
                        <th data-formatter="deleteBannerFormatter" data-align="right" data-width="100px"></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>  
</div>

@stop

