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
        $("#topic-preview img").remove();
        TopicImage(this,'div#topic-preview');
    });
    $("#content-image").change(function() {
        ContentImage(this,'div#content-preview');
    });
    $("#content-image-edit").change(function() {
        var contentToRemove = document.querySelectorAll("#content-preview");
        $(contentToRemove).remove(); 
        $( "#re-create" ).append( "<div id='content-preview'></div>" );
        ContentImage(this,'div#content-preview');
    });
});
/**list all article */
$(document).ready(function(){
    if($('#articleTarget').val()){
    $.ajax({
        url: "/article/select",
        type: "get",
        contentType: "application/json",
        success : function(response) { 
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
    var r = confirm("are you sure you want to delete article ?");
    if (r == true) {
        $.ajax({
            url: "/article/delete/"+id,
            type: "get",
            contentType: "application/json",
            success : function(response) { 
                if(response){  
                    location.reload();
                }
            }
        });
    } else {
        return false;
    }    
}

/**list all contact */
$(document).ready(function(){
    if($('#contactTarget').val()){
    $.ajax({
        url: "/contact/select",
        type: "get",
        contentType: "application/json",
        success : function(response) { 
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
    var r = confirm("are you sure you want to delete contact ?");
    if (r == true) {
        $.ajax({
            url: "/contact/delete/"+id,
            type: "get",
            contentType: "application/json",
            success : function(response) { 
                if(response){  
                    location.reload();
                }
            }
        });
    } else {
        return false;
    }    
}

/**on event del */
function ondelete(id){
    var r = confirm("are you sure you want to delete banner ?");
    if (r == true) {
        $.ajax({
            url: "/banner/delete/"+id,
            type: "get",
            contentType: "application/json",
            success : function(response) { 
                if(response){  
                    location.reload();
                }
            }
        });
    } else {
        return false;
    }    
}