// single images A preview in browser
function TopicImage(input, imagePreview) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $($.parseHTML('<img class="size-img">'))
            .attr('src', event.target.result).appendTo(imagePreview);
        }
    reader.readAsDataURL(input.files[0]);
    }
}
 // single images B preview in browser
 function ContentImage(input, imagePreview) {
    if (input.files) {
        var filesAmount = input.files.length;
        for (i = 0; i < filesAmount; i++) {
            var reader = new FileReader();
            reader.onload = function(event) {
                $($.parseHTML('<img class="size-img">'))
                    .attr('src', event.target.result).appendTo(imagePreview);
            }
            reader.readAsDataURL(input.files[i]);
        }
    }
}
$(document).ready(function(){
    $("#topic-image").change(function() {
        TopicImage(this,'div#topic-preview');
    });
    $("#content-image").change(function() {
        ContentImage(this,'div#content-preview');
    });
});
/**list all article */
$(document).ready(function(){
    if($('#articleTarget').val()){
    $('body').addClass('loading');
    $('h1').css('color','#ecd5c5');
    $.ajax({
        url: "/article/select",
        type: "get",
        contentType: "application/json",
        success : function(response) { 
            $('body').removeClass('loading');
            $('h1').css('color','#ecd5c5');
            if(response){    
                $('#article').bootstrapTable('load',{data : response});
            }
        }
    });

    setTimeout(function () {$("#article").bootstrapTable("hideLoading");}, 500);
}
});
/**Formatter table*/
function eidtArticleFormatter(value, row) {
    return "<a href='/article/edit/"+row.id+"'>edit</a>";
}

function deleteArticleFormatter(value, row) {
    return "<a href='javascript:void(0);' onclick='ondeleteArticle("+row.id+");'>delete</a>";
}

function ondeleteArticle(id){
    $('body').addClass('loading');
    $('h1').css('color','#ecd5c5');
    var r = confirm("are you sure you want to delete article ?");
    if (r == true) {
        $.ajax({
            url: "/article/delete/"+id,
            type: "get",
            contentType: "application/json",
            success : function(response) { 
                setTimeout(function(){
                    $('body').removeClass('loading');
                    $('h1').css('color','#ecd5c5');
                }, 500);
                if(response){  
                    location.reload();
                }
            }
        });
    } else {
        setTimeout(function(){
            $('body').removeClass('loading');
            $('h1').css('color','#ecd5c5');
        }, 500);
        return false;
    }    
}

/**list all contact */
$(document).ready(function(){
    if($('#contactTarget').val()){
    $('body').addClass('loading');
    $('h1').css('color','#ecd5c5');
    $.ajax({
        url: "/contact/select",
        type: "get",
        contentType: "application/json",
        success : function(response) { 
            $('body').removeClass('loading');
            $('h1').css('color','#ecd5c5');
            if(response){    
                $('#contact').bootstrapTable('load',{data : response});
            }
        }
    });

    setTimeout(function () {$("#contact").bootstrapTable("hideLoading");}, 500);
}
});
/**Formatter table*/
function eidtContactFormatter(value, row) {
    return "<a href='/contact/edit/"+row.id+"'>edit</a>";
}
function deleteContactFormatter(value, row) {
    return "<a href='javascript:void(0);' onclick='ondeleteContact("+row.id+");'>delete</a>";
}

function ondeleteContact(id){
    $('body').addClass('loading');
    $('h1').css('color','#ecd5c5');
    var r = confirm("are you sure you want to delete contact ?");
    if (r == true) {
        $.ajax({
            url: "/contact/delete/"+id,
            type: "get",
            contentType: "application/json",
            success : function(response) { 
                $('body').removeClass('loading');
                $('h1').css('color','#ecd5c5');
                if(response){  
                    location.reload();
                }
            }
        });
    } else {
        setTimeout(function(){
            $('body').removeClass('loading');
            $('h1').css('color','#ecd5c5');
        }, 500);
        return false;
    }    
}

/**on event del */
function ondelete(id){
    $('body').addClass('loading');
    $('h1').css('color','#ecd5c5');
    var r = confirm("are you sure you want to delete banner ?");
    if (r == true) {
        $.ajax({
            url: "/banner/delete/"+id,
            type: "get",
            contentType: "application/json",
            success : function(response) { 
                $('body').removeClass('loading');
                $('h1').css('color','#ecd5c5');
                if(response){  
                    location.reload();
                }
            }
        });
    } else {
        setTimeout(function(){
            $('body').removeClass('loading');
            $('h1').css('color','#ecd5c5');
        }, 500);
        return false;
    }    
}