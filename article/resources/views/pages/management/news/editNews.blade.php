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
        <h3 class="card-title">Editing<span class="badge badge-secondary">News</span></h3>
        <small id="emailHelp" class="form-text text-muted"><span style="color:green">*หากต้องการขึ้น paragraph ให้เพิ่ม @p หน้าข้อมความ</span></p></small>
            @foreach ($news as $new)
            <form enctype="multipart/form-data" method="post" action="{{url('/news/replace/').'/'.$new->id}}">
                @csrf
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="news-topic">หัวข้อข่าวสาร</label>
                            <textarea class="form-control" name="news-topic" rows="4"oninvalid="this.setCustomValidity('กรุณาระบุหัวข้อข่าว!')" required>{{$new->topic}}</textarea>
                        </div> 
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="news-content">เนื้อหาข่าวสาร</label>
                            <textarea class="form-control" name="news-content" rows="10" oninvalid="this.setCustomValidity('กรุณาระบุรายละเอียดข่าว!')" required>{{$new->content}}</textarea >
                        </div>
                    </div>   
                </div>
                <div class="row">
                    <div class="col-12 col-img">
                        <img id="news-topic-img" src="{{ asset('storage/gallery/').'/'.$new->topic_picture }}" class="size-img"/>
                        <input type="hidden" name="topic-image-temp" value="{{$new->topic_picture}}"/>
                        <div class="form-group">
                            <label for="news-topic-image">รูปประกอบข่าวสาร</label>                            
                            <input name="news-topic-image" type="file" id="news-topic-image">
                        </div>
                    </div>  
                        <div class="col-12 col-img">
                        @foreach($imageContent as $images)
                            @foreach($images as $image)
                                <img id="detail-news-img" src="{{ asset('storage/gallery/').'/'.$image }}" class="size-img"/>
                                <input type="hidden" name="content-image-temp[]" value="{{$image}}"/>
                            @endforeach  
                        @endforeach    
                            <div class="form-group">
                                <label for="news-detail-image">รูปรายละเอียดประกอบข่าวสาร</label>
                                <input name="news-detail-image" type="file" id="news-detail-image">
                            </div>
                        </div>                                
                </div>
                <div class="col">
                    <div class="text-right">
                        <input type="submit" value="บันทึก" class="btn btn-outline-primary"/>  
                    </div>  
                </div>               
            </form> 
            @endforeach              
        </div>
    </div>    
</div>        
@stop