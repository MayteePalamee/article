/**loading.. */
/*$( window ).on("load", function() {
    setTimeout(function(){
        $('body').addClass('loading');
        $('h1').css('color','#ecd5c5');
    }, 100);
});

$(document).ready(function() {
    setTimeout(function(){
        $('body').removeClass('loading');
        $('h1').css('color','#ecd5c5');
    }, 1000);
});*/

$(document).ready(function(){
    $("#view-news").on('click', function(){
        location.href = '/views/news';
    });
});

$(document).ready(function(){
    $("#view-article").on('click', function(){
        location.href = '/views/articale';
    });
});
/**views list news page */
$(document).ready(function(){
    if($("#active").val()){
    if($("#active").val().trim() ==='active-news'){
        $.ajax({
            url: "/views/listnews",
            type: "get",
            contentType: "application/json",
            success : function(response) { 
                if(response){  
                    $('#list-content').bootstrapTable('load',{data : response});
                }
            }
        });        
    }
}
setTimeout(function () {$("#list-content").bootstrapTable("hideLoading");}, 100);
});
/**views list news page */
$(document).ready(function(){
    if($("#active").val()){
    if($("#active").val().trim() ==='active-article'){
        $.ajax({
            url: "/views/listarticale",
            type: "get",
            contentType: "application/json",
            success : function(response) { 
                if(response){  
                    $('#list-content').bootstrapTable('load',{data : response});
                }
            }
        });        
    }
}
setTimeout(function () {$("#list-content").bootstrapTable("hideLoading");}, 100);
});
/**ui search */
$(document).ready(function(){
    $(".bootstrap-table .search").addClass('col-sm-5');
});

/**Formatter table*/
function convertDateFormatter(value,row){
    var options = { year: 'numeric', month: 'short', day: 'numeric' };
    var mydate = new Date(row.create_at);
    return  mydate.toLocaleString('en-EN', options);
}
function viewsCardFormatter(value, row) {
    var options = { year: 'numeric', month: 'short', day: 'numeric' };
    var mydate = new Date(row.create_at);
    var topics = row.topic.split("@p");
    var contents = row.content.split("@p");
    return "<div class='card'>" +
                "<div class='card-body'>" +
                        "<div class='row'>"+
                            "<div class='col-sm-3'>"+
                                "<div class='crop-list'><img src='"+window.location.origin+'/storage/gallery/'+row.topic_picture+"'></div>" +
                            "</div>"+
                            "<div class='col-sm'>"+
                                "<h5><strong>"+topics[0]+"</strong></h5> <hr>"+
                                "<p class='text-justify'>"+contents[0]+"</p>"+
                                "<div class='row'>"+
                                    "<div class='col'>"+
                                        "<small class='text-muted'><i class='far fa-clock'></i>      "+ 
                                        mydate.toLocaleString('en-EN', options)+ 
                                        "</small>"+
                                        "<button type='button' class='btn btn-secondary btn-sm views' id='seeMore' onClick='seeMore("+ row.id+","+row.type +")'>See more</button>"+
                                    "</div>"+
                                "</div>"+
                            "</div>"+
                        "<div>"+
                "</div>"+
           "</div>";
}

function seeMore(id,type){
    if(type === 0){
        location.href = '/views/articale/detail/'+id;
    }else{
        location.href = '/views/news/detail/'+id;
    }
}
function initMap() {
    var map;
    var longitude = $("#longitude").val() ? $("#longitude").val() : 98.977357 ;
     var latitude = $("#latitude").val() ? $("#latitude").val() : 18.807969 ;
    map = new google.maps.Map(document.getElementById('map_canvas'), {
    center: {lat: parseInt(latitude), lng: parseInt(longitude)},
    zoom: 15
    });

     // init markers
     var marker = new google.maps.Marker({
        position: new google.maps.LatLng(latitude, longitude),
        map: map,
        title: 'we here '
    });

    // process multiple info windows
    (function(marker) {
        // add click event
        google.maps.event.addListener(marker, 'click', function() {
            infowindow = new google.maps.InfoWindow({
                content: 'Article!!'
            });
            infowindow.open(map, marker);
        });
    })(marker);
}

$(document).ready(function(){
    $("#mail").on('click', function(){
        var name = $("#contact-name").val();
        var email = $("#contact-email").val();
        var num = $("#contact-tel").val();
        var message = $("#contact-message").val();
        
        if(name == ""){ 
            $('#contact-name').popover({
                trigger: 'focus'
            });
            $('#contact-name').focus();
            return false;
        }else if(!validateEmail(email)){ 
            $('#contact-email').popover({
                trigger: 'focus'
            });
            $('#contact-email').focus();
            return false;
        }else if(!validateNumber(num)){ 
            $('#contact-tel').popover({
                trigger: 'focus'
            });
            $('#contact-tel').focus();
            return false;
        }else if(message === ""){
            $('#contact-message').popover({
                trigger: 'focus'
            });
            $('#contact-message').focus();
            return false;
        }
        else{     
            document.getElementById("send-mail").submit();      
        }
        return false;
    });
});

$(document).ready(function() {
    setTimeout(function(){
        $('#response').hide();
    }, 5000);
});

function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function validateNumber(num){
    var number = /^[0-9]*$/gm;
    return number.test(num);
}