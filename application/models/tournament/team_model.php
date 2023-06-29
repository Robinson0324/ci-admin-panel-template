<?php
//Hash class load
require_once FCPATH."/ui/server/class-phpass.php";

class team_model extends CI_Model {

    private $table="tournament_tb";
    private $team_table="team_tb";
    private $schedule_table="play_schedule_tb";
    function __construct()
    {
        parent::__construct();
    }
    public function CreateTeams($data){
        if(!isset($data["team_list"]))
            return false;
        if(!is_array($data["team_list"]))
            return false;
        if(count($data['team_list'])<1)
            return false;


        $group_count=count($data["team_list"])/intval($data['group_count']);
        $nIndex=0;
        foreach($data["team_list"] as $row){
            $team=array();
            $team["team_member_id"]=$row->member_id;
            $team["team_name"]=$row->team_name;
            $team["team_number"]=$row->team_number;

            $team["manager_member_id"]=$data['manager_member_id'];
            $team["tourn_id"]=$data['tourn_id'];

            $team["group_id"] = $nIndex<$group_count ? 1 : 2;

            $team["create_date"]=$data['create_date'];

            $res=$this->db->insert($this->team_table,$team);
            $nIndex++;
        }
        return true;
    }
    public function set_play_result($data){
        $first_team_id=$data['first_team_id'];
        $last_team_id=$data['last_team_id'];
        $first_team_goal=intval($data['first_team_goal']);
        $last_team_goal=intval($data['last_team_goal']);

        $query="update $this->team_table set ";
        $query .= "team_goal_made=team_goal_made+$first_team_goal ,team_goal_against=team_goal_against+$last_team_goal,team_played=team_played+1  ";

        $query1="update $this->team_table set ";
        $query1 .= "team_goal_made=team_goal_made+$last_team_goal ,team_goal_against=team_goal_against+$first_team_goal,team_played=team_played+1  ";
        $win_point=3;
        $tie_point=1;
        if($first_team_goal>$last_team_goal)
        {
            $query .= ",team_win=team_win+1";
            $query .= ",team_point=team_point+$win_point";
            $query1 .= ",team_loss=team_loss+1";
        }
        else if($first_team_goal===$last_team_goal){
            $query .= ",team_tie=team_tie+1";
            $query .= ",team_point=team_point+$tie_point";
            $query1 .= ",team_tie=team_tie+1";
            $query1 .= ",team_point=team_point+$tie_point";
        }
        else{
            $query1 .= ",team_win=team_win+1";
            $query1 .= ",team_point=team_point+$win_point";
            $query .= ",team_loss=team_loss+1";
        }

        $query .=" where team_id=$first_team_id";
        $query1 .=" where team_id=$last_team_id";

        $this->db->query($query);
        $this->db->query($query1);

        $query="update $this->team_table set team_goal_diff=team_goal_made-team_goal_against  where team_id=$first_team_id";
        $query1="update $this->team_table set team_goal_diff=team_goal_made-team_goal_against  where team_id=$last_team_id";
        $this->db->query($query);
        $this->db->query($query1);

        return true;
    }
    public function getTeamScheduleInfo($tourn_id){
        $this->db->where(array('tourn_id'=>$tourn_id));
        $this->db->order_by('team_point','desc');
        $this->db->order_by('team_goal_diff','desc');
        $this->db->order_by('team_goal_made','desc');
        $res=$this->db->get($this->team_table);
        if($res && $res->num_rows()>0){
            return $res->result();
        }
        return false;
    }
}
?>