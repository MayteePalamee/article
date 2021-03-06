@extends('layouts.default')
@section('content')
    <div class="container"> 
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
        <small id="emailHelp" class="form-text text-muted"><span style="color:red">*ระบุข้อมูลการติดต่อ สำหรับหน้าเว็บ contact</span></p></small>
        <h3 class="card-title">Create<span class="badge badge-secondary">Contact</span></h3>
        @foreach($contacts as $contact)
        <form enctype="multipart/form-data" method="post" action="{{url('/contact/update').'/'.$contact->id}}">
            @csrf               
            <div class="form-group row">  
                <label for="article-topic" class="col-sm-2 col-form-label">company-name</label>
                <div class="col-sm-9">                          
                    <input class="form-control" name="company" value="{{$contact->name}}" required  />
                </div>
            </div>
            <div class="form-group row">
                <label for="article-content" class="col-sm-2 col-form-label">address</label>
                <div class="col-sm-9">
                    <input class="form-control" name="address"  value="{{$contact->address}}"  required /> 
                </div>
            </div>
            <div class="form-group row">
                <label for="article-content" class="col-sm-2 col-form-label">tel.</label>
                <div class="col-sm-4">
                    <input class="form-control" name="tel" value="{{$contact->tel}}" required />
                </div>
                <label for="article-content" class="col-sm-1 col-form-label">email</label>
                <div class="col-sm-4">                            
                    <input class="form-control" name="email"  value="{{$contact->email}}"required />
                </div>
            </div>
            <div class="form-group row">
                <label for="article-content" class="col-sm-2 col-form-label">topic</label>
                <div class="col-sm-4">                        
                    <input class="form-control" name="topic"  value="{{$contact->topic}}" required />
                    <small id="emailHelp" class="form-text text-muted"><span style="color:red">*ระบุข้อมูลหัวข้อ สำหรับหน้าเว็บ contact</span></p></small>
                </div>
            </div>
            <div class="form-group row">
                <label for="article-content" class="col-sm-2 col-form-label">description</label>
                <div class="col-sm-6">     
                    <textarea class="form-control" name="description" rows="4"  required>{{$contact->description}}</textarea >
                    <small id="emailHelp" class="form-text text-muted"><span style="color:red">*ระบุข้อมูลรายละเอียด สำหรับหน้าเว็บ contact</span></p></small>
                </div>
            </div> 
            <div class="form-group row">
                <label for="article-content" class="col-sm-2 col-form-label">longitude.</label>
                <div class="col-sm-4">
                    <input class="form-control" name="longitude" value="{{$contact->longitude}}"/>
                </div>
                <label for="article-content" class="col-sm-1 col-form-label">latitude</label>
                <div class="col-sm-4">                            
                    <input class="form-control" name="latitude" value="{{$contact->latitude}}"/>
                </div>
            </div>
            @endforeach
            <div class="form-group">
                <div class="col-sm-5">
                    <div class="text-center">
                        <input type="submit" value="บันทึก" class="btn btn-outline-primary"/>  
                    </div>  
                </div> 
            </div>   
            </form>
        </div>
    </div> 
</div>
@stop