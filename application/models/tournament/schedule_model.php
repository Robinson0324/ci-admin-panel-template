<?php
//Hash class load
require_once FCPATH."/ui/server/class-phpass.php";

class schedule_model extends CI_Model {

    private $table="tournament_tb";
    private $team_table="team_tb";
    private $schedule_table="play_schedule_tb";
    function __construct()
    {
        parent::__construct();
    }
    public function CreateSchedule($data){
        if(!isset($data["tourn_id"]))
            return false;
        if(!isset($data["group_count"]))
            return false;
        if(!isset($data["group_round_count"]))
            return false;


        for($group_num=1 ;$group_num<=intval($data["group_count"]) ;$group_num++){
            $condition=array();
            $condition['group_id']=$group_num;
            $condition['tourn_id']=$data["tourn_id"];
            $this->db->where($condition);
            $this->db->select("team_id,team_name,tourn_id");
            $res=$this->db->get($this->team_table);
            if($res && $res->num_rows()>0){
                $schedule_array=array();
                //make schedule
                for($index=0;$index<count($res->result())-1;$index++){
                    $first=$res->result()[$index];
                    for($next=$index+1;$next<count($res->result());$next++){
                        $second=$res->result()[$next];
                        $schedule_array[]=array('first_team_id'=>$first->team_id,
                            'last_team_id'=>$second->team_id,
                            'tourn_id'=>$data["tourn_id"],
                            'group_id'=>$group_num,
                            'level'=>1
                        );
                    }
                }

                // order decide
                $schedule_data=array();
                $count=count($schedule_array)%2>0 ? intval(count($schedule_array)/2)+1 : count($schedule_array)/2;

                for($index=0;$index<$count;$index++){
                    $first_play=$schedule_array[$index];
                    $schedule_data[]=$first_play;

                    $second=count($schedule_array)-$index-1;
                    if($second>$index)
                    {
                        $second_play=$schedule_array[$second];
                        $schedule_data[]=$second_play;
                    }

                }

                //==========round 2 schedule========
                $schedule_data2=array();
                for($index=0;$index<count($schedule_data);$index++){
                    $first_play=$schedule_data[$index];
                    $schedule_data2[]=array('first_team_id'=>$first_play['last_team_id'],
                        'last_team_id'=>$first_play['first_team_id'],
                        'tourn_id'=>$first_play["tourn_id"],
                        'group_id'=>$first_play["group_id"],
                        'level'=>1
                    );

                }
                //=========make schedule count by group_round_count========
                $round_schedule_array=array();
                $round_schedule_array[]=$schedule_data;
                $round_schedule_array[]=$schedule_data2;

                for($index=0;$index<intval($data["group_round_count"]);$index++){
                    $round_schedule_number= $index % 2;
                    $schedule=$round_schedule_array[$round_schedule_number];
                    $this->insertSchedule_Array($schedule);
                }

            }
        }
        return true;
    }
    public function CreateFinalPlaySchedule($tourn_id){
        $this->db->where(array('tourn_id'=>$tourn_id));
        $res=$this->db->get($this->table);
        if($res && $res->num_rows()>0)
        {
            $team_list=array();
            $tournament_info=$res->result()[0];
            $group_count=2;//intval($tournament_info->group_count);
            for($group_no=1; $group_no <=$group_count; $group_no++){
                $condition=array();
                $condition['tourn_id']=$tourn_id;
                $condition['group_id']=$group_no;
                $condition['level']=2;
                $team_res=$this->db->get_where($this->schedule_table,$condition);
                if($team_res && $team_res->num_rows()>0){
                    //print_r($team_res->result());
                    $team_list[]=$this->getPlayOffWinTeam($team_res->result()[0]);
                }
            }
            $schedule=array();
            $schedule[]=array('first_team_id'=>$team_list[0],
                'last_team_id'=>$team_list[1],
                'tourn_id'=>$tourn_id,
                'group_id'=>0,
                'level'=>3
            );
            //print_r($schedule);
            $this->insertSchedule_Array($schedule);
            return true;
        }//if

        return false;
    }


