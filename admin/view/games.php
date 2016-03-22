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
                                                
                                                <?php loadView("games_table", array("group" => $subgroup)); ?>
                                                 
                                            </div>

                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                </div>

                                <?php endforeach; ?>
                            <?php endif; ?>
                            
                        </div>
                    </div>
                </div>
                <div  class="text-center">
                    <small>
                        За да промените някое от полетата в таблицата (Дата, час, резултат), просто натиснете върху него, въведете новата стойност и натиснете "OK"<br />
                        След като добавите или редактирате среща трябва да презаредите страницата за да се подредят срещите в хронологичен ред!<br /><br />
                    </small>
                </div>
            </div>
            <div class="spacer"></div>
        </div>
    </div>
</div>
<script src="js/games.js"></script>