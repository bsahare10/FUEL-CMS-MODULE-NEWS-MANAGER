<div class="tcounters">
       <p class="ico ico_info">
            <span><?=$group_count;?> group items</span>  
       </p>                
</div>

<div id="list_container">
    <div class="inner_padding">
        <div id="main_content_inner" class="display-flex">        
            <div id="div_gallery" class="gallery-wrapper-main">
                <div id="ajax_galleries" class="ajax_overlay"><div class="ajax_loader"></div></div>
                    <h2 class="gallery-group-header">News Groups</h2>
                    <div id="news_groups" class="supercomboselect" style="">
                        <div id="data_table_container">
                          <?php if(!empty($Group_list)){ ?> 
                            <table cellpadding="0" cellspacing="0" id="data_table" class="data">
                                <thead>
                                <tr>
                                    <th class="col1"><a>Title</a></th>
                                    <th class="col2"><a>Published</a></th>
                                    <th class="col3"><span>Actions</span></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($Group_list as $group) { ?>
                                <tr id="data_table_row3" class="rowaction" data-id="<?=$group->NewsID; ?>">
                                    <td class="col1"><?=$group->NewsTitle; ?></td>
                                    <td class="col2"><span class="publish_hover publish_col" style="width: 50px;" data-toggle="<?=$group->Active; ?>" id="toggled" data-table='news_groups' data-dbfield='NewsID'><span class="toggle-here publish_text <?php if($group->Active == 'off'){ echo 'unpublished'; }else{ echo 'published'; } ?> toggle_off"><?=$group->Active; ?></span><span class="publish_action <?php if($group->Active == 'off'){ echo 'unpublished'; }else{ echo 'published'; } ?> hidden">click to toggle</span></span></td>

                                    <td class="col3 actions" style="text-align: left;"><a href="javascript:void(0)" class="datatable_action action_edit" data-group-text='<?=$group->NewsTitle; ?>' >EDIT</a>&nbsp; |  &nbsp;<a href="javascript:" data-table='news_groups' id="news-delete-group" data-id="<?=$group->NewsID; ?>">DELETE</a>
                                    </td>
                                </tr>
                                <?php } ?>
                                </tbody>
                                <script>
                                $(document).on('click','#news-delete-group',function(){
                                        var id = $(this).attr('data-id');
                                        localStorage.setItem("PATH", window.location.href);

                                        window.location.replace('<?=fuel_url($nav_selected.'/deleteGroup/');?>'+id); 
                                    });
                                </script>
                            </table>
                          <?php }else{ echo '<div class="nodata">No data to display.</div>'; } ?>
                        </div>
                    </div>
            </div>
            <div id="div_gallery" class="gallery-wrapper-main">
                <h2 class="gallery-group-header">Edit Group</h2>
                <div class="group-edit-box">
                    <div id="edit-box" style="display: none;">
                        <div class="float_left" style="margin-top: 8px;">
                            <p><label class="gallery_label">Title<span class="required">*</span></label> <input type="text" id="title" name="NewsTitle" style="width: 250px" /></p>
                            <p><label class="gallery_label">Active</label> <input type="checkbox" name="Active" checked id="checkbox" /></p>                    
                            <input type="hidden" id="hidden-id" name="hidden-id">
                        </div>

                        <div class="clear"></div>
                        <div id="message_add_group"></div>
                        <div class="clear_10"></div>
                            
                        <div class="buttonbar">
                            <p>
                                <label class="gallery_label"> </label> 
                                <input type="button" name="" value="Save" id="btn_Add_News_group"  style="width: 150px;">
                            </p>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="tcounters">
        <p class="ico ico_info">
            <span><?=$image_count;?> news items</span>
        </p>
    </div>

    <div id="news-image-listing" class="supercomboselect custom-height" style="height: 400px;">
        <div id="data_table_container">
          <?php if(!empty($Image_list)){ ?>
            <table cellpadding="0" cellspacing="0" id="data_table" class="data">
                <thead>
                <tr>
                    <th class="col1"><a>Title</a></th>
                    <th class="col2"><a>Discription</a></th>
                    <th class="col3"><a>News Group</a></th>
                    <th class="col4"><a>Published</a></th>
                    <th class="col5"><a>Picture</a></th>
                    <th class="col6"><a>Added Date</a></th>
                    <th class="col7"><span>&nbsp;</span></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($Image_list as $image) { ?>
                <tr id="data_table_row3" class="rowaction" data-id="<?=$image->PictureID; ?>">
                    <td class="col1 first"><?=$image->PictureTitle; ?></td>
                    <td class="col2"><?php if(!empty($image->PictureDesc)){ echo $image->PictureDesc; }else{ echo "-"; } ?></td>
                    <td class="col3"><?=$image->NewsTitle; ?></td>
                    <td class="col4"><span class="publish_hover publish_col" style="width: 50px;" data-toggle="<?=$image->PictureActive; ?>" id="toggled" data-table='news_pics' data-dbfield='PictureID'><span class="toggle-here publish_text <?php if($image->PictureActive == 'off'){ echo 'unpublished'; }else{ echo 'published'; } ?> toggle_off" data-field="published"><?=$image->PictureActive; ?></span><span class="publish_action <?php if($image->PictureActive == 'off'){ echo 'unpublished'; }else{ echo 'published'; } ?> hidden">click to toggle</span></span></td>
                    <td class="col5">
                      <?php if(!empty($image->PictureSRC)){ ?>
                        <img src="<?=site_url(); ?>fuel/modules/news/assets/NewsImages/<?=$image->PictureSRC; ?>" class="gallery-images" >
                      <?php }else{ echo "-"; } ?>
                    </td>
                    <td class="col6"><?=$image->AddedDate; ?></td>
                    <td class="col7 actions"><a href="javascript:" class="datatable_action image-action_edit" >EDIT</a>
                    &nbsp; |  &nbsp;
                    <a href="javascript:" data-table='news_pics' id="news-delete" data-id="<?=$image->PictureID; ?>">DELETE</a>
                    <input type="checkbox" name="delete[<?=$image->PictureID; ?>]" value="" id="<?=$image->PictureID; ?>" data-table='news_pics' class="multi_delete">
                </tr>
                <?php } ?>
                </tbody>
                <script>
                    $(document).on('click','#news-delete',function(){
                            var id = $(this).attr('data-id');
                            localStorage.setItem("PATH", window.location.href);

                            window.location.replace('<?=fuel_url($nav_selected.'/deleteNews/');?>'+id); 
                    });
                </script>
            </table>
          <?php }else{ ?>
                    <div class="nodata">No data to display.</div>
                    <style type="text/css"> .custom-height{ height: auto !important; } </style>
          <?php } ?>
            <input type="hidden" name="offset" id="offset" value="0">
            <input type="hidden" name="order" id="order" value="desc">
            <input type="hidden" name="col" id="col" value="publish_date">
        </div>
    </div>
    <div class="loader" id="table_loader" style="display: none;"></div>
