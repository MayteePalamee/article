/**view image news */
// single images A preview in browser
function NewsTopicImage(input,ImagePreview) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $($.parseHTML('<img class="size-img">'))
            .attr('src', event.target.result).appendTo(ImagePreview);
        }
    reader.readAsDataURL(input.files[0]);
    }
}
 // single images B preview in browser
 function NewsContentImage(input, ImagePreview) {
    if (input.files) {
        var filesAmount = input.files.length;
        for (i = 0; i < filesAmount; i++) {
            var reader = new FileReader();
            reader.onload = function(event) {
                $($.parseHTML('<img class="size-img">'))
                    .attr('src', event.target.result).appendTo(ImagePreview);
            }
            reader.readAsDataURL(input.files[i]);
        }
    }
}
$(document).ready(function(){
    $("#news-topic-image").change(function() {
        NewsTopicImage(this, 'div#topic-preview');
    });
    $("#imageInput").change(function() {
        NewsContentImage(this, 'div#content-preview');
    });
});

$(document).ready(function(){
    if($('#newsTarget').val()){
        $('body').addClass('loading');
        $('h1').css('color','#ecd5c5');
    $.ajax({
        url: "/news/select",
        type: "get",
        contentType: "application/json",
        success : function(response) { 
            $('body').removeClass('loading');
            $('h1').css('color','#ecd5c5');
            if(response){    
                $('#news').bootstrapTable('load',{data : response});
            }
        }
    });

    setTimeout(function () {$("#news").bootstrapTable("hideLoading");}, 500);
}
});
/**Formatter table*/
function eidtFormatter(value, row) {
    return "<a href='/news/edit/"+row.id+"'>edit</a>";
}
function deleteFormatter(value, row) {
    //return "<a href='/news/delete/"+row.id+"'>delete</a>";
    return "<a href='javascript:void(0);' onclick='ondeleteNews("+row.id+");'>delete</a>";
}

function ondeleteNews(id){
    $('body').addClass('loading');
    $('h1').css('color','#ecd5c5');
    var r = confirm("are you sure you want to delete news ?");
    if (r == true) {
        $.ajax({
            url: "/news/delete/"+id,
            type: "get",
            contentType: "application/json",
            success : function(response) { 
                $('body').removeClass('loading');
                $('h1').css('color','#ecd5c5');
                if(response){  
                    location.href = "/news/view";
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

$(document).ready(function() {
    setTimeout(function(){
        $('#response').hide();
    }, 5000);
});
/**Tab */

/**loading.. */
$(document).ready(function() {
    var bodyClasses = document.querySelector('body').className;
    var myClass = new RegExp("loading");
    var trueOrFalse = myClass.test( bodyClasses );
    setTimeout(function(){
        $('body').removeClass('loading');
        $('h1').css('color','#ecd5c5');
    }, 1000);
});

$( window ).on("load", function() {
    setTimeout(function(){
        $('body').addClass('loading');
        $('h1').css('color','#ecd5c5');
    }, 100);
});