<?
class Log_item extends Model {
	function approve($id){
		$query=$this->db->get_where("log_prob",array("id"=>$id));
		$ref="";
		if($query->num_rows()>0){
			$row=$query->result();
			$ref=$row->reference;
			$this->db->update("log_prob",array("id"=>$id),array("status"=>"approved"));			
		}
		return $ref;		
	}	
}
 ?>