</div>

<!-- //for START of TOGGLE STATUS -->
<script>
    $( document ).ready(function() {
        $( "tr:odd" ).addClass('alt');
    });

    $(document).on('click','#toggled',function(){

        var id = $(this).parent().parent('tr').attr('data-id');
        var action = $(this).data("toggle");
        var action = $(this).data("toggle");
        var table = $(this).data("table");
        var field = $(this).data("dbfield");
        var save_action = '';
        if(action == "on")
        {
            $(this).data("toggle","off");
            $(this).find('.toggle-here').text("off");
            $(this).find('.published').removeClass('published').addClass('unpublished');
        }
        else if(action == "off")
        {
            $(this).data("toggle","on");
            $(this).find('.toggle-here').text("on");
            $(this).find('.unpublished').removeClass('unpublished').addClass('published');
        }

        save_action = $(this).find('.toggle-here').text();
        var notification = $('#fuel_notification');

        $.ajax({
                url  : 'update_status',
                datatype: 'json',
                type : "POST",
                data : {
                        action: save_action, 
                        id: id,
                        field: field,
                        table: table,
                      },
                success: function (data) {
                    var jsonData = $.parseJSON(data);

                    if (jsonData.status == "1") {
                        notification.append(jsonData.html);
                        setTimeout(function(){ 
                            notification.find('.success').remove(); 
                            notification.find('.error').remove(); 
                        }, 1500);
                    } else {
                        notification.append(jsonData.html);
                    }
                },
                error: function (xhr, testStatus, error) {
                    console.log('$.ajax() error: ' + error);
                }
                      
            });
        
    });
