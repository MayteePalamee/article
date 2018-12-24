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
    <h1> Article Management!</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">ติดต่อ<span class="badge badge-secondary">Contact</span></h5>
            <p class="card-text"><small class="text-muted">* หากท่านต้องการเพิ่มข้อมูลติดต่อ กดปุ่ม "contact"</small></p>
            <a href="/contact/create" class="btn btn-outline-info">contact</a>
        </div>     
        <div class="card-body">
            <input type="hidden" id="contactTarget" value="@if($contactTarget) {{$contactTarget}} @endif"/>
        <table class="table table-hover" id="contact" 
            data-toggle="table" 
            data-pagination = "true" >
                <thead>
                    <tr>
                        <th data-field="name">company</th>
                        <th data-field="email">email</th>
                        <th data-field="tel">tel</th>
                        <th data-field="address">address</th>
                        <th data-field="longitude">longitude</th>
                        <th data-field="latitude">latitude</th>
                        <th data-formatter="eidtContactFormatter" data-align="right" data-width="100px"></th>
                        <th data-formatter="deleteContactFormatter" data-align="right" data-width="100px"></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>   
    </div>
@stop