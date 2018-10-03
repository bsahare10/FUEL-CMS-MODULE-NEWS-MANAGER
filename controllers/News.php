<?php  
require_once(FUEL_PATH.'/libraries/Fuel_base_controller.php');

class News extends Fuel_base_controller 
{
    private $vars;
    public  $nav_path;
    public  $nav_title;
    public  $page_title;

	function __construct()
	{
		parent::__construct();

        $this->load->helper('ajax');
        $this->load->library('session');      
        $this->load->model('News_model');
        
        $this->page_title = "News Manager - ";   

        $this->nav_path     = $this->fuel->news->config('nav_path');
        $this->nav_title    = $this->fuel->news->config('nav_title');
        
        $this->vars['nav_selected'] = $this->nav_path;
	}

    function index()
    {        
        $vars = $this->vars;

        $vars['page_title']      = $this->page_title."News Manager";                
        $vars['Image_list']      = $this->News_model->GetData_list('news_pics');
        $vars['group_count']     = $this->News_model->GetCount('news_groups');
        $vars['image_count']     = $this->News_model->GetCount('news_pics');
        $vars['Group_list']      = $this->News_model->GetData_list('news_groups');
        
        // load actions
        $vars['current_page'] = '';
        $actions = $this->load->module_view(NEWSMANAGER_FOLDER, '_blocks/list_actions', $vars, TRUE);
        $vars['actions'] = $actions; 

        $crumbs = array($this->nav_path => $this->nav_title, '' => 'News Manager');
        $this->fuel->admin->set_titlebar($crumbs, 'ico_news');
        $this->fuel->admin->render('news_manager', $vars);
    }

    function add_group() 
    {
        $vars = $this->vars;
        $vars['page_title'] = $this->page_title."Add News Group";                

        // load actions
        $vars['current_page'] = 'add_news_group';
        $actions = $this->load->module_view(NEWSMANAGER_FOLDER, '_blocks/list_actions', $vars, TRUE);
        $vars['actions'] = $actions;    

        $return = array(
            "Status" => "0",
            "html"   => ""
        );  

        $crumbs = array($this->nav_path => $this->nav_title, '' => 'News Manager');
        $this->fuel->admin->set_titlebar($crumbs, 'ico_news');
        $this->fuel->admin->render('add_news_group', $vars);
    }

    function add_images() 
    {
        $vars = $this->vars;
        $vars['groups']  = $this->News_model->GetNewsGroups();
        $vars['page_title'] = $this->page_title."Add News Images";

        // load actions
        $vars['current_page'] = 'add_news_images';
        $actions = $this->load->module_view(NEWSMANAGER_FOLDER, '_blocks/list_actions', $vars, TRUE);
        $vars['actions'] = $actions;      

        $crumbs = array($this->nav_path => $this->nav_title, '' => 'News Manager');
        $this->fuel->admin->set_titlebar($crumbs, 'ico_news');
        $this->fuel->admin->render('add_news_images',$vars);
    }

    function update_image($id) 
    {
        $vars = $this->vars;
        $vars['groups']  = $this->News_model->GetNewsGroups();
        $vars['image_data']  = $this->News_model->GetNewsImage($id);
        $vars['page_title'] = $this->page_title."Add News Images";

        // load actions
        $actions = $this->load->module_view(NEWSMANAGER_FOLDER, '_blocks/list_actions', $vars, TRUE);
        $vars['actions'] = $actions;      

        $crumbs = array($this->nav_path => $this->nav_title, '' => 'News Manager');
        $this->fuel->admin->set_titlebar($crumbs, 'ico_newsmanager');
        $this->fuel->admin->render('add_news_images',$vars);
    }

