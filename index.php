<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Price Family History</title>
    <link rel="stylesheet" href="./styles/main.css">
    <link rel="icon" type="image/x-icon" href="./images/tree-of-life-drawing-celtic-style-gold.png">
</head>

<body>
    <header class="home-page">
        <a class="logo" href="index.php">
            <img src="./images/tree-of-life-drawing-celtic-style-gold.png" alt="A picture of a golden tree"></a>
        <a href="index.php">
            <h1>Price Family History</h1>
        </a>
        <nav>
            <ul>
                <li><a href="./stories.php">Stories</a></li>
                <li><a href="./people.php">People</a></li>
                <li><a href="./about.php">About</a></li>
                <li><a href="./admin/admin.php">Login</a></li>
            </ul>
            <hr />
        </nav>
    </header>
    <main>
        <div id="welcome" class="home-block">
            <a href="./about.php">
                <img src="./images/port-of-Lubek.jpg" alt="#">
                <h2>Welcome</h2>
            </a>
        </div>
        <div id="stories" class="home-block">
            <a href="./stories.php">
                <img src="./images/perrin-elementary.jpg" alt="#">
                <h2>View Stories</h2>
            </a>
        </div>
        <div id="people" class="home-block">
            <a href="./people.php   ">
                <img src="./images/Minnie.jpg" alt="#">
                <h2>View People</h2>
            </a>
        </div>
        <div id="add-new" class="home-block">
            <a href="./admin/admin.php">
                <img src="./images/village-map.jpg" alt="#">
                <h2>Add New Memories</h2>
            </a>
        </div>
    </main>
</body>
<?php
require_once "./includes/elements/footer.php";
?>

</html>