<?php

$page = "";
$page_title = "Admin";
require_once "../admin_header.php";



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