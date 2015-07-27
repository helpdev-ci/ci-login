<?php
if ($session_info['code'] != 200) {
    $title = $session_info['code'] . " - " . $session_info['msg'];
}
?>

<h2><?php echo $title ?></h2>
<div id="account-info">
    <?php
    if ($session_info['code'] != 200) {
        ?>
        <a href="signup">Sign Up</a> | <a href="login">Login</a>
        <?php
    } else {
        ?>
        <a href="account">My</a> | <a href="logout">Logout</a>
        <?php
    }
    ?>
</div>

    <?php
    if ($session_info['code'] == 200) {

        print_r($session_info);
    } else {
        print_r($session_info['value']);
    }
    ?>