    public  function set_play_result($data){
        $this->db->where(array('schedule_id'=>$data['schedule_id'],'status'=>0));
        $res=$this->db->get($this->schedule_table);
        if($res && $res->num_rows()===0)
            return false;


        $this->db->where(array('schedule_id'=>$data['schedule_id'],'status'=>0));
        if($this->db->update($this->schedule_table,$data)){
            $this->db->where(array('schedule_id'=>$data['schedule_id'],'status'=>1));
            $res=$this->db->get($this->schedule_table);
            return $res->result()[0];
        }
        return false;
    }
    public  function set_playoff_result($data){

        $this->db->where(array('schedule_id'=>$data['schedule_id'],'status'=>0));
        $res=$this->db->get($this->schedule_table);
        if($res && $res->num_rows()===0)
            return false;


        $this->db->where(array('schedule_id'=>$data['schedule_id']));
        if($this->db->update($this->schedule_table,$data)){
            $this->db->where(array('schedule_id'=>$data['schedule_id'],'status'=>1));
            $res=$this->db->get($this->schedule_table);
            return $res->result()[0];
        }
        return false;
    }
    public  function is_play_finish($data){
        $this->db->where(array('level'=>$data['level'],'tourn_id'=>$data['tourn_id'],'status'=>0));
        $res=$this->db->get($this->schedule_table);
        if($res && $res->num_rows()===0)
            return true;
        return false;
    }
    public  function is_playoff_group_finish($data){
        $this->db->where(array('level'=>$data->level,'tourn_id'=>$data->tourn_id,'group_id'=>$data->group_id,'status'=>0));
        $res=$this->db->get($this->schedule_table);
        if($res && $res->num_rows()===0)
            return true;
        //======================
        $this->db->where(array('tourn_id'=>$data->tourn_id));
        $res=$this->db->get($this->table);
        if($res && $res->num_rows()>0)
        {
            $group_team_list=array();
            $tournament_info=$res->result()[0];
            $playoff_round_count=intval($tournament_info->playoff_round_count);

            $first_win_count=$this->get_playoff_team_win($data->first_team_id);
            $last_win_count=$this->get_playoff_team_win($data->last_team_id);
            //echo "first_win_count=".$first_win_count;
            //echo "last_win_count=".$last_win_count;
            if($this->is_complete_playoff($first_win_count,$last_win_count,$playoff_round_count))
            {
                $this->db->where(array('level'=>$data->level,'tourn_id'=>$data->tourn_id,'group_id'=>$data->group_id,'status'=>0));
                $this->db->update($this->schedule_table,array('status'=>1));
                return true;
            }
        }


        return false;
    }
    public function CreatePlayOffSchedule($tourn_id){
        $this->db->where(array('tourn_id'=>$tourn_id));
        $res=$this->db->get($this->table);
        if($res && $res->num_rows()>0)
        {
            $group_team_list=array();
            $tournament_info=$res->result()[0];
            $group_count=intval($tournament_info->group_count);
            for($group_no=1; $group_no <=$group_count; $group_no++){
                $condition=array();
                $condition['tourn_id']=$tourn_id;
                $condition['group_id']=$group_no;
                $team_res=$this->db->get_where($this->team_table,$condition);
                if($team_res && $team_res->num_rows()>0){
                    //print_r($team_res->result());
                    $group_team_list[$group_no]=$this->get_team_order($team_res->result());
                }
            }
            //print_r($group_team_list);
            if($group_count==2){
                $schedule_array=array();
                $schedule_array1=array();
                $team=$group_team_list[1][0];// 1 of group 1
                $team1=$group_team_list[2][1];// 2 og group 2
                $schedule_array[]=array('first_team_id'=>$team->team_id,
                    'last_team_id'=>$team1->team_id,
                    'tourn_id'=>$tourn_id,
                    'group_id'=>1,
                    'level'=>2
                );
                $schedule_array1[]=array('first_team_id'=>$team1->team_id,
                    'last_team_id'=>$team->team_id,
                    'tourn_id'=>$tourn_id,
                    'group_id'=>1,
                    'level'=>2
                );

                $team=$group_team_list[1][1];// 2 of group 1
                $team1=$group_team_list[2][0];// 1 og group 2
                $schedule_array[]=array('first_team_id'=>$team->team_id,
                    'last_team_id'=>$team1->team_id,
                    'tourn_id'=>$tourn_id,
                    'group_id'=>2,
                    'level'=>2
                );
                $schedule_array1[]=array('first_team_id'=>$team1->team_id,
                    'last_team_id'=>$team->team_id,
                    'tourn_id'=>$tourn_id,
                    'group_id'=>2,
                    'level'=>2
                );
                $round_schedule_array=array();
                $round_schedule_array[]=$schedule_array;
                $round_schedule_array[]=$schedule_array1;

                for($index=0;$index<intval($tournament_info->playoff_round_count);$index++){
                    $round_schedule_number= $index % 2;
                    $schedule=$round_schedule_array[$round_schedule_number];
                    $this->insertSchedule_Array($schedule);
                }
                return true;
            }//if
        }
        return false;
    }
    public  function get_tournament_schedule($data){
        $this->db->where($data);
        $this->db->order_by("group_id","asc");
        $res=$this->db->get($this->schedule_table);
        if($res && $res->num_rows()===0)
            return false;
        return $this->getScheduleInfoWithTeamName($res);
        //return $res->result();

    }

