<?
class Startup_program_model extends Model {
	function audit($data){
        $data_status=$data;
        $data_status['status']='added';
		$this->db->update("startup",array("flag"=>1),$data_status);
		if($this->db->affected_rows()==0)
			$this->add_new($data);
	}
	function add_new($data){
        $data['dateadded']=date('y-m-d H:i:s');
		$this->db->insert("startup",$data);
		//$this->db->insert("log_item",array("item"=>"startup",'date'=>date('y-m-d H:i:s'),"type"=>"add","reference"=>$this->db->insert_id()));
	}
	function auditend($hostname){
		$result=$this->db->get_where("startup",array("hostname"=>$hostname,"flag"=>0,'status'=>'added'));
		foreach ($result->result() as $row){
    		$this->remove($row->id);
		}
        $this->db->update("startup",array('flag'=>0),array('hostname'=>$hostname));
	}
	function remove($id){
		$this->db->where("id",$id);
		$this->db->update("startup",array("status"=>"remove","dateremove"=>date('y-m-d H:i:s')));
		//$this->db->insert("log_item",array("item"=>"startup",'date'=>date('y-m-d H:i:s'),"type"=>"remove","reference"=>$id));
	}
	function approve_add($id,$admin){
		$this->db->where("id",$id);
		$this->db->update("startup",array("status"=>"added",'adminapprove'=>$admin));
	}
	function approve_change($id,$admin){
		$query=$this->db->get_where('startup',array('id'=>$id));
        $data=$query->result_array();
        if(count($data)==1){
            if($data[0]['status']=='new')
                $this->db->update('startup',array('status'=>'added','adminapprove'=>$admin),array('id'=>$id));
            if($data[0]['status']=='remove')
                $this->db->update('startup',array('status'=>'removed','adminapprove'=>$admin),array('id'=>$id));
            return $this->db->affected_rows();
        }
		else
            return 0;
	}
    function ignore_change($id,$admin){
        $query=$this->db->get_where("startup",array('id'=>$id));
        if($query->num_rows()==1){
            $data=$query->row_array();
            if($data['status']=='new')
                $this->db->update('startup',array("status"=>"ignored",'adminapprove'=>$admin),array('id'=>$id));
            else if($data['status']=='remove')
                $this->db->update('startup',array("status"=>"added",'adminapprove'=>$admin),array('id'=>$id));
        }
    }
    function get_log($admin=null){
        if($admin==null){
            $query=$this->db->get('log_startup');
        }
        else{
            $query=$this->db->get_where('log_startup',array('admin'=>$admin));
        }
        return $query->result_array();
    }
    function get_log_by_id($id){
        $query=$this->db->get_where('log_startup',array('id'=>$id));
        return $query->result_array();
    }
    function get_by_id($id){
        $query=$this->db->get_where('startup',array('id'=>$id));
        return $query->result_array();
    }
    function get($criteria){
        if(isset($criteria['startup.dateadded'])){
            $this->db->where('startup.dateadded >=',$criteria['dateadded'][0]);
            $this->db->where('startup.dateadded <',$criteria['dateadded'][1]);
            unset($criteria['startup.dateadded']);
        }
        if(count($criteria['startup.status'])>1){
            $this->db->where_in('startup.status',$criteria['startup.status']);
            unset($criteria['startup.status']);
        }
        $this->db->select("startup.*,admin.name AS admin_name",false);
        $this->db->join('admin',"admin.id=startup.adminapprove");
        $query=$this->db->get_where('startup',$criteria);
        return $query->result_array();
    }
    function deleted($admin,$criteria){
        if(count($criteria['status'])>1){
            $this->db->where_in('status',$criteria['status']);
            unset($criteria['status']);
        }
        $this->db->update("startup",array("status"=>"removed","dateremove"=>date('y-m-d H:i:s'),'adminapprove'=>$admin),$criteria);
        $this->db->affected_rows();
    }
}
?>