<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Hardware_model extends Model{
var $item;
	function audit($data){
        $data_status=$data;
        $data_status['status']='added';
		$this->db->update($this->item,array("flag"=>1),$data_status);
		if($this->db->affected_rows()==0)
			$this->add_new($data);
	}
	function add_new($data){
        $data['dateadded']=date('y-m-d H:i:s');
		$this->db->insert($this->item,$data);
		//$this->db->insert("log_hardware",array("hostname"=>$data["Hostname"],"item"=>$this->item,'date'=>date('y-m-d H:i:s'),"type"=>"add","reference"=>$this->db->insert_id()));
	}
	function auditend($hostname){
		$result=$this->db->get_where($this->item,array("hostname"=>$hostname,"flag"=>0,'status'=>'added'));
		foreach ($result->result() as $row){
    		$this->remove($row->id,$hostname);
		}
        $this->db->update($this->item,array('flag'=>0),array('hostname'=>$hostname));
	}
	function remove($id,$hostname){
		$this->db->where("id",$id);
		$this->db->update($this->item,array("status"=>"remove","dateremove"=>date('y-m-d H:i:s')));		
	}	
	function approve_change($id,$admin){
        $query=$this->db->get_where($this->item,array('id'=>$id));
        $data=$query->result_array();
        if(count($data)==1){
            if($data[0]['status']=='new')
                $this->db->update($this->item,array("status"=>"added",'adminapprove'=>$admin),array('id'=>$id));
            if($data[0]['status']=='remove')
                $this->db->update($this->item,array("status"=>"removed",'adminapprove'=>$admin),array('id'=>$id));
        }
        return $this->db->affected_rows();
    }
    function ignore_change($id,$admin){
        $query=$this->db->get_where($this->item,array('id'=>$id));
        $data=$query->result_array();
        if(count($data)==1){
            if($data[0]['status']=='new')
                $this->db->update($this->item,array("status"=>"ignored",'adminapprove'=>$admin),array('id'=>$id));
            else if($data[0]['status']=='remove')
                $this->db->update($this->item,array("status"=>"added",'adminapprove'=>$admin),array('id'=>$id));
            return $this->db->affected_rows();
        }
        else
            return 0;
    }
    function get_log($admin=null){
        if($admin==null)
            $query=$this->db->get('log_hardware');
        else{
            $query=$this->db->get_where('log_hardware',array('admin'=>$admin));
        }
        return $query->result_array();
    }
    function get_detail($id,$item){
        $this->item=$item;
        $query=$this->db->get_where($this->item,array('id'=>$id));
        return $query->result_array();
    }
    function get_log_by_id($id){
        $query=$this->db->get_where('log_hardware',array('id'=>$id,'item'=>$this->item));
        return $query->result_array();
    }
    function get($criteria){
        if(isset($criteria['dateadded'])){
            $this->db->where($this->item.'.dateadded >=',$criteria['dateadded'][0]);
            $this->db->where($this->item.'.dateadded <',$criteria['dateadded'][1]);
            unset($criteria['dateadded']);
        }
        if(isset($criteria['dateremove'])){
            $this->db->where($this->item.'.dateremove >=',$criteria['dateremove'][0]);
            $this->db->where($this->item.'.dateremove <',$criteria['dateremove'][1]);
            unset($criteria['dateremove']);
        }
        if(count($criteria['status'])>1){
            $this->db->where_in($this->item.'.status',$criteria['status']);
            unset($criteria['status']);
        }
        foreach ($criteria as $key=>$value)
            $criteria1[$this->item.'.'.$key]=$value;
        if(!isset($criteria1))
            $criteria1=array();
        $this->db->select($this->item.".*,admin.name AS admin_name",false);
        $this->db->join('admin',"admin.id=".$this->item.".adminapprove");
        $query=$this->db->get_where($this->item,$criteria1);
        return $query->result_array();
    }
    function deleted($admin,$criteria){
        if(count($criteria['status'])>1){
            $this->db->where_in('status',$criteria['status']);
            unset($criteria['status']);
        }
        $this->db->update($this->item,array("status"=>"removed","dateremove"=>date('y-m-d H:i:s'),'adminapprove'=>$admin),$criteria);
        $this->db->affected_rows();
    }
}
