<?php
require_once('include/main.php');

$data = array();


$groups = $db
    ->where('gid', "0")
    ->orderBy('sort','asc')
    ->get('`group`');

if($db->count > 0) {
    foreach($groups as $nr => $group) {
        
        $subgroups = $db
            ->where('gid', $group['id'])
            ->orderBy('sort','asc')
            ->get('`group`');
        
        if($db->count > 0) {
            
            foreach($subgroups as $nnr => $subgroup) {
                
                $games = $db
                    ->where('gid', $subgroup['id'])
                    ->orderBy('date','asc')
                    ->orderBy('time','asc')
                    ->get('`game`');
                
                if($db->count > 0) {
                    
                    foreach($games as $gnr => $game) {
                        
                        $hteam = $db
                            ->where('id', $game['h_team_id'])
                            ->getOne('`team`');
                        
                        $vteam = $db
                            ->where('id', $game['v_team_id'])
                            ->getOne('`team`');
                        
                        $games[$gnr]['v_team'] = $vteam;
                        
                        $games[$gnr]['h_team'] = $hteam;
                    }
                    
                    $subgroups[$nnr]['games'] = $games;
                }
                
                $teams = $db
                    ->where('gid', $subgroup['id'])
                    ->where('hidden', 0)
                    ->orderBy('sort','asc')
                    ->get('`team`');

                if($db->count > 0) {
                    $subgroups[$nnr]['teams'] = $teams;
                } else {
                    $subgroups[$nnr]['teams'] = "";
                }
            }
            
            $groups[$nr]['subgroups'] = $subgroups;
        } else {
            $groups[$nr]['subgroups'] = null;
        }
    }
    //$data['debug'] = $groups;
    $data['groups'] = $groups;
}

$data['title'] = "Предстоящи мачове";

loadTemplate("games", $data);

?>
