@extends('layouts.view')
@section('content')
<!-- Carousal -->
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">    
   @foreach($carousels as $carousel) 
    <div class="carousel-item @if($loop->index == 0) active @endif">
      <img class="d-block w-100" src="{{ asset('storage/gallery/').'/'.$carousel->carousel_picture }}" alt="First slide">
    </div>
    @endforeach
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
<!-- -->
<div class="col-md-12 empty-box"></div>
<!-- News -->
<div class="container-fluid">
    <div class="container"> 
        <!-- container --> 
        <div class="row">
            @if($news)
                <div class="col-5">
                    <h2 class="card-title">News</h2>
                </div>
                <div class="col-5">
                    <button type="button" class="btn btn-secondary btn-sm views" id="view-news">View All</button>
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col-10">
                <div class="row">
                    <div class="card-group">
                        @foreach($news as $new)
                        <div class="col-4">
                            <div class="card">
                                <div class="crop">
                                    <img src="{{asset('storage/gallery/'.'/'.$new->topic_picture)}}" alt="">
                                </div>
                                <div class="card-contant">
                                    <?php $sp = explode("@p",$new->topic);?>
                                    <h5 class="card-title view-text">{{$sp[0]}}</h5>
                                    <p class="card-text view-card">{{$new->content}}</p>
                                </div>
                                <div class="card-footer">
                                    <div class="row d-flex align-items-center">
                                        <div class="col">
                                            <small class="text-muted d-flex align-items-center"><i class="far fa-clock"></i>           
                                            <div style="padding-left:5px;">
                                                <?php
                                                    echo date("M jS, Y", strtotime($new->create_at)); 
                                                ?>
                                            </div>
                                            </small>
                                        </div>
                                        <div class="col">
                                            <a href="javascript:void(0)" class="badge badge-pill badge-secondary" onClick="seeMore({{$new->id}},{{$new->type}})">See more</a>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- -->
    <div class="col-md-12 empty-box"></div>
    <!-- -->
    <div class="container-fluid" style="background-color: #eaeaea; color: black; padding-top: 30px;">
    <div class="container"> 
        <div class="row">
            @if($articles)
                <div class="col-10">
                    <h2 class="card-title">Articale</h2>
                </div>
                <div class="col-10 text-center">
                    <p>The goal of this document is to give you a good, high-level overview of how the Laravel
                     framework works. By getting to know the overall framework better, everything feels less 
                     "magical" and you will be more confident building your applications. If you don't understand 
                     all of the terms right away, don't lose heart! Just try to get a basic grasp of 
                     what is going on, and your knowledge will grow as you explore other sections of the 
                     documentation.</p>
                </div>
                <div class="col-10 mb-3">
                    <button type="button" class="btn btn-secondary btn-sm views" id="view-article">View All</button>
                </div>
            @endif
        </div>           
        <div class="row">
            <div class="col-10">
                <div class="row">
                    <div class="card-group">
                        @foreach($articles as $article)
                        <div class="col-4">
                            <div class="card">
                                <div class="crop">
                                    <img src="{{asset('storage/gallery/'.'/'.$article->topic_picture)}}" alt="">
                                </div>
                                <div class="card-contant">
                                    <?php $sc = explode("@p",$article->topic);?>
                                    <h5 class="card-title view-text">{{$sc[0]}}</h5>
                                    <p class="card-text view-card">{{$article->content}}</p>
                                </div>
                                <div class="card-footer">
                                    <div class="row d-flex align-items-center">
                                        <div class="col">
                                            <small class="text-muted d-flex align-items-center"><i class="far fa-clock"></i> 
                                                <div style="padding-left:5px;">
                                                    <?php
                                                        echo date("M jS, Y", strtotime($article->create_at)); 
                                                    ?>
                                                </div>
                                            </small>
                                        </div>
                                        <div class="col">
                                            <a href="javascript:void(0)" class="badge badge-pill badge-secondary" onClick="seeMore({{$article->id}},{{$article->type}})">See more</a>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    <!-- container -->
    </div>
</div>
@stop