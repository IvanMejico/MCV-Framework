<?php $this->start('head'); ?>
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<div class="col-md-6 col-md-offset-3 well">
    <form action="<?=PROOT?>register/login" class="form">
        <h3 class="text-center">Log In</h3>
        <div class="form-group">
            <label for="username">User</label>
            <input type="text" name="username" id="username" class="form-control">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
        <div class="form-group">
            <label for="remember_me">Remember me 
                <input type="checkbox" name="remember_me" id="remember_me" value="on">
            </label>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-large btn-primary" value="Login">
        </div>
        <div class="text-right">
            <a href="<?=PROOT?>register/register" class="text-primary">Register</a>
        </div>
    </form>
</div>
<?php $this->end(); ?>