    public  function getTeamPlayoffInfo($data){
        $this->db->where($data);
        $res=$this->db->get($this->schedule_table);
        if($res && $res->num_rows()===0)
            return false;

        return $this->getScheduleInfoWithTeamName($res);

    }
    private  function insertSchedule_Array($data){
        $this->db->insert_batch($this->schedule_table,$data);
    }
    private function get_team_order($team_list,$point=0){
        $team_order_list=array();
        $count=count($team_list);
        for($i=0;$i<$count-1;$i++){
           $team=$team_list[$i];
           for($j=$i+1 ;$j<$count;$j++){
               $team1=$team_list[$j];
               $cmp=intval($team->team_point);
               $cmp1=intval($team1->team_point);

               if($cmp<$cmp1){
                    $team_list[$i]=$team1;
                    $team_list[$j]=$team;
               }
               else if($cmp===$cmp1){
                   $point++;
                   if($this->get_teams_compare($team,$team1,$point)==="2"){
                       $team_list[$i]=$team1;
                       $team_list[$j]=$team;
                   }
               }
           }
        }
        return $team_list;
    }
    private function get_teams_compare($team,$team1,$point){
        $cmp=0;
        $cmp1=0;

        if($point===1){
            $cmp=intval($team->team_goal_diff);
            $cmp1=intval($team1->team_goal_diff);
        }
        else if($point===2){
            $cmp=intval($team->team_goal_made);
            $cmp1=intval($team1->team_goal_made);
        }

        else{
            return "1";//
        }
        $point++;

        if($cmp>$cmp1)
            return "1";
        else if($cmp===$cmp1)
           return $this->get_teams_compare($team,$team1,$point);

        return "2";
    }

