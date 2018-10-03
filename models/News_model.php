<?php 

class News_model extends CI_Model {  

    function __construct()
    {
        parent::__construct();
    }

    function insert_group($title,$status) {      

        try {
            $data = array(
               'NewsTitle'  => $title,
               'Active' => $status,
            );

            $this->db->insert('news_groups', $data); 
            $this->db->close();   

            $return = array(
                "status" => "1",
                "html"   => '<div class="success ico ico_success" style="background-color: rgb(220, 255, 184); ">Data has been saved.</div>'
            );         
        }
        catch (Exception $ex) {
            $return = array(
                "status" => "0",
                "html"   => "Fail: " . $ex->Message
            );   
        }    
        return $return;
    }

    function update_group($where,$title,$status) { 

        try {
            $data = array(
               'NewsTitle'  => $title,
               'Active' => $status,
            );

            $this->db->where('NewsID',$where); 
            $this->db->update('news_groups', $data); 
            $this->db->close();   

            $return = array(
                "status" => "1",
                "html"   => '<div class="success ico ico_success" style="background-color: rgb(220, 255, 184); ">Data has been saved.</div>'
            );         
        }
        catch (Exception $ex) {
            $return = array(
                "status" => "0",
                "html"   => "Fail: " . $ex->Message
            );   
        }    
        return $return;
    }

    function insert_images($data) {      

        try {

            $this->db->insert('news_pics', $data); 
            $last_id = $this->db->insert_id();
            $this->db->close();   

            $return = array(
                "status" => "1",
                "inserted_id" => $last_id,
                "html"   => '<div class="success ico ico_success" style="background-color: rgb(220, 255, 184); ">Data has been saved.</div>'
            );         
        }
        catch (Exception $ex) {
            $return = array(
                "status" => "0",
                "html"   => "Fail: " . $ex->Message
            );   
        }    
        return $return;
    }    

    function update_images($data,$where) {      
        
        try {
            $this->db->where('PictureID',$where); 
            $this->db->update('news_pics', $data); 
            $this->db->close();   

            $return = array(
                "status" => "1",
                "html"   => '<div class="success ico ico_success" style="background-color: rgb(220, 255, 184); ">Data has been saved.</div>'
            );         
        }
        catch (Exception $ex) {
            $return = array(
                "status" => "0",
                "html"   => "Fail: " . $ex->Message
            );   
        }    
        return $return;
    }

    function update_status($data,$where,$table,$field) {      

        try {

            $this->db->where($field,$where); 
            $this->db->update($table, $data); 
            $this->db->close();   

            $return = array(
                "status" => "1",
                "html"   => '<div class="success ico ico_success" style="background-color: rgb(220, 255, 184); ">Data has been saved.</div>'
            );         
        }
        catch (Exception $ex) {
            $return = array(
                "status" => "0",
                "html"   => "Fail: " . $ex->Message
            );   
        }    
        return $return;
    }

    function GetNewsGroups() {        
        $this->load->database();
        $query = $this->db->where('Active','on');
        $query = $this->db->get('news_groups');

        $groups = array();
        foreach($query->result() as $row) {
            $groups[] = $row;
        }

        $this->db->close();
        $this->db->initialize(); 

        return $groups;               
    }

    function GetData_list($table) {    

        $this->load->database();
        if($table == 'news_pics')
        {
            $this->db
                ->select('np.*,ng.NewsTitle')
                ->from('news_pics as np')
                ->join('news_groups as ng', 'np.NewsID = ng.NewsID')
                ->where('np.NewsID = ng.NewsID', NULL);            
                
            $query = $this->db->get();
        }else{
            $query = $this->db->get('news_groups');
        }

        $News = array();
        foreach($query->result() as $row) {
            $News[] = $row;
        }

        $this->db->close();
        $this->db->initialize();  

        return $News;            
    }

    function GetNewsImage($id) {    

        $this->load->database();
        $this->db->where('PictureID',$id);
        $query = $this->db->get('news_pics');

        $pic = array();
        foreach($query->result() as $row) {
            $pic[] = $row;
        }

        $this->db->close();
        $this->db->initialize();  

        return $pic;               
    }

    function DeleteItem($id,$table) {        

        try {

            $this->load->database();
                
            if($table == 'news_groups'){
                // remove Group from db
                $this->db->where('NewsID', $id);
                $this->db->delete($table);    
                
                // remove Group-Images related group
                $this->db->where('NewsID', $id);
                $this->db->delete('news_pics');    
            }else{
                // remove images
                $query = $this->db->query("DELETE FROM `news_pics` WHERE `PictureID` IN  ($id)");    
            }

            $this->db->close();
            $this->db->initialize();

            $return = array(
                "status" => "1",
                "html"   => '<div class="success ico ico_success" style="background-color: rgb(220, 255, 184); ">Data has been deleted.</div>'
            );                                     
        }
        catch (Exception $ex) {
            $return = array(
                "status" => "0",
                "html"   => "Fail: " . $ex->Message
            );              
        }

        return $return;
    }

    public function MultiDeleteItem($ids)
    {
        try {
            $id = urldecode($ids);
            $this->load->database();
            
            $query = $this->db->query("SELECT `PictureID`, `PictureTitle` FROM `news_pics` WHERE `PictureID` IN ($ids)");      
            $result = $query->result();

            $this->db->close();
            $this->db->initialize();
            //echo $this->db->debug_query();
            $return = array(
                "status" => "1",
                "html"   => $result,
            );                               
        }
        catch (Exception $ex) {
            $return = array(
                "status" => "0",
                "html"   => "Fail: " . $ex->Message
            );              
        }

        return $return;
    }

    function GetCount($table) {
        $query = $this->db->query("SELECT * FROM $table");
        $count = $query->num_rows();     
        //echo $this->db->debug_query();
        return $count;
    }

    function GetDeleteRecord($id,$table,$where) {
        $this->load->database();

        $this->db->where($where,$id);
        $query = $this->db->get($table);
        $result = $query->result();
        
        $this->db->close();
        $this->db->initialize();  
        return $result; 
    }
    
}