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
        <h3 class="card-title">Create<span class="badge badge-secondary">Article</span></h3>
        <small id="emailHelp" class="form-text text-muted"><span style="color:green">*หากต้องการขึ้น paragraph ให้เพิ่ม @p หน้าข้อมความ</span></p></small>
            <form enctype="multipart/form-data" method="post" action="{{url('/article/store')}}">
                @csrf
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="article-topic">หัวข้อบทความ</label>
                            <textarea class="form-control" name="article-topic" rows="4" oninvalid="this.setCustomValidity('กรุณาระบุหัวข้อบทความ!')" required> </textarea>
                        </div>
                    </div>  
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="article-content">เนื้อหาบทความ</label>
                            <textarea class="form-control" name="article-content" rows="10" oninvalid="this.setCustomValidity('กรุณาระบุเนื้อหาบทความบทความ!')" required></textarea >
                        </div>
                    </div>               
                </div> 
                <div class="row">
                    <div class="col-12 col-img">
                        <div id="topic-preview"></div>
                        <div class="form-group">
                            <label for="topic-image">รูปประกอบบทความ</label>
                            <input name="topic-image" type="file" id="topic-image" required>
                        </div>
                    </div>  
                    <div class="col-12 col-img">
                        <div id="content-preview"></div>
                        <div class="form-group">
                            <label for="content-image">รูปรายละเอียดประกอบบทความ</label>
                            <input name="content-image[]" type="file" id="content-image" required multiple>
                        </div>
                    </div>             
                </div>
                <div class="col">
                    <div class="text-right">
                        <input type="submit" value="เพิ่มบทความ" class="btn btn-outline-primary"/>  
                    </div>  
                </div>   
            </form>
        </div>
    </div>               
</div>        
@stop