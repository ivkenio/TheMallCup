<!-- Table -->
<table class="table" id="table-<?=$group['id']?>">
    <thead>
        <tr>
            <th>№</th>
            <th width="30%">Отбор</th>
            <th><span class="more">Мачове-Победи-Загуби-Равенства</span><span title="Мачове-Победи-Загуби-Равенства" class="less">(М-П-З-Р)</span></th>
            <th><span class="more">Голова Разлика</span><span title="Голова Разлика" class="less">(ГР)</span></th>
            <th><span class="more">Точки</span><span title="Точки" class="less">(Т)</span></th>
        </tr>
    </thead>
    <tbody>
        <?php if(isset($group['teams']) && !empty($group['teams'])): ?>

            <?php foreach($group['teams'] as $tnr => $team): ?>

            <tr id="row-<?=$team['id']?>">
                <td><?=($tnr+1)?></td>
                <td><?=$team['name']?></td>
                <td><?=$team['stats']?></td>
                <td><?=$team['goals']?></td>
                <td><?=$team['points']?></td>
            </tr>

            <?php endforeach; ?>
        <?php endif; ?>

    </tbody>
    <tfoot class="delete">
        <tr>
            <td colspan="5">Преместете тук отбор за да го изтриете! <span class="result"></span> 
                <div class="input-group pull-right team-add">
                    <input type="text" name="name" value="" placeholder="Име на отбор" class="team-name form-control" />
                    <span class="input-group-btn">
                        <button class="btn btn-success team-add-button" type="button"><span class="glyphicon glyphicon-plus"></span></button>
                    </span>
                </div><!-- /input-group -->
            </td>
        </tr>
    </tfoot>
</table>