</script>   
<!-- //for END of TOGGLE STATUS -->

<!-- //for START of GROUP SECTION -->
<script>    
    $(document).on('click','.action_edit',function(){

        $('#edit-box').show();

        var id = $(this).parent().parent().attr('data-id');
        var text = $(this).attr('data-group-text');
        $('input[name=NewsTitle').val(text);
        $('input[name=hidden-id').val(id);
    });

    $(document).on('click','#btn_Add_News_group',function(){

        $('.notification .error').remove();
        $('.notification .success').remove();
                
        var status   = '';
        var title    = $('input[name=NewsTitle]').val();
        var group_id = $('input[name=hidden-id').val();
        var notification = $('#fuel_notification');

        if(group_id == '' || group_id == 'undefined' || group_id == undefined){
            notification.append('<ul class="ico error ico_error" style="background-color: rgb(238, 96, 96); "><li>Please select News Group first.!!</li></ul>');
            return false;
        }

        if ($('#checkbox').is(":checked"))
        {
          status    = 'on';
        }else{
          status    = 'off';
        }

        $.ajax({
            url: "insert_group",
            datatype: 'json',
            type: 'post',
            data: {
                    title: title,
                    status: status,
                    group_id: group_id,
                   },
            success: function (data) {
                var jsonData = $.parseJSON(data);

                if (jsonData.status == "1") {
                    notification.append(jsonData.html);
                    setTimeout(function(){ location.reload(); }, 1500);
                } else {
                    notification.append(jsonData.html);
                }
            },
            error: function (xhr, testStatus, error) {
                console.log('$.ajax() error: ' + error);
            }
        });
    });

</script>   
<!-- //for END of GROUP SECTION -->

<!-- //for START of GROUP-IMAGES SECTION -->
<script>    
        $(document).on('click','.image-action_edit',function(){
            var id = $(this).parent().parent().attr('data-id');
            window.location.replace('<?=fuel_url($nav_selected.'/update_image/');?>'+id);
        });
</script>   
<!-- //for END of GROUP-IMAGES SECTION -->

<!-- //for START of MULTI-DELETE functionality -->
<script>    
    $(document).on('change','#news-image-listing table input[type=checkbox]',function(){
        if($('#news-image-listing table input[type=checkbox]:checked').length == 0) { $('#newsMultiDeleteTAB').hide(); }else{ $('#newsMultiDeleteTAB').show(); }
    });

    $(document).on('click','#newsMultiDeleteTAB',function(){
        var arr = [];
        var id;
        var url = window.location.href;
        var table = 'news_pics';
        $('#news-image-listing table input[type=checkbox]:checked').each(function () {
            id = $(this).attr('id');
            arr.push(id);
        }); 
        localStorage.setItem("PATH", window.location.href);
        
        var encoded_ids = encodeURIComponent(arr);
        window.location.replace('<?=fuel_url($nav_selected.'/delete/');?>'+encoded_ids);
    });
</script>   
<!-- //for END of MULTI-DELETE functionality -->

