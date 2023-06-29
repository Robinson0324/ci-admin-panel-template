<?php
//Hash class load
require_once FCPATH."/ui/server/class-phpass.php";

class tournament_model extends CI_Model {

    private $table="tournament_tb";
    private $team_table="team_tb";
    private $schedule_table="play_schedule_tb";
    function __construct()
    {
        parent::__construct();
    }
    public function CreateTournament($data){
       return $this->db->insert($this->table,$data);
    }
    public function DeleteTournament($data){
        $tournament=$this->table;
        $team=$this->team_table;
        $schedule= $this->schedule_table;
        $tourn_id=$data['tourn_id'];
        $query="delete  from $tournament where  tourn_id=$tourn_id;";
        //$query .="delete  from $team where  tourn_id=$tourn_id;";
        //$query .="delete  from $schedule where  tourn_id=$tourn_id;";
        //echo $query;
        $res=$this->db->query($query);
        $query ="delete  from $team where  tourn_id=$tourn_id;";
        $res +=$this->db->query($query);
        $query ="delete  from $schedule where  tourn_id=$tourn_id;";
        $res +=$this->db->query($query);
        return $res;
    }
    public function getTournament($condition,$page=array(),$search_key=""){
        $this->db->where($condition);
        if($search_key!==""){
            $key=$search_key;
            $this->db->like("tourn_name",$key,"both");

        }
        if(isset($page['limit']) && isset($page['offset']))
            $this->db->limit($page['limit'],$page['offset']);

        $res=$this->db->get($this->table);
        if($res){
            if($res->num_rows()>0)
                return $res->result();

        }
        return array();
    }
    public function getInviteTournament($condition,$member_id,$page=array(),$search_key=""){

        $this->db->where($condition);
        if($search_key!==""){
            $key=$search_key;
            $this->db->like("tourn_name",$key,"both");

        }
        if(isset($page['limit']) && isset($page['offset']))
            $this->db->limit($page['limit'],$page['offset']);

        $res=$this->db->get($this->table);
        if($res){
            if($res->num_rows()>0)
            {
                $output=array();
                foreach($res->result() as $row){
                    $this->db->where(array('tourn_id'=>$row->tourn_id,'team_member_id'=>$member_id));
                    $tmp_res=$this->db->get($this->team_table);
                    if($tmp_res && $tmp_res->num_rows()>0)
                        $output[]=$row;
                }
                return $output;
            }

        }
        return array();
    }

}
?>