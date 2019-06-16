<?php
    $menu = Router::getMenu('menu_acl'); 
    // dnd($menu);
    // dnd($_SESSION);
    $currentPage = currentPage();
?>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main_menu" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>      
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="<?=PROOT?>" class="navbar-brand"><?=MENU_BRAND?></a>
        </div>
    
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="main_menu">
            <ul class="nav navbar-nav">
                <?php foreach($menu as $key => $val): 
                    $active = ''; ?>
                    <?php if(is_array($val)): ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?=$key?> <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <?php foreach($val as $k => $v): 
                                    $active = ($v == $currentPage)?'active':''; ?>
                                    <?php if($k == 'separator'): ?>
                                        <li role="separator" class="divider"></li>
                                    <?php else: ?>
                                        <li><a class="<?=$active?>" href="<?=$v?>"><?=$k?></a></li>
                                    <?php endif ?>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php else: 
                        $active = ($val == $currentPage) ? 'active' : '';?>
                        <li><a class="<?=$active?>" href="<?=$val?>"><?=$key?></a></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if(currentUser()): ?>
                    <li><a href="#">Hello <?=currentUser()->fname?></a></li>
                <?php endif; ?>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>