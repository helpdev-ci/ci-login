<h2><?php echo $title ?></h2>
<?php print_r($user_info); ?>
<?php
$attributes = array('class' => 'email', 'id' => 'myform');
if ($message) {
    ?>
    <h2><?php echo $message; ?></h2>
    <?php
}
echo form_open(base_url('login'), array('class' => 'form', 'id' => 'myform','name' => 'myform'));
?>
<?php echo form_input(array('name' => 'username', 'id' => 'username', 'class' => 'name', 'target' => "Eaild")); ?>
<?php echo form_password(array('name' => 'password', 'id' => 'password', 'class' => 'password',)); ?>
<?php echo form_submit('', 'Sign Up', array('class' => 'submit-button', 'id' => 'submit','name' => 'submit')); ?>
<?php echo form_close(); ?>