    function insert_images() 
    {
        $return = array(
            "status" => "0",
            "html"   => "Failed"
        );

        if(empty($_POST['GroupID']))
        {
            $return = array(
                "status" => "0",
                "html"   => '<ul class="ico error ico_error" style="background-color: rgb(238, 96, 96); "><li>Please fill out the required field "group".</li></ul>'
            );
            echo json_encode($return);
            exit; 
        }

        if($_POST['status'] == 'false')
        {
            $return = array(
                "status" => "0",
                "html"   => '<ul class="ico error ico_error" style="background-color: rgb(238, 96, 96); "><li>Please check field "image".</li></ul>'
            );
            echo json_encode($return);
            exit; 
        }
        
        if(empty($_FILES['NewsImage']['name']) && empty($_POST['hidden-image-name']))
        {
            // $return = array(
            //     "status" => "0",
            //     "html"   => '<ul class="ico error ico_error" style="background-color: rgb(238, 96, 96); "><li>Please fill out the required field "image".</li></ul>'
            // );               
            // echo json_encode($return);
            // exit; 
            $picture = '';
        }

        if(empty($_POST['ImageTitle']))
        {
            $return = array(
                "status" => "0",
                "html"   => '<ul class="ico error ico_error" style="background-color: rgb(238, 96, 96); "><li>Please fill out the required field "title".</li></ul>'
            );
            echo json_encode($return);
            exit; 
        }
        
        if(!empty($_FILES['NewsImage']['name'])){

            $config['upload_path'] = 'fuel/modules/news/assets/NewsImages/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';            
            $this->load->library('upload',$config);
            $this->upload->initialize($config);

            if (!is_dir($config['upload_path'])){
                mkdir($config['upload_path'], 0777, TRUE);
            }
            $config['file_name'] = $_FILES['NewsImage']['name'];
            $picture = '';

            if($this->upload->do_upload('NewsImage'))
            {
               $uploadData = $this->upload->data();
               $picture = $uploadData['file_name'];
            }
        }
        else{
            $picture = $_POST['hidden-image-name'];
        }

        if(isset($_POST['Active'])){ $Active = $_POST['Active'];}else{ $Active = 'off'; }

        if(!empty($_POST['hidden-image-id'])){
            $data = array('PictureSRC'=> $picture,'PictureTitle'=> $_POST['ImageTitle'],'PictureDesc'=> $_POST['ImageDesc'],'NewsID'=> $_POST['GroupID'],'PictureActive'=> $Active, 'AddedDate'=> date('Y-m-d H:i:s'));
            $where = $_POST['hidden-image-id'];
            $return = $this->News_model->update_images($data,$where);
        }else{
            $data = array('PictureSRC'=> $picture,'PictureTitle'=> $_POST['ImageTitle'],'PictureDesc'=> $_POST['ImageDesc'],'NewsID'=> $_POST['GroupID'],'PictureActive'=> $Active, 'AddedDate'=> date('Y-m-d H:i:s'));
            $return = $this->News_model->insert_images($data);
        }
        echo json_encode($return);
        exit;
    }

    function update_status() 
    {
        $return = array(
            "status" => "0",
            "html"   => "Failed"
        );

        $field = $_POST['field'];
        if($field == 'PictureID'){
            $field_cond = 'PictureActive';
        }else{
            $field_cond = 'Active';
        }

        $where = $_POST['id'];
        $table = $_POST['table'];
        $data = array($field_cond=> $_POST['action']);
        $return = $this->News_model->update_status($data,$where,$table,$field);
        echo json_encode($return);
        exit;
    }


    function insert_group() 
    {
        $return = array(
            "status" => "0",
            "html"   => "Failed"
        );

        $title      = $_POST['title'];
        $status     = $_POST['status'];   

        $regex = '~^[a-zA-Z0-9-_ ]+$~';   
        if(!empty($title) && preg_match($regex, $title))
        {
            if(isset($_POST['group_id'])){
                $return = $this->News_model->update_group($_POST['group_id'],$title,$status);
            }else{
                $return = $this->News_model->insert_group($title,$status);
            }
        }else{
            $return = array(
                "status" => "0",
                "html"   => '<ul class="ico error ico_error" style="background-color: rgb(238, 96, 96); "><li>Please fill out the required field "title" or field not contain any special charector except ( space , - , _ ).</li></ul>'
            );
        } 
        echo json_encode($return);
        exit;
    }

