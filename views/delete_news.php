<div id="fuel_main_content_inner">
	<p class="instructions"><?=$instructions?><br> 
		<span class="delete"><?php if(isset($delete_name)){ echo $delete_name; } ?></span>
	</p>
	<div class="buttonbar clearfix">
		<ul>
			<li class="unattached end"><a href="javascript:" class="ico ico_no">No, don't delete it</a></li>
			<li class="unattached"><a href="javascript:" class="ico ico_yes" id="del-submit">Yes,  delete it</a></li>
		</ul>
	</div>

	<input type="hidden" name="delete-id" id="delete-id" value="<?php if(isset($delete_id)){ echo $delete_id; } ?>">
	<input type="hidden" name="delete-table" id="delete-table" value="<?php if(isset($table)){ echo $table; }?>">
	<input type="hidden" name="Multi-delete" id="Multi-delete" value="<?php if(isset($multiple)){ echo $multiple; }?>">

</div>

<script>
	$(document).ready(function(){
		$("a.ico_no").attr("href", localStorage.getItem("PATH"));
	});

	$(document).on('click','a.ico_no',function(){
		localStorage.removeItem("PATH");
		localStorage.removeItem("DATA-TABLE");
	});

	$(document).on('click','#del-submit',function(){
		var id = $('#delete-id').val();
		var table = $('#delete-table').val();

		var notification = $('#fuel_notification');
		$.ajax({
                url  : 'delete_process',
                datatype: 'json',
                type : "POST",
                data : {
                        item_id: id, 
                        table: table,
                      },
                success: function (data) { console.log(data);
                    var jsonData = $.parseJSON(data);

                    if (jsonData.status == "1") {
                        notification.append(jsonData.html);
                        setTimeout(function(){ 
                            window.location.replace(localStorage.getItem("PATH"));
                        }, 1000);
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