<div class="inner_padding">
	<div id="main_content_inner">		
        <div id="div_edit_gallery" class="edit-gallery-wrapper-main">
            <h2>Add News Group / Category</h2>
            <p class="instructions">Create a new News Group.</p>
            <div class="box_admin">
                <div class="float_left">
                    <p><label class="news_label">Title<span class="required">*</span></label> <input type="text" id="title" name="NewsTitle" style="width: 500px" /></p>
                    <p><label class="news_label">Active</label> <input type="checkbox" name="Active" checked id="checkbox" /></p>                    
                </div>

                <div class="clear"></div>
                <div id="message_add_group"></div>
                <div class="clear_10"></div>
                    
	            <div class="buttonbar">
		            <ul>
                        <li class="end"><input type="button" name="cancel" value="Cancel" style="width: 60px;"></li>
                        <li class="end"><input type="button" name="" value="Save" id="btn_Add_News_group"  style="width: 150px;"></li>
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
</script>

<script>
    $(document).on('click','#btn_Add_News_group,#action-save',function(){

        $('.notification .error').remove();
        $('.notification .success').remove();
                
        var status  = '';
        var title   = $('input[name=NewsTitle]').val();
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
                    },
            success: function (data) {

                var jsonData = $.parseJSON(data);
                var notification = $('#fuel_notification');

                if (jsonData.status == "1") {
                    notification.append(jsonData.html);
                    setTimeout(function(){ location.reload(); }, 1800);
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
