<?php 
require_once('admin/include/config.php');
require_once('admin/classes/MysqliDb.php');
$db = new Mysqlidb(DB_HOST, DB_USER, DB_PASS, DB_NAME);


$groups = $db
    ->where('gid', "0")
    ->where('games_visible', 1)
    ->orderBy('sort','asc')
    ->get('`group`');

if($db->count > 0) {
    foreach($groups as $nr => $group) {
        
        $subgroups = $db
            ->where('gid', $group['id'])
            ->where('games_visible', 1)
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
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>THE MALL CUP 2016 | Uppcoming games</title>
        <meta name="description" content="Регистрация за THE MALL CUP 2016" />
        <meta name="viewport" content="width=device-width, user-scalable=no" />
        <meta name="keywords" content="the mall cup, турнир фунбол, the mall" />
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
        <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700&subset=latin,cyrillic,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css' />

        <!--[if gte IE 9]>
          <style type="text/css">
            .gradient {
               filter: none;
            }
          </style>
        <![endif]-->
        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet" />
        <link href="css/style.css" rel="stylesheet" type="text/css" />

    </head>
    <body>
        <div class="body">
            <div id="container">
                <div id="header">
                    <nav class="navbar navbar-inverse" role="navigation">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-9">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-9">
                            <ul class="nav navbar-nav">
                                <!--<li><a href="index.php">Регистрация</a></li>-->
                                <li class="active"><a href="games.php">Games</a></li>
                                <li><a href="standings.php">Standings</a></li>
                                <li><a href="prizes.php">Prizes</a></li>
                            </ul>
                        </div><!-- /.navbar-collapse -->
                    </nav>
                    <img src="images/cup.png" alt="THE MALL CUP 2016 | Uppcoming games" /><h1>Uppcoming games</h1>
                    <div id="spacer"></div>
                </div>

<div class="form">
    <div class="ss-form-box">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <ul class="nav panel-tabs">
                            
                            <?php if(isset($groups) && !empty($groups)): ?>
                            
                                <?php foreach($groups as $nr => $group): ?>
                            
                                <li <?=($nr==0?'class="active"':'')?>><a href="#tab<?=$nr?>" data-toggle="tab"><?=$group['name']?></a></li>
                                
                                <?php endforeach; ?>
                                
                            <?php endif; ?>
                                
                        </ul>
                        </span>
                    </div>
                    <div class="panel-body">
                        <div class="tab-content">
                            
                            <?php if(isset($groups) && !empty($groups)): ?>
                                <?php foreach($groups as $nr => $group): ?>
                                    
                                <div class="tab-pane<?=($nr==0?' active':'')?>" id="tab<?=$nr?>">

                                    <?php if(isset($group['subgroups']) && !empty($group['subgroups'])): ?>
                                        <?php foreach($group['subgroups'] as $nnr => $subgroup): ?>

                                            <div class="panel panel-default table-responsive" id="panel-<?=$subgroup['id']?>">
                                                
                                                <!-- Default panel contents -->
                                                <div class="panel-heading"><span class="glyphicon glyphicon-tower"></span> <?=$subgroup['name']?> </div>
                                                
                                                <!-- Table -->
                                                <?php if(isset($subgroup['teams']) && !empty($subgroup['teams'])): ?>
                                                <table class="table" id="table">
                                                    <thead>
                                                        <tr>
                                                            <th>№</th>
                                                            <th width="50%">Game</th>
                                                            <th>Date</th>
                                                            <th>Hour</th>
                                                            <th>Score</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if(isset($subgroup['games']) && !empty($subgroup['games'])): ?>

                                                            <?php foreach($subgroup['games'] as $gnr => $game): ?>

                                                            <tr id="row-<?=$game['id']?>">
                                                                <td><?=($gnr+1)?></td>
                                                                <td><?=$game['h_team']['name']?> - <?=$game['v_team']['name']?></td>
                                                                <td><?=$game['date']?></td>
                                                                <td><?=substr($game['time'],0,5)?> ч.</td>
                                                                <td><?=$game['score']?></td>
                                                            </tr>

                                                            <?php endforeach; ?>
                                                        <?php else: ?>

                                                            <tr>
                                                                <td>1</td>
                                                                <td>Няма мачове</td>
                                                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                                <td>&nbsp;&nbsp;&nbsp;</td>
                                                            </tr>
                                                        
                                                        <?php endif; ?>

                                                    </tbody>
                                                </table>
                                                <?php endif; ?>
                                                 
                                            </div>

                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                </div>

                                <?php endforeach; ?>
                            <?php endif; ?>
                            
                        </div>
                    </div>
                </div>
            <div class="ss-form-box">
                <label class=" ">
                    <div class="ss-q-title">
                        <a href="documents/Reglament_1.pdf" target="_blank">Регламент</a>
                    </div>
                </label>
                <label class=" offset1">
                    <div class="ss-q-title">
                        <a href="documents/prizes-themall-cup-2016.pdf" target="_blank">Награден фонд</a>
                    </div>
                </label>
                <label class=" offset1">
                    <div class="ss-q-title">
                        <a href="documents/Zdravna%20deklaraciq.pdf" target="_blank">Здравна декларация</a>
                    </div>
                </label>
                <label class="offset1">
                    <div class="ss-q-title">
                        <a href="documents/Deklaraciq%20roditelsko%20suglasie.pdf" target="_blank">Декларация родителско съгласие</a>
                    </div>
                </label>
                <div class="spacer"></div>
            </div>
            </div>
            <div class="spacer"></div>
        </div>
    </div>
</div>

                <div id="spacer"></div>
                <div id="footer">Copyright © THE MALL CUP 2016</div>
            </div>

        </div>
        <script src="js/jquery-1.11.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>