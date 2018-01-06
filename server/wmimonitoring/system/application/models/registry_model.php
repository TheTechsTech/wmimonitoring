<?
class Registry_model extends Model {
	function addkey($data){
        $data['dateadded']=date("y-m-d H:i:s");
		$this->db->insert("registry_key",$data);
        return $this->db->affected_rows();
	}
	function getbyid($id){
        $this->db->where("id",$id);
		return $this->db->get("registry_key");
	}
	function getall(){
        $this->db->select("registry_key.id,registry_key.hive,registry_key.path,registry_key.arch,registry_key.dateadded,admin.username as addedby");
        $this->db->from("registry_key");
        $this->db->join("admin","registry_key.addedby = admin.id");
		return $this->db->get();
	}
    function getbyarch($arch){
        $arch=($arch=="x86")?"x32":"x64";
        return $this->db->get_where("registry_key",array('arch'=>$arch));
    }
	function remove($id){
		$this->db->delete("registry_key",array("id"=>$id));
        return $this->db->affected_rows();
	}
	function update($id,$data){
        $data['dateadded']=date("y-m-d H:i:s");
		$this->db->update('registry_key', $data, array("id"=>$id));
        return $this->db->affected_rows();
        //return $this->db->last_query();
	}
    function add_trace($data){
        $data['dateadded']=date("y-m-d H:i:s");
        $data['loginby']=$this->get_last_user($data['Hostname']);
        $this->db->insert('registry_trace',$data);
    }
    function get_last_user($hostname){
        $this->db->select("username");
        $this->db->from("user_login");
        $this->db->where("hostname",$hostname);
        $this->db->order_by("id","desc");
        $this->db->limit(1);
        $query=$this->db->get();
        if($query->num_rows()>0)
            $result=$query->row_array(0);
        return $result["username"];
    }
    function get_trace_by_id($id){
        $this->db->select('registry_trace.*,computer.admin',false);
        $this->db->join('computer',"computer.hostname=registry_trace.hostname AND computer.status='added'");
        $query=$this->db->get_where('registry_trace',array('registry_trace.id'=>$id));
        return $query->result_array();
    }
    function get_log_by_id($id){
        $query=$this->db->get_where('log_monitoring',array('id'=>$id,'type'=>'registry_trace'));
        return $query->result_array();
    }
    function change_status($id,$status,$admin){
        $this->db->update('registry_trace',array('status'=>$status,'confirmby'=>$admin),array('id'=>$id));
        return $this->db->affected_rows();
    }
    function get_trace($criteria){
        if(isset($criteria['year'])){
            $this->db->where('YEAR(registry_trace.dateadded)',$criteria['year'],false);
            unset($criteria['year']);
        }
        if(isset($criteria['month'])){
            $this->db->where('MONTH(registry_trace.dateadded)',$criteria['month'],false);
            unset($criteria['month']);
        }
        foreach($criteria as $key=>$value)
            $criteria1['registry_trace.'.$key]=$value;
        $this->db->join('admin','registry_trace.confirmby=admin.id');
        $this->db->select('registry_trace.*,admin.name',false);
        $query=$this->db->get_where('registry_trace',$criteria1);
        return $query->result_array();
    }
}
 ?>