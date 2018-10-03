<div class="buttonbar" id="action_btns">
	<ul>
		<?php if($page_title != 'News Manager - News Manager'){ ?>
		<li><a href="javascript:" id="action-save" class="ico ico_save save" title="">Save</a></li>
		<?php } ?>

        <li<?php echo isset($current_page) && $current_page == '' ? ' class="active"' : ''; ?>><a href="<?=fuel_url($nav_selected);?>" id="toggle_tree" class="ico ico_tree" title="">News Manager</a></li>

        <?php if($page_title == 'News Manager - News Manager'){ ?>
		<li style="display: none;" id="newsMultiDeleteTAB"><a href="javascript:" class="ico ico_delete" id="multi_delete">Delete Multiple</a></li>
		<?php } ?>

        <li<?php echo isset($current_page) && $current_page == 'add_news_group' ? ' class="active"' : ''; ?>><a href="<?=fuel_url($nav_selected.'/add_group');?>" id="btn_Add_GalleryGroup" class="ico ico_tree">Create News Group</a></li>

        <li<?php echo isset($current_page) && $current_page == 'add_news_images' ? ' class="active"' : ''; ?>><a href="<?=fuel_url($nav_selected.'/add_images');?>" id="btn_Add_GalleryImage" class="ico ico_assets">Create News Images</a></li>
	</ul>
</div>