$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
}); 
    
    
    
$(document).ready(function() {
    
    load_image_data();
	
	function load_image_data(){
		$.ajax({
			url:"fetchProfile",
			method:"POST",
			success:function(data){
			    var output = $(".preview-images-zone");
				output.html(data);
			}
		});
	}
    
    
    
    
    $('#pro-image').change(function(){
        var error_images='';
        var form_data = new FormData();
        var files = $('#pro-image')[0].files;
        if(files.length > 4){
            error_images += "You can not select more than 4 photos";
        }else{
            for(var i=0;i<files.length;i++){
                var name = document.getElementById("pro-image").files[i].name;
                var ext  = name.split('.').pop().toLowerCase();

                if(jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1){
                    error_images += "<p>Invalid " + i + ' File</p>';
                }

                form_data.append('files[]', document.getElementById('pro-image').files[i]);
            }
        }

        if(error_images == ''){
            $.ajax({
                url:"uploadProfile",
                method:"POST",
                data:form_data,
                contentType:false,
                cache:false,
                processData:false,
                beforeSend:function(){
                    $("#error_multiple_files").html("<br/><label class='text-primary'>Uploading...</label>");
                },
                success: function(){
                    $('#error_multiple_files').html("<br/><label class='text-success'>Uploaded</label>");

                    load_image_data();
                }
            });
        }else{
            $('#pro-image').val('');
            $('#error_multiple_files').append("<span class='text-danger'>"+error_images+"</span>");
            
            return false;
        }
    });

    $(document).on('click', '.image-cancel', function(){
        var image_id = $(this).attr("id");
        var image_name = $(this).data("image_name");
        let no = $(this).data('no');
        if(confirm("Are you sure you want to remove it?")){
            $.ajax({
                url:"deleteProfile",
                method: "POST",
                data: {image_id:no},
                success: function(){
                    load_image_data();
                    
                    
                    $(".preview-image.preview-show-"+no).remove();
                    
                }

            })
        }
    })
    
    $(".preview-images-zone").sortable();
    
    //     document.getElementById('pro-image').addEventListener('change', readImage, false);

    //         $(".preview-images-zone").sortable();
    //  }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    // if(event.target.files.length < 4){
    // document.getElementById('pro-image').addEventListener('change', readImage, false);

    // $(".preview-images-zone").sortable();
    // }

    // $(document).on('click', '.image-cancel', function() {
    //     let no = $(this).data('no');
    //     $(".preview-image.preview-show-"+no).remove();
    // });
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
});



// var num = 4;
// function readImage() {
//     if (window.File && window.FileList && window.FileReader) {
//         var files = event.target.files; //FileList object
//         var output = $(".preview-images-zone");

//         // alert(files.length);
//         // alert($("#pro-image").val());


//         for (let i = 0; i < files.length; i++) {
//             var file = files[i];
//             if (!file.type.match('image')) continue;
            
//             var picReader = new FileReader();
            
//             picReader.addEventListener('load', function (event)     {
//                 var picFile = event.target;
//                 var html =  '<div class="preview-image preview-show-' + num + '">' +
//                             '<div class="image-cancel" data-no="' + num + '">x</div>' +
//                             '<div class="image-zone"><img id="pro-img-' + num + '" src="' + picFile.result + '"></div>' +
//                             '<div class="tools-edit-image"><a href="javascript:void(0)" data-no="' + num + '" class="btn btn-light btn-edit-image">edit</a></div>' +
//                             '</div>';

//                 output.append(html);
//                 num = num + 1;
//             });

//             picReader.readAsDataURL(file);
//         }
//         // $("#pro-image").val('');
//     } else {
//         console.log('Browser not support');
//     }
// }

