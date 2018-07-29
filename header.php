<?php if (isset($_SESSION['login_user_name'])) { ?>
    <a href="logout.php">Logout</a>
    <?php
    echo "welcome " . $_SESSION['login_user_name'];
} else {
    echo "welcome Guest. ".'<a href="login.php">Login?</a>';
}
?>