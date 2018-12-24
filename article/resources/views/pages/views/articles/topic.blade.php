@extends('layouts.view')
@section('content')
<div class="nav-text">
    <div class="row" style="height:100%">
        <div class="col d-flex justify-content-start d-flex align-items-center">
            @if(session('activeNews'))
                <div class="col-sm-3">All News</div> 
            @else 
                <div class="col-sm-3">All Article</div> 
            @endif
        </div>
        <div class="d-flex align-items-center">
            <div class="col justify-content-around">
                @if(session('activeNews'))
                    <div class="col">Home > News > All News</div> 
                @else 
                    <div class="col">Home > Article > All Article</div> 
                @endif
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="container">
        <!-- -->
        <div class="empty-box"></div>
        <!-- -->
        <div class="list">
        <div class="card">
            <div class="card-body">
                <input type="hidden" id="active" value="@if(session('activeArticle')) {{session('activeArticle')}} @else {{session('activeNews')}} @endif"/>
                <div id="toolbar"><h3>@if($hnews) {{$hnews}} @else {{$harticle}} @endif</h3></div>
                <table class="table" id="list-content"  data-toolbar="#toolbar"
                    data-toggle="table" 
                    data-pagination = "true"
                    data-page-size="10"
                    data-search="true"
                    data-searchable ="false">
                        <thead>
                            <tr>
                                <th data-formatter="viewsCardFormatter"></th>
                                <th data-field="topic" data-visible="false"></th>
                                <th data-field="content" data-visible="false"></th>
                                <th data-field="create_at" data-formatter="convertDateFormatter" data-visible="false"></th>
                            </tr>
                        </thead>
                    </table>
            </div>
        </div>
        </div>
    </div>
</div>
@stop