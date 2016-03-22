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
                
                $teams = $db
                    ->where('gid', $subgroup['id'])
                    ->where('hidden', 0)
                    ->orderBy('sort','asc')
                    ->get('`team`');
                
                if($db->count > 0) {
                    $subgroups[$nnr]['teams'] = $teams;
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

$data['title'] = "Класиране";

loadTemplate("standings", $data);

?>
