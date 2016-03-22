<!-- Table -->
<?php if(isset($group['teams']) && !empty($group['teams'])): ?>
<table class="table" id="table">
    <thead>
        <tr>
            <th>№</th>
            <th width="50%">Среща</th>
            <th>Дата</th>
            <th>час</th>
            <th><span class="more">резултат</span><span title="резултат" class="less">(Рз)</span></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php if(isset($group['games']) && !empty($group['games'])): ?>

            <?php foreach($group['games'] as $gnr => $game): ?>

            <tr id="row-<?=$game['id']?>">
                <td><?=($gnr+1)?></td>
                <td><?=$game['h_team']['name']?> - <?=$game['v_team']['name']?></td>
                <td><?=$game['date']?></td>
                <td><?=substr($game['time'],0,5)?> ч.</td>
                <td><?=$game['score']?></td>
                <td><button class="btn btn-danger game-delete-button" type="button"><span class="glyphicon glyphicon-trash"></span></button></td>
            </tr>

            <?php endforeach; ?>
        <?php endif; ?>

    </tbody>
    <tfoot class="delete">
        <tr>
            <td></td>
            <td>
                <div class="row">
                    <div class="col-sm-6"> <?php loadView('team_select', array('name' => 'hteamid','teams'=> $group['teams'])); ?></div>
                    <div class="col-sm-6"> <?php loadView('team_select', array('name' => 'vteamid','teams'=> $group['teams'])); ?></div>
                </div>
            </td>
            <td><input type="date" name="date" value="<?=date('Y-m-d')?>" class="game-date form-control" /></td>
            <td><input type="time" name="time" value="15:00" class="game-time form-control" /></td>
            <td></td>
            <td><button class="btn btn-success game-add-button" type="button"><span class="glyphicon glyphicon-plus"></span></button></td>
        </tr>
    </tfoot>
</table>
<?php endif; ?>