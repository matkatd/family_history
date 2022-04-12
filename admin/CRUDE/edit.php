<?php
session_start();
// Check if user is logged in, if not, redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ./../admin.php");
    exit;
}
//echo $_SERVER['DOCUMENT_ROOT'];
$home = "/family_history/index.php";
$stories = "/family_history/stories.php";
$people = "/family_history/people.php";
$admin = "/family_history/admin/admin.php";
$about = "/family_history/about.php";
$logo = "/family_history/images/tree-of-life-drawing-celtic-style-gold.png";
$css = "/family_history/styles/other.css";
spl_autoload_register(function ($class) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/family_history/includes/classes/{$class}.php";
});
# Get names of people from db
$allPeople = PeopleRecordCollection::getAll();
//var_dump($_POST);
$page_title = "Edit Story";

if (empty($_GET['id'])) {
    header('Location: index.php');
}

# 1 - Eliminate whitespace
$story_key = trim($_GET['id']);
# 2 - Sanitize
$story_key = htmlspecialchars($story_key);

if (!$story_key) {
    header('Location: index.php');
}

# 3 Get story data
$story = StoryCollection::get($story_key);
$people_in_story = StoryCollection::getPeopleForStory($story_key);

if (!$story) {
    header('Location: index.php');
} else {
}

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

    # 4 - Update story in db
    $added_story = StoryCollection::update($story_key, $summary, $story_content, $people_list);

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
    <title>Price Family History | Stories</title>
    <link rel="stylesheet" href=<?= $css ?>>
    <link rel="icon" type="image/x-icon" href="<?= $logo ?>">
    <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>

</head>

<body>
    <header class="other-page header-text">

        <nav>
            <a class="logo" href=<?= $home ?>>
                <img src="/family_history/images/tree-of-life-drawing-celtic-style-gold.png"></a>
            <div class="nav-text">
                <a href=<?= $home ?>>
                    <h1>Price Family History</h1>
                </a>
                <ul>
                    <li><a href=<?= $stories ?>>Stories</a></li>
                    <li><a href=<?= $people ?>>People</a></li>
                    <li><a href=<?= $about ?>>About</a></li>
                    <li><a href=<?= $admin ?>>Login</a></li>
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
        <form name="edit-form" id="edit-form" action="" method="POST">
            <label for="summ-entry">Enter a short (200 characters) summary of the story:</label></br>
            <textarea form="edit-form" name="summary" type="text" maxlength="200" id="summ-entry" rows="4" cols="50"
                autocomplete="off"><?= $story->getSummary() ?></textarea></br>
            <label for="editor">Enter your story below</label></br>
            <div id="editor">
                <?= htmlspecialchars_decode($story->getStoryContent()) ?>
            </div>
            <input type="hidden" name="story_content" id="hiddenInput">

            <label for="person[]">Select the name of the primary people associated with this story:</label></br>
            <p>(If you want to add more people, press and hold the CONTROL key (or COMMAND for MacOS users) to select
                multiple entries))</p>
            <select name="person[]" class="drop-down" multiple="multiple">
                <?php foreach ($allPeople as $person) : ?>
                <option value="<?= $person->getPersonKey() ?>" <?php foreach ($people_in_story as $story_person) : ?>
                    <?php if ($person->getPersonID() == $story_person->getPersonID()) : ?> selected <?php endif; ?>
                    <?php endforeach; ?>>
                    <?= $person->getFullName() ?></option>

                <?php endforeach; ?>
            </select></br>

            <input class="submit-button add-button" type="submit" value="Submit">
        </form>
    </main>
</body>
<footer>
    <p>copyright 2022</p>
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