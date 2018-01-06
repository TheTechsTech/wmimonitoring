<?
class Computer_model extends Model {
	function audit($data){
        $this->db->where($data);
        $this->db->where_in('status',array('new','added'));
        $result=$this->db->get('computer');
		$output="";
		if($result->num_rows()==0){
			$result=$this->db->get_where("computer",array('hostname'=>$data['Hostname']));
			if($result->num_rows()==0){
				$this->add_new($data);
				$output="new";
			}			
			else{
				$this->remove($data['Hostname']);
                $this->add_new($data);
				$output="new";
			}						
		}
		else
			$output=$result->result_array();
		return $output;
	}
    function loguser($data){
        $data['timelogin']=date("y-m-d H:i:s");
        $this->db->insert('user_login',$data);
    }
    function get_status($criteria){
        $query=$this->db->get_where('computer_status',$criteria);
        return $query->result_array();
    }    
    function get_user($hostname){
        $this->db->get_where("user_login",array("hostname"=>$hostname));
    }
	function add_new($data){
        $data['dateadded']=date("y-m-d H:i:s");
        $this->db->insert("computer",$data);
		//$this->db->insert("log_computer",array("hostname"=>$data['Hostname'],'date'=>date('y-m-d H:i:s'),"type"=>"add"));
	}
    function get_log(){
        return $this->db->get('log_computer');
    }
    function get_by_id($id){
        $query=$this->db->get_where('computer',array('id'=>$id));
        if($query->num_rows()==1){
            $row=$query->row_array();
            return $row;
        }
        else
            return false;
    }
    function get_log_detail($id){
        $this->db->select('*');
        $this->db->from('log_computer');
        $this->db->join('computer','log_computer.hostname = computer.hostname');
        $this->db->where('log_computer.id',$id);
    }
    function update_status($data,$id,$adminapprove){
        $query=$this->db->get_where('computer',array('id'=>$id));
        if(count($query->result_array())==0){
            return 0;
        }
        else{
            $result=$query->result_array();
            if($result[0]['status']=='new')
                return $this->approve_add($id,$data,$adminapprove);
            else
                return $this->approve_remove($id,$data,$adminapprove);
        }
    }
    function set_admin($hostname,$admin){
        $this->db->update("computer",array('admin'=>$admin),array('hostname'=>$hostname,'status'=>'added'));
        return $this->db->affected_rows();
    }
    function set_profile($hostname,$profile){
        $this->db->update('computer',array('computer_profile'=>$profile),array('hostname'=>$hostname,'status'=>'added'));
        return $this->db->affected_rows();
    }
	function remove($hostname){
        $this->db->where('hostname',$hostname);
        $this->db->where_in('status',array('new','added'));
        $this->db->update("computer",array("status"=>'remove','dateremove'=>date("y-m-d H:i:s")));
        return $this->db->affected_rows();

	}
	function getbyhostname($hostname,$status=null){
        if($status==null)
            return $this->db->get_where("computer",array("hostname"=>$hostname));
        elseif($status=='active'){
            $this->db->where('hostname',$hostname);
            $this->db->where_in('status',array('added','remove'));
            return $this->db->get('computer');
        }
        else{
            $this->db->where('hostname',$hostname);
            $this->db->where_in('status',array('new','removed'));
            return $this->db->get('computer');
        }
	}
    function approve_remove($id,$data,$admin_approve){
        $this->db->update('computer',array('status'=>'removed','admin'=>$admin_approve,'reason'=>$data['reason']),array('id'=>$id));
        return $this->db->affected_rows();
    }
    function get_all($approve=false,$admin=null){
        if($approve)
            $this->db->where('status','added');
        if($admin!=null)
            $this->db->where('admin',$admin);
        return $this->db->get('computer');
    }
    function approve_add($id,$data,$admin_approve){
        $this->db->update('computer',array('status'=>'added','admin'=>$data['admin'],'adminapprove'=>$admin_approve),array('id'=>$id));
        return $this->db->affected_rows();
    }
    function update_last_time_hw_audit($hostmane){
        $date=date("y-m-d H:i:s");
        $this->db->update('computer',array('last_time_hw_audit'=>$date),array('hostname'=>$hostmane));
    }
    function update_last_time_sw_audit($hostmane){
        $date=date("y-m-d H:i:s");
        $this->db->update('computer',array('last_time_sw_audit'=>$date),array('hostname'=>$hostmane));
    }
    function get($criteria){
        if(isset($criteria['dateremove'])){
            $this->db->where('computer.dateremove >=',$criteria['dateremove'][0]);
            $this->db->where('computer.dateremove <',$criteria['dateremove'][1]);
            unset($criteria['dateremove']);
        }
        if(isset($criteria['dateadded'])){
            $this->db->where('computer.dateadded >=',$criteria['dateadded'][0]);
            $this->db->where('computer.dateadded <',$criteria['dateadded'][1]);
            unset($criteria['dateadded']);
        }
        if(isset($criteria['status'])){
            if(count($criteria['status'])>1){
                $this->db->where_in('computer.status',$criteria['status']);
                unset($criteria['status']);
            }
        }
        foreach ($criteria as $key => $value) {
            $criteria['computer.'.$key]=$value;
            unset ($criteria[$key]);
        }
        $this->db->select("computer.*,CONCAT(computer_profile.name,'-',computer_profile.admin) AS computer_profile_name,admin.name AS admin_name",false);
        $this->db->join('computer_profile','computer_profile.id=computer.computer_profile');
        $this->db->join('admin','admin.id=computer.admin');
        $query=$this->db->get_where('computer',$criteria);
        return $query->result_array();
    }
    function deleted($criteria,$admin){
        $this->db->update('computer',array('status'=>'removed','admin'=>$admin,'dateremove'=>date("y-m-d H:i:s"),'reason'=>'Broken Computer'),$criteria);
        $this->db->affected_rows();
    }
    function get_profile($criteria){
        $query=$this->db->get_where('computer_profile',$criteria);
        return $query->result_array();
    }
}
