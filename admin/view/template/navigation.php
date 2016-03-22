<div id="header">
    <?php if(!isset($hidenav) || $hidenav == false): ?>
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
                <li <?=active('index.php')?>><a href="index.php">Index</a></li>
                <li <?=active('standings.php')?>><a href="standings.php">Standings</a></li>
                <li <?=active('games.php')?>><a href="games.php">Games</a></li>
                <li <?=active('logout.php')?>><a href="logout.php">Logout</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
    <?php endif; ?>
    <img src="../images/cup.png" alt="THE MALL CUP 2016 | Регистрационна форма" /><h1><?= isset($title) && !empty($title) ? $title : 'Administration'?></h1>
    <div id="spacer"></div>
</div>

<?php if(isset($error) && !empty($error)): ?>

<div class="alert alert-danger fade in">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <?=$error?>
</div>

<?php endif; ?>

<?php if(isset($warning) && !empty($warning)): ?>

<div class="alert alert-warning fade in">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <?=$warning?>
</div>

<?php endif; ?>

<?php if(isset($success) && !empty($success)): ?>

<div class="alert alert-success fade in">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <?=$success?>
</div>

<?php endif; ?>

<?php if(isset($debug) && !empty($debug)): ?>

<pre>
  <?php var_dump($debug); ?>
</pre>

<?php endif; ?>