<select name="<?=$name?>" class="team-name form-control">
    <?php if(isset($teams) && !empty($teams)): ?>
    
    <?php foreach($teams as $team): ?>
    
    <option value="<?=$team['id']?>"><?=$team['name']?></option>
    
    <?php endforeach; ?>
    
    <?php endif; ?>
</select>