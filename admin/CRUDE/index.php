<?php
session_start();
// Check if user is logged in, if not, redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ./../admin.php");
    exit;
}

$page_title = "Admin";
require_once "../../includes/elements/header.php";



?>
<main>
    <div class="admin-cont">
        <div class="admin-button"><a href="./add.php">Add New Story</a></div>
        <div class="admin-button"><a href="./listOfStories.php?signal=edit">Edit Existing Story</a></div>
        <div class="admin-button"><a href="./listOfStories.php?signal=remove">Remove Story</a></div>
    </div>
</main>
</body>
<?php
require_once "../../includes/elements/footer.php";
?>


</html>