    private function get_playoff_team_win($teamId){
        $first_win_count=0;
        $query="select * from $this->schedule_table where `level`=2 and ((first_team_id=$teamId and first_team_goal>last_team_goal) or (last_team_id=$teamId and first_team_goal<last_team_goal))";
        $res=$this->db->query($query);
        if($res)
            $first_win_count=$res->num_rows();

        return $first_win_count;
    }
    private function get_playfinal_team_win($teamId){
        $first_win_count=0;
        $query="select * from $this->schedule_table where `level`=3 and ((first_team_id=$teamId and first_team_goal>last_team_goal) or (last_team_id=$teamId and first_team_goal<last_team_goal))";
        $res=$this->db->query($query);
        if($res)
            $first_win_count=$res->num_rows();

        return $first_win_count;
    }
    private function is_complete_playoff($first_win_count,$last_win_count,$playoff_round_count){
        if($playoff_round_count===1)
        {
            if($first_win_count===1 || $last_win_count===1)
                return true;
            else
                return false;
        }
        if($playoff_round_count===3)
        {
            if($first_win_count===2 || $last_win_count===2)
                return true;
            else
                return false;
        }
        if($playoff_round_count===5)
        {
            if($first_win_count===3 || $last_win_count===3)
                return true;
            else
                return false;
        }
        if($playoff_round_count===7)
        {
            if($first_win_count===4 || $last_win_count===4)
                return true;
            else
                return false;
        }
        return false;
    }


    public function getPlayOffWinTeam($data){
        $win_team_id=0;
        $first_win_count=$this->get_playoff_team_win($data->first_team_id);
        $last_win_count=$this->get_playoff_team_win($data->last_team_id);
        $win_team_id    =   $first_win_count>$last_win_count ? $data->first_team_id: $data->last_team_id;
        return $win_team_id;
    }
    public function getPlayFinalWinTeamInfo($data){
        $win_team_id=0;
        $win_team_name='';
        if(is_object($data)){
            $first_win_count=$this->get_playfinal_team_win($data->first_team_id);
            $last_win_count=$this->get_playfinal_team_win($data->last_team_id);
            $win_team_id    =   $first_win_count>$last_win_count ? $data->first_team_id: $data->last_team_id;
            $win_team_name    =   $this->getTeamNameFromTeamID($win_team_id);
        }
        else{
            $first_win_count=$this->get_playfinal_team_win($data["first_team_id"]);
            $last_win_count=$this->get_playfinal_team_win($data["last_team_id"]);
            $win_team_id    =   $first_win_count>$last_win_count ? $data["first_team_id"]: $data["last_team_id"];
            $win_team_name    =   $first_win_count>$last_win_count ? $data["first_team_name"]: $data["last_team_name"];
        }

        return array("win_team_id"=>$win_team_id,"win_team_name"=>$win_team_name);
    }
    private function getScheduleInfoWithTeamName($res){
        $schedule_list=array();
        $team_ids=array();
        foreach($res->result() as $row){
            $schedule=(array)$row;
            $first_team_id=$row->first_team_id;
            $last_team_id=$row->last_team_id;

            if(!in_array($first_team_id,$team_ids)){
                $team_ids[]=$first_team_id;
            }
            if(!in_array($last_team_id,$team_ids)){
                $team_ids[]=$last_team_id;
            }
            $schedule_list[]=$schedule;
        }

        $str_ids=implode(',',$team_ids);
        $query="SELECT team_id,team_name FROM $this->team_table  WHERE team_id in ($str_ids)";
        $result=$this->db->query($query);
        if($result)
        {
            $team_info=array();
            foreach($result->result() as $row)
            {
                $team_info[$row->team_id]=$row->team_name;
            }
            for($i=0;$i<count($schedule_list);$i++){
                $schedule_list[$i]['first_team_name']=$team_info[$schedule_list[$i]['first_team_id']];
                $schedule_list[$i]['last_team_name']=$team_info[$schedule_list[$i]['last_team_id']];
            }
        }
        return $schedule_list;
    }
    private function getTeamNameFromTeamID($teamId){

        $query="SELECT team_id,team_name FROM $this->team_table  WHERE team_id=$teamId";
        $result=$this->db->query($query);
        if($result)
        {
            $team_info=array();
            foreach($result->result() as $row)
            {
                return $row->team_name;
            }
        }
        return "";
    }
}
?>
