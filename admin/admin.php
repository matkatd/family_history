<?php
$page_title = "Admin";
require_once "../includes/elements/header.php";
?>
<main>
    <form class="login-box">
        <div class="username">
            <label for="username">Enter your username:</label><br>
            <input id="username" placeholder="Username" type="text" class="login-input">
        </div>
        <div class="pass">
            <label for="passw">Enter your password:</label><br>
            <input id="passw" placeholder="Password" type="text" class="login-input">
        </div>
        <input class="submit-button" type="submit" value="Submit">
    </form>

</main>
</body>
<?php
require_once "../includes/elements/footer.php";
?>


</html>