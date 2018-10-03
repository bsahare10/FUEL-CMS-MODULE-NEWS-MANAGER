<div class="inner_padding">
	<div id="main_content_inner">		
        <div id="div_edit_gallery" class="edit-gallery-wrapper-main">
            <h2>Add News and Image</h2>
            <p class="instructions">Insert News and Images to News Group.</p>
            <div class="box_admin">
                <div class="float_left">
                    <div>
                        <label class="gallery_label">Group<span class="required">*</span></label>
                        <select name="GroupID" id="GalleryID">            
                            <option value="">Select Gallery</option> 
                            <?php foreach($groups as $group) { ?>          
                            <option value="<?=$group->NewsID; ?>" <?php if(isset($image_data) && $group->NewsID == $image_data[0]->NewsID){ ?> selected <?php } ?> ><?=$group->NewsTitle; ?></option> 
                            <?php } ?>         
                        </select>
                    </div>      
                    <p><label class="gallery_label">Image</label> 
                        <input type="file" name="NewsImage" />
                        <span id="valid_image_status" style="display: none;">
                            <img src="<?=site_url(); ?>/fuel/modules/news/assets/images/ico_accept.png" alt="Folder Status" class='set-priview-img'/> Valid file format
                        </span>
                        <span id="invalid_image_status" style="display: none;">
                            <img src="<?=site_url(); ?>/fuel/modules/news/assets/images/ico_cancel.png" alt="Folder Status" class='set-priview-img'/> Inalid file format
                        </span>
                        <br/>
                        <span class="alrt-text">only ('jpg','jepg','png','gif') files allowed
                        </span>
                    </p>
                    <p>
                        <label class="gallery_label"> </label>
                        <span class='priview-imgage-wrapp'>
                            <img id="img-preview" <?php if(isset($image_data)){ ?> src=<?=site_url('fuel/modules/news/assets/NewsImages/'.$image_data[0]->PictureSRC); }else{ ?> src='#' <?php } ?> alt="your image" style="height: 60px; width: 80px;" />
                        </span>
                        <input type="hidden" name="hidden-image-name" id="hidden-image-name" value="<?php if(isset($image_data)){ echo $image_data[0]->PictureSRC; } ?>">
                    </p>              
                    <p><label class="gallery_label">Title<span class="required">*</span></label> <input type="text" value="<?php if(isset($image_data)){ echo $image_data[0]->PictureTitle; } ?>" name="ImageTitle" style="width: 500px;" /></p>
                    <p><label class="gallery_label">Description</label> <textarea name="ImageDesc" style="width: 500px;"><?php if(isset($image_data)){ echo $image_data[0]->PictureDesc; } ?></textarea>
                    <p><label class="gallery_label">Active</label> <input type="checkbox" name="Active" <?php if (isset($image_data)) { if($image_data[0]->PictureActive == 'on'){ echo 'checked'; }}else{ echo "checked"; } ?> id="checkbox" /></p>    
                    <input type="hidden" name="hidden-image-id" id="hidden-image-id" value="<?php if(isset($image_data)){ echo $image_data[0]->PictureID; } ?>">
                </div>

                <div class="clear"></div>

                <div id="message_add_group"></div>
                <div class="clear_10"></div>
                    
	            <div class="buttonbar">
		            <ul>
                        <li class="end"><input type="button" name="cancel" value="Cancel" style="width: 60px;"></li>
                        <li class="end"><input type="button" name="" value="Save" id="btn_Add_News_image"  style="width: 150px;"></li>
			        </ul>
	            </div>
                <div class="clear"></div>
            </div>
        </div>

        <div class="clear"></div>
        <div id="div_html_output"></div>
	</div>        	
</div>

<script>
    $(document).on('click','input[name="cancel"]',function(){
        window.location.replace("<?=fuel_url($nav_selected);?>");
    });

    $( "input[name=NewsImage]" ).change(function() {
          readURL(this);

          $('#valid_image_status').hide();
          $('#invalid_image_status').hide();
          localStorage.removeItem("is_validIMG");
          
          var file = $('input[name=NewsImage]').val();
          var exts = ['jpeg','jpg','gif','png'];
          // first check if file field has any value
          if ( file ) {
            // split file name at dot
            var get_ext = file.split('.');
            // reverse name to check extension
            get_ext = get_ext.reverse();
            // check file type is valid as given in 'exts' array
            if ( $.inArray ( get_ext[0].toLowerCase(), exts ) > -1 ){
              $('#valid_image_status').show();
              localStorage.setItem("is_validIMG", "true");
            } else {
              $('#invalid_image_status').show();
              localStorage.setItem("is_validIMG", "false");
            }
          }
    });   

    function readURL(input) {

      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          $('#img-preview').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
      }
    }
</script>

<script>
        $(document).on('click','#btn_Add_News_image,#action-save',function(){

            $('.notification .error').remove();
            $('.notification .success').remove();
            var data = $('#form').serializefiles();
            var notification = $('#fuel_notification');
            var img_status = localStorage.getItem("is_validIMG");
            data.append("status",img_status);

                $.ajax({
                    cache: false,
                    type: "POST",
                    url:"insert_images",
                    data:data,
                    datatype: 'json',
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        var jsonData = $.parseJSON(data);
                        console.log(jsonData);
                        
                        if (jsonData.status == "1") {
                            notification.append(jsonData.html);
                            if(jsonData.inserted_id){
                              setTimeout(function(){ window.location.replace('<?=fuel_url($nav_selected.'/update_image/');?>'+jsonData.inserted_id); }, 1800);
                            }
                        } else {
                            notification.append(jsonData.html);
                        }
                    },
                    error: function (xhr, testStatus, error) {
                        console.log('$.ajax() error: ' + error);
                    }
                });
        });

        $.fn.serializefiles = function() {
           var obj = $(this);
           /* ADD FILE TO PARAM AJAX */
           var formData = new FormData();
           $.each($(obj).find("input[type='file']"), function(i, tag) {
               $.each($(tag)[0].files, function(i, file) {
                   formData.append(tag.name, file);
               });
           });
           var params = $(obj).serializeArray();
           $.each(params, function (i, val) {
               formData.append(val.name, val.value);
           });
           return formData;
       };
</script>
