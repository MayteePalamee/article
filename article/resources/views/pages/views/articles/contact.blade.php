@extends('layouts.view')
@section('content')
<div class="nav-text">
    <div class="row" style="height:100%">
        <div class="col d-flex justify-content-start d-flex align-items-center">
            <div class="col-sm-3">Contact</div> 
        </div>
        <div class="d-flex align-items-center">
            <div class="col justify-content-around">
                <div class="col">Home > Contact</div> 
            </div>
        </div>
    </div>
</div>
    <div class="container">
        @if(session('mail-success'))
        <div class="alert alert-success" id="response">
            {{ session('mail-success') }}
        </div>
        @endif
        @if(session('mail-error'))
        <div class="alert alert-danger" id="response">
            {{ session('mail-error') }}
        </div>
        @endif
        <input type="hidden" id="mapload" value="@if(session('onload')) {{session('onload')}} @endif"/>
        <div class="contact">
            <div class="row justify-content-md-center">
                @foreach($data as $val)
                <div class="text-center col-sm-8">
                    <p><h3>{{$val->topic}}</h3></p>
                    <p>{{$val->description}}</p>
                </div>
                <input type="hidden" id="longitude" value="{{$val->longitude}}"/>
                <input type="hidden" id="latitude" value="{{$val->latitude}}"/>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Map-->
    <div id="map_canvas" style="width: 100%; height: 400px;"></div>
    <!-- -->
    <div class="container">
    <div class="contact">
        <div class="empty-box"></div>
        <div class="row">
            @foreach($data as $val)
            <div class="col-md-4">
                <p class="d-flex align-items-center"><h3>{{$val->name}}</h3></p>
                <p class="d-flex align-items-center">
                    <i class="fas fa-map-marker-alt contact-icon"></i>
                    <span class='space'><strong>{{$val->address}}</strong></span>
                </p>
                <p class="d-flex align-items-center">
                    <i class="fas fa-phone contact-icon"></i>
                    <span class='space'><strong>{{$val->tel}}</strong></span>
                </p>
                <p class="d-flex align-items-center">
                    <i class="fas fa-envelope contact-icon"></i>
                    <span class='space'><strong>{{$val->email}}</strong></span>
                </p>
            </div>
            @endforeach
            <div class="col-md-8 company">
                <form action="/mail" method="post" id="send-mail">
                @csrf
                    <div class="row">
                        <div class="col">
                            <div class="form-group mb-2">
                                <input type="text" placeholder="*Name" data-toggle="popover" data-trigger="focus" data-content="name is required."
                                class="form-control form-control-sm" id="contact-name" name="contact-name"/>
                            </div>
                            <div class="form-group mb-2">
                                <input type="text" placeholder="*Email"  data-toggle="popover" data-trigger="focus" data-content="email address invalid format"  
                                class="form-control form-control-sm" id="contact-email" name="contact-email" />
                            </div>
                            <div class="form-group mb-2">
                                <input type="text" placeholder="*Phone Number" data-toggle="popover" data-trigger="focus" data-content="phone number invalid format"
                                class="form-control form-control-sm" id="contact-tel" name="contact-tel"/>
                            </div>
                        </div>
                        <div class="col">
                            <textarea class="form-control" placeholder="*Message" data-toggle="popover" data-trigger="focus" data-content="message is required."
                            id="contact-message" name="contact-message" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col d-flex justify-content-end">
                            <a herf="javascript:void(0)" class="btn btn-md btn-secondary" id="mail">Send</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@stop