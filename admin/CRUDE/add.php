<?php
session_start();

$page = "CRUDE";
//echo $_SERVER['DOCUMENT_ROOT'];
$home = "/project/family_history/index.php";
$stories = "/project/family_history/stories.php";
$people = "/project/family_history/people.php";
$admin = "/project/family_history/admin/admin.php";
$about = "/project/family_history/about.php";
$logo = "/project/family_history/images/tree-of-life-drawing-celtic-style-gold.png";
$css = "/project/family_history/styles/other.css";
$admin_link = "Login";
// Check if user is logged in, if not, redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ./../admin.php");
    exit;
} else if ($page !== "CRUDE") {
    $admin_link = "Logout";
    $admin = "/project/family_history/admin/logout.php";
} else {
    $admin_link = "Admin";
    $admin = "/project/family_history/admin/CRUDE/index.php";
}

spl_autoload_register(function ($class) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/project/family_history/includes/classes/{$class}.php";
});
# Get names of people from db
$allPeople = PeopleRecordCollection::getAll();
//var_dump($_POST);
$page_title = "Add New Story";

if (!empty($_POST)) {
    # 1 - Eliminate whitespace
    $summary = trim($_POST['summary']);
    $story_content = trim($_POST['story_content']);
    $people_list = $_POST['person'];
    foreach ($people_list as $person) {
        $person = trim($person);
    }

    # 2 - Sanitize
    $summary = htmlspecialchars($summary);
    $story_content = htmlspecialchars($story_content);
    foreach ($people_list as $person) {
        $person = htmlspecialchars($person);
    }

    # 4 - Add new ability to database
    $added_story = StoryCollection::create($summary, $story_content, $people_list);

    # 5 - Redirect on success
    if ($added_story) {
        header('Location: ./index.php');
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Price Family History | Add</title>
    <link rel="stylesheet" href=<?= $css ?>>
    <link rel="icon" type="image/x-icon" href="<?= $logo ?>">
    <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>

</head>

<body>
    <header class="other-page header-text">

        <nav id="desktop-nav">
            <a class="logo" href=<?= $home ?>>
                <img src="/project/family_history/images/tree-of-life-drawing-celtic-style-gold.png"></a>
            <div class="nav-text">
                <a href=<?= $home ?>>
                    <h1>Price Family History</h1>
                </a>
                <ul>
                    <li><a href=<?= $stories ?>>Stories</a></li>
                    <li><a href=<?= $people ?>>People</a></li>
                    <li><a href=<?= $about ?>>About</a></li>
                    <li><a href=<?= $admin ?>><?= $admin_link; ?></a></li>
                </ul>
            </div>
        </nav>
        <nav id="mobile-nav">
            <a class="logo header-text" href=<?= $home ?>>
                <img src="/project/family_history/images/tree-of-life-drawing-celtic-style-gold.png"></a>
            <div class="nav-text">
                <a href=<?= $home ?>>
                    <h1 class="header-text">Price Family History</h1>
                </a>
                <div class="dropdown">Menu</div>
                <ul class="header-text" id="mobile-overlay">
                    <div class="exit">&times;</div>
                    <li><a href=<?= $stories ?>>Stories</a></li>
                    <li><a href=<?= $people ?>>People</a></li>
                    <li><a href=<?= $about ?>>About</a></li>
                    <li><a href=<?= $admin ?>><?= $admin_link; ?></a></li>
                </ul>
            </div>
        </nav>
        <div class="title-section">
            <h2>
                <?= $page_title ?>
            </h2>

        </div>
    </header>
    <main>


        <!-- Create the editor container -->
        <form id="add-form" action="" method="POST">
            <label for="summ-entry">Enter a short (200 characters) summary of the story:</label></br>
            <textarea form="add-form" name="summary" type="text" maxlength="200" id="summ-entry" rows="4" cols="50"
                autocomplete="off" required></textarea></br>
            <label for="editor">Enter your story below</label></br>
            <div id="editor"></div>
            <input type="hidden" name="story_content" id="hiddenInput" required>

            <label for="person[]">Select the name of the primary people associated with this story:</label></br>
            <p>(If you want to add more people, press and hold the CONTROL key (or COMMAND for MacOS users) to select
                multiple entries)</p>
            <select name="person[]" class="drop-down" multiple="multiple">
                <?php foreach ($allPeople as $person) : ?>
                <option value="<?= $person->getPersonKey() ?>"><?= $person->getFullName() ?></option>
                <?php endforeach; ?>
            </select></br>

            <input class="submit-button add-button" type="submit" value="Submit">
        </form>
    </main>
</body>
<footer>
    <p>copyright 2022</p>
    <script src="/project/family_history/js/main.js"></script>
    <script>
    const toolbarOptions = [
        ['bold', 'italic', 'underline'], // toggled buttons
        ['blockquote'],

        [{
            'list': 'ordered'
        }, {
            'list': 'bullet'
        }],
        [{
            'script': 'sub'
        }, {
            'script': 'super'
        }], // superscript/subscript
        [{
            'indent': '-1'
        }, {
            'indent': '+1'
        }], // outdent/indent

        [{
            'header': [3, 4, 5, 6, false]
        }],
        ['clean'] // remove formatting button
    ];
    const options = {
        debug: 'info',
        modules: {
            toolbar: toolbarOptions
        },
        placeholder: 'Tell your story...',
        readOnly: false,
        theme: 'snow'
    };
    const container = document.querySelector('#editor');
    var quill = new Quill(container, options);

    var form = document.querySelector("form");
    var hiddenInput = document.querySelector('#hiddenInput');

    form.addEventListener('submit', function(e) {
        hiddenInput.value = quill.root.innerHTML;
    });
    </script>
</footer>


</html>