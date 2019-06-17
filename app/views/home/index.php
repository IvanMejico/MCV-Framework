<?php $this->start('body'); ?>
    <h1 class="text-center red">Welcome to Ruah MVC Framework!</h1>
    <?= inputBlock('text', 'Favorite Color:','favorite_color','red',['class'=>'form-control'],['class'=>'form-group']) ?>
    <?= submitBlock("Save", ['class'=>'btn btn-primary'], ['class'=>'text-right']); ?>
<?php $this->end(); ?>