<h2><?php echo $title ?></h2>
<hr>
<?php if ($user_info) : ?>
<a href="<?php echo base_url('welcome/logout'); ?>">logout</a>
<?php else : ?>
<a href="<?php echo base_url('welcome/login'); ?>">login</a>
<hr>
<?php endif; ?>


<hr>
<?php
print_r($user_info);
?>