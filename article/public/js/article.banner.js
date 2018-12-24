 // Multiple images preview in browser
 $(function() {
    var imagesPreview = function(input, placeToInsertImagePreview) {
        if (input.files) {
            var filesAmount = input.files.length;
            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    $($.parseHTML('<img class="size-img">'))
                        .attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                }
                reader.readAsDataURL(input.files[i]);
            }
        }
    };
    $('#imageInput').on('change', function() {
        imagesPreview(this, 'div#gallery');
    });
});

$(document).ready(function(){
    $('div#valid').hide();
    $("input[type='submit']").click(function(){
        var $fileUpload = $("input[type='file']");
        if (parseInt($fileUpload.get(0).files.length)>3){
            //alert("You can only upload a maximum of 3 files");
            $("div#valid").show();
            setTimeout(function(){
                $('div#valid').hide();
            } ,5000);
            return false;
        }
    });    
});

/**list all banner */
$(document).ready(function(){
    if($('#bannerTarget').val()){
        $.ajax({
            url: "/banner/views",
            type: "get",
            contentType: "application/json",
            success : function(response) { 
                if(response){  
                    $('#banner').bootstrapTable('load',{data : response});
                }
            }
        });
        setTimeout(function () {$("#banner").bootstrapTable("hideLoading");}, 500);
    } 
});
/**Formatter table*/
function viewbannerFormatter(value, row) {
    return "<div class='crop'><img src='"+window.location.origin+'/storage/gallery/'+row.carousel_picture+"'></div>";
}
function deleteBannerFormatter(value, row) {
    return "<a href='javascript:void(0);' onclick='ondelete("+row.id+");'>delete</a>";
}