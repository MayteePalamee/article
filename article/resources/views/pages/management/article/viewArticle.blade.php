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
            <h3 class="card-title">Manage<span class="badge badge-secondary">Article</span></h3>
            <p class="card-text"><small class="text-muted">* หากท่านต้องการเพิ่มบทความ กดปุ่ม "เพิ่มบทความ"</small></p>
            <a href="/article/create" class="btn btn-outline-info">เพิ่มบทความ</a>
        </div>     
        <div class="card-body">
        <input type="hidden" id="articleTarget" value="@if($articleTarget) {{$articleTarget}} @endif"/>
        <table class="table table-hover" id="article" 
            data-toggle="table" 
            data-pagination = "true"
            data-page-size="5">
                <thead>
                    <tr>
                        <th data-field="topic" data-width="30%">หัวข้อ</th>
                        <th data-field="content" data-width="60%">เนื้อหา</th>
                        <th data-formatter="eidtArticleFormatter" data-align="right" data-width="100px"></th>
                        <th data-formatter="deleteArticleFormatter" data-align="right" data-width="100px"></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>   
</div>        
@stop