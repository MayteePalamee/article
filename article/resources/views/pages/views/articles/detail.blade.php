@extends('layouts.view')
@section('content')
<div class="nav-text">
    <div class="row" style="height:100%">
        <div class="col d-flex justify-content-start d-flex align-items-center">
            @if(session('activeNews'))
                <div class="col-sm-3">News Detail</div> 
            @else 
                <div class="col-sm-3">Article Detial</div> 
            @endif
        </div>
        <div class="d-flex align-items-center">
            <div class="col justify-content-around">
                @if(session('activeNews'))
                    <div class="col">Home > News > News Detail</div> 
                @else 
                    <div class="col">Home > Article > Article Detial</div> 
                @endif
            </div>
        </div>
    </div>
</div>
    <div class="container">
        <!-- -->
        <div class="empty-box"></div>
        <!-- -->
        <div class="detail">
            <div class="card">
                <div class="card-body">
                @foreach($datas as $data)
                    <?php $topics = explode("@p",$data->topic);?>
                    <p><h3>{{$topics[0]}}</h3></p>
                    <p class='crop-detail text-center'><img src="{{ asset('/storage/gallery').'/'.$data->topic_picture}}"></p>
                    <!--not use @foreach($topics as $index => $topic) 
                        <p class="text-justify">@if($index > 0) {{$topic}} @endif</p>
                    @endforeach   -->                 
                    <?php $contents = explode("@p",$data->content);?>
                    <?php 
                        $images = explode(",",$data->content_picture);
                        if(sizeof($images) > 0){
                            unset($images[sizeof($images) -1]);
                        }   
                    ?>
                    <p class="text-justify">{{$contents[0]}}</p>
                    @foreach($images as $index => $image) 
                        <p class='crop-detail text-center'><img src="{{ asset('/storage/gallery').'/'.$image}}"></p>
                        <p class="text-justify">{{$contents[$loop->index]}}</p>
                    @endforeach
                @endforeach
                <hr>
                <small class="text-muted"><i class="far fa-clock"></i> 
                <?php
                    echo date("M jS, Y", strtotime($data->create_at)); 
                ?></small>
                </div>
            </div>
        </div>
        <!-- -->
        <div class="empty-box"></div>
        <!-- -->
    </div>
@stop