    public function deleteNews($id){
        $vars = $this->vars;
        $vars['table'] = 'news_pics';
        $where = 'PictureID';
        // $vars['groups']  = $this->News_model->GetNewsGroups();
        $vars['delete_data'] = $this->News_model->GetDeleteRecord($id,$vars['table'],$where);
        $vars['delete_id'] = $vars['delete_data'][0]->PictureID;
        $vars['delete_name'] = $vars['delete_data'][0]->PictureTitle;
        $vars['instructions'] = "You are about to delete the news item:";
        // $vars['page_title'] = $this->page_title."Add News Images";

        $crumbs = array($this->nav_path => $this->nav_title, '' => $vars['delete_data'][0]->PictureTitle);
        $this->fuel->admin->set_titlebar($crumbs, 'ico_blog_posts');
        $this->fuel->admin->render('delete_news',$vars);
    }

    public function deleteGroup($id){
        $vars = $this->vars;
        $vars['table'] = 'news_groups';
        $where = 'NewsID';
        $vars['delete_data']  = $this->News_model->GetDeleteRecord($id,$vars['table'],$where);
        $vars['delete_id'] = $vars['delete_data'][0]->NewsID;
        $vars['delete_name'] = $vars['delete_data'][0]->NewsTitle;
        $vars['instructions'] = "You are about to delete the group item, it will also delete relative news items:";
        
        $crumbs = array($this->nav_path => $this->nav_title, '' => $vars['delete_name']);
        $this->fuel->admin->set_titlebar($crumbs, 'ico_blog_posts');
        $this->fuel->admin->render('delete_news',$vars);
    }

    function delete_process()
    {
        $return = array(
            "status" => "0",
            "html"   => "Failed"
        );

        try {
            $id = $_POST['item_id'];
            $table = $_POST['table'];
            $return = $this->News_model->DeleteItem($id,$table);      
        }
        catch (Exception $ex) {
            $return = array(
                "status" => "0",
                "html"   => '<ul class="ico error ico_error" style="background-color: rgb(238, 96, 96); "><li>Error occured while deleting, please try again.!!</li></ul>'
            );            
        }        
        echo json_encode($return);
        exit;
    }

    function multi_delete()
    {
        $return = array(
            "status" => "0",
            "html"   => "Failed"
        );

        try {
            $ids = $_POST['item_ids'];
            $table = $_POST['table'];
            $return = $this->News_model->MultiDeleteItem($ids,$table);      
        }
        catch (Exception $ex) {
            $return = array(
                "status" => "0",
                "html"   => '<ul class="ico error ico_error" style="background-color: rgb(238, 96, 96); "><li>Error occured while deleting, please try again.!!</li></ul>'
            );            
        }        
        echo json_encode($return);
        exit;
    }

    function delete($id)
    {   
        $ids = urldecode($id);
        $return = $this->News_model->MultiDeleteItem($ids);
 
        foreach ($return['html'] as $key => $value) {
            $pic_ids[] = $value->PictureID;
            $pic_names[] = $value->PictureTitle;
        }

        $vars['multiple'] = 'TRUE';
        $vars['table'] = 'news_pics';
        $vars['delete_id'] = implode(', ', $pic_ids);
        $vars['delete_name'] = implode(', ', $pic_names);

        $vars['instructions'] = "You are about to delete the news item:";
        $crumbs = array($this->nav_path => $this->nav_title, '' => $vars['delete_name']);
        $this->fuel->admin->set_titlebar($crumbs, 'ico_blog_posts');

        $this->fuel->admin->render('delete_news',$vars);
    }

}