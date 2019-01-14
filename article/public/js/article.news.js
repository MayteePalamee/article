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
        $("#topic-preview img").remove();
        NewsTopicImage(this, 'div#topic-preview');
    });
    $("#imageInput").change(function() {
        NewsContentImage(this, 'div#content-preview');
    });

    $("#news-detail-image").change(function() {
        var contentToRemove = document.querySelectorAll("#preview-edit-content");
        $(contentToRemove).remove(); 
        $( "#re-create" ).append( "<div id='preview-edit-content'></div>" );
        ContentImage(this,'div#preview-edit-content');
    });
});

$(document).ready(function(){
    if($('#newsTarget').val()){
    $.ajax({
        url: "/news/select",
        type: "get",
        contentType: "application/json",
        success : function(response) { 
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
    var r = confirm("are you sure you want to delete news ?");
    if (r == true) {
        $.ajax({
            url: "/news/delete/"+id,
            type: "get",
            contentType: "application/json",
            success : function(response) { 
                if(response){  
                    location.href = "/news/view";
                }
            }
        });
    } else {
        return false;
    }    
}

$(document).ready(function() {
    setTimeout(function(){
        $('#response').hide();
    }, 5000);
});
/**Tab */