@extends('layouts.default')
@section('content')
    <div class="container">
            <!-- message from controller-->
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
                    <h3 class="card-title">Manage<span class="badge badge-secondary">News</span></h3>
                    <p class="card-text"><small class="text-muted">* หากท่านต้องการเพิ่มข่าวสาร กดปุ่ม "เพิ่มข่าวสาร"</small></p>
                    <a href="/news/create" class="btn btn-outline-info">เพิ่มข่าวสาร</a>
                </div>     
                <div class="card-body">
                    <input type="hidden" id="newsTarget" value="@if($newsTarget) {{$newsTarget}} @endif"/>
                <table class="table table-hover" id="news" 
                    data-toggle="table" 
                    data-pagination = "true"
                    data-page-size="5">
                        <thead>
                            <tr>
                                <th data-field="topic" data-width="30%">หัวข้อ</th>
                                <th data-field="content" data-width="60%">เนื้อหา</th>
                                <th data-formatter="eidtFormatter" data-align="right" data-width="100px"></th>
                                <th data-formatter="deleteFormatter" data-align="right" data-width="100px"></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>   
    </div>
@stop