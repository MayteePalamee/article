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
    <div class="card">
        <div class="card-body">
        <h3 class="card-title">Create<span class="badge badge-secondary">News</span></h3>
        <small id="emailHelp" class="form-text text-muted"><span style="color:green">*หากต้องการขึ้น paragraph ให้เพิ่ม @p หน้าข้อมความ</span></p></small>
            <form enctype="multipart/form-data"  method="post" action="{{url('/news/store')}}">
                @csrf
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="news-topic">หัวข้อข่าวสาร</label>
                            <textarea class="form-control" name="news-topic" rows="4" oninvalid="this.setCustomValidity('กรุณาระบุหัวข้อข่าวสาร!')" required></textarea>
                        </div> 
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="news-content">เนื้อหาข่าวสาร</label>
                            <textarea class="form-control" name="news-content" rows="10" oninvalid="this.setCustomValidity('กรุณาระบุรายละเอียดข่าวสาร!')" required></textarea >
                        </div>  
                    </div>  
                </div>            
                <div class="row">
                    <div class="col-12 col-img">
                        <!--<img id="news-topic-img" src="{{ asset('storage/gallery/icons8-picture-filled-480.png') }}" class="size-img"/>-->
                        <div id="topic-preview"></div>
                        <div class="form-group">
                            <label for="news-topic-image">รูปประกอบข่าวสาร</label>                            
                            <input name="news-topic-image" type="file" id="news-topic-image" required>
                        </div>
                    </div>  
                    <div class="col-12 col-img">
                        <div id="content-preview"></div>
                        <div class="form-group">
                            <label for="news-detail-image">รูปรายละเอียดประกอบข่าวสาร</label>
                            <!--<input name="news-detail-image" type="file" id="news-detail-image" multiple required> -->
                            <input name="news-detail-image[]" type="file" id="imageInput" required multiple>
                        </div>
                    </div>             
                </div>
                <div class="col">
                    <div class="text-right">
                        <input type="submit" value="เพิ่มข่าวสาร" class="btn btn-outline-primary"/>  
                    </div>  
                </div>               
            </form> 
        </div>
    </div>    
</div>        
@stop