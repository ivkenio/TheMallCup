<form class="form-signin" role="form" method="POST" action="<?=$_SERVER['PHP_SELF']?>">
    <h2 class="form-signin-heading">Добре дошли</h2>
    <input type="text" name="username" class="form-control" placeholder="Потребителско име" required="" value="<?=isset($_POST['username'])?$_POST['username']:''?>" autofocus="">
    <input type="password" name="password" class="form-control" placeholder="Парола" required="">
    
    <button class="btn btn-lg btn-primary btn-block" type="submit" name="action">Вход</button>
</form>
<style>
    #header {
        max-width: 482px;
        margin: auto;
    }
</style>