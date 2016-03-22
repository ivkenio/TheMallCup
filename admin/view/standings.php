<style type="text/css">
    /* show the move cursor as the user moves the mouse over the panel header.*/
    div .panel .panel-heading {
        cursor: move;
    }
    .table tbody tr td:first-child {
        cursor: move;
    }
</style>
<div class="form">
    <div class="ss-form-box">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <ul class="nav panel-tabs">
                            
                            <?php if(isset($groups) && !empty($groups)): ?>
                            
                                <?php foreach($groups as $nr => $group): ?>
                            
                                <li <?=($nr==0?'class="active"':'')?>><a href="#tab<?=$group['id']?>" data-toggle="tab"><?=$group['name']?></a></li>
                                
                                <?php endforeach; ?>
                                
                            <?php endif; ?>
                                
                        </ul>
                        </span>
                    </div>
                    <div class="panel-body">
                        <div class="tab-content">
                            
                            <?php if(isset($groups) && !empty($groups)): ?>
                                <?php foreach($groups as $nr => $group): ?>
                                    
                                <div class="tab-pane<?=($nr==0?' active':'')?>" id="tab<?=$group['id']?>">

                                    <div class="panels">
                                    <?php if(isset($group['subgroups']) && !empty($group['subgroups'])): ?>
                                        <?php foreach($group['subgroups'] as $nnr => $subgroup): ?>

                                        <div class="panel panel-default" id="panel-<?=$subgroup['id']?>">

                                            <!-- Default panel contents -->
                                            <div class="panel-heading">
                                                <span class="glyphicon glyphicon-tower"></span> 
                                                <span class="gtitle"><?=$subgroup['name']?></span>
                                                <button class="btn btn-danger group-remove-button" type="button"><span class="glyphicon glyphicon-remove"></span></button>
                                                <button class="btn btn-warning group-change-button" type="button"><span class="glyphicon glyphicon-pencil"></span></button>
                                            </div>

                                            <?php loadView("stand_table", array("group" => $subgroup)); ?>

                                        </div>

                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    </div>
                                    <br />
                                    <div class="input-group pull-right group-add">
                                        <span class="input-group-btn">
                                            <button class="btn btn-success group-add-button" type="button"><span class="glyphicon glyphicon-plus"></span></button>
                                        </span>
                                        <input type="text" name="name" value="" placeholder="Име на група" class="group-name form-control" />
                                    </div><!-- /input-group -->

                                </div>

                                <?php endforeach; ?>
                            <?php endif; ?>
                            
                        </div>
                    </div>
                </div>
                <div  class="text-center">
                    <small>
                        За да промените някое от полетата в таблицата (Име, статистика, голова разлика, точки), просто натиснете върху него, въведете новата стойност и натиснете "OK"<br />
                        Можете да нареждане отборите като преместите дадена позиция. Хванете с мишката номера на отбора в класацията и го преместете на желаното място.<br />
                        Чрез преместване също може да пренаредите и групите. Хванете основата на таблицата, където е заглавието и преместете на желано от вас място.<br /><br />
                    </small>
                </div>
            </div>
            <div class="spacer"></div>
        </div>
    </div>
</div>
<script src="js/standing.js"></script>