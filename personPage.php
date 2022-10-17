<?php
$home = "/project/family_history/index.php";
$stories = "/project/family_history/stories.php";
$people = "/project/family_history/people.php";
$admin = "/project/family_history/admin/admin.php";
$about = "/project/family_history/about.php";
$logo = "/project/family_history/images/tree-of-life-drawing-celtic-style-gold.png";
$css = "/project/family_history/styles/other.css";
spl_autoload_register(function ($class) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/project/family_history/includes/classes/{$class}.php";
});

if (empty($_GET['id'])) {
    header('Location: people.php');
}

# 1 - Eliminate whitespace
$person_id = trim($_GET['id']);
# 2 - Sanitize
$person_id = htmlspecialchars($person_id);

if (!$person_id) {
    header('Location: index.php');
}

# 3 Get record data
$person_record = PeopleRecordCollection::get($person_id);
$famc_record = "";
// var_dump($person_record->getFamc());
if (strlen($person_record->getFamc()) != 0) {
    $famc_record = FamilyRecordCollection::get($person_record->getFamc());
}

$fams_record = "";
$color = "#DBF5FF";

// Checks if the record has a fams ID. If it does, grab that record. Otherwise, don't
if (strlen($person_record->getFams()) != 0) {
    $fams_record = FamilyRecordCollection::get($person_record->getFams());
    $spouse_name = $fams_record->getWifeName();
    if ($person_record->getGender() == "F") {
        $color = "#F4E4F2";
        $spouse_name = $fams_record->getHusbandName();
    }
}

// Change the color of the header based on gender
if ($person_record->getGender() == "F") {
    $color = "#F4E4F2";
}

if (!$person_record) {
    header('Location: index.php');
} else {
}

# Get Stories

$storiesCollection = StoryCollection::getByPerson($person_record->getPersonKey());
//var_dump($storiesCollection);

//echo $fams_record->getChildrenNames();
$page_title = $person_record->getFullName();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Price Family History | Stories</title>
    <link rel="stylesheet" href=<?= $css ?>>
    <link rel="icon" type="image/x-icon"
        href="/project/family_history/images/tree-of-life-drawing-celtic-style-gold.png">
</head>

<body>
    <header class="other-page">

        <nav id="desktop-nav">
            <a class="logo header-text" href=<?= $home ?>>
                <img src="/project/family_history/images/tree-of-life-drawing-celtic-style-gold.png"></a>
            <div class="nav-text">
                <a href=<?= $home ?>>
                    <h1 class="header-text">Price Family History</h1>
                </a>
                <ul class="header-text">
                    <li><a href=<?= $stories ?>>Stories</a></li>
                    <li><a href=<?= $people ?>>People</a></li>
                    <li><a href=<?= $about ?>>About</a></li>
                    <li><a href=<?= $admin ?>>Login</a></li>
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
                    <li><a href=<?= $admin ?>>Login</a></li>
                </ul>
            </div>
        </nav>
        <div class="title-section" style="background-color: <?= $color ?>;">
            <h2>
                <?= $page_title ?>
            </h2>
        </div>
    </header>

    <main>
        <section id="vitals">
            <div class="birth">
                <h4>Born:</h4>
                <p><?= ucwords(strtolower($person_record->getBirthDate())); ?></p>
                <p><?= ucwords(strtolower($person_record->getBirthPlace())); ?></p>
            </div>
            <div class="death">
                <h4>Died:</h4>
                <p><?= ucwords(strtolower($person_record->getDeathDate())); ?></p>
                <p><?= ucwords(strtolower($person_record->getDeathPlace())); ?></p>
            </div>
            <?php if ($famc_record != "") { ?>
            <div class="parents">
                <h4>Father:</h4>
                <p><?= ucwords(strtolower($famc_record->getHusbandName())); ?> </p>
                <h4>Mother:</h4>
                <p><?= ucwords(strtolower($famc_record->getWifeName())); ?> </p>
            </div>
            <?php } else { ?>
            <div class="parents">
                <h4>Father:</h4>
                <p>Unknown </p>
                <h4>Mother:</h4>
                <p>Unknown </p>
            </div>
            <?php } ?>
            <?php if ($fams_record != "") : ?>
            <div class="marriage">
                <h4>Married to:</h4>
                <p><?= ucwords(strtolower($spouse_name)); ?> </p>
            </div>
            <?php if (sizeof($fams_record->getChildrenNames()) != 0) : ?>
            <div class="children">
                <h4>Children:</h4>
                <ul>
                    <?php foreach ($fams_record->getChildrenNames() as $child_name) : ?>
                    <li><?= ucwords(strtolower($child_name)); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
            <?php endif; ?>
        </section>
        <section id="stories-list">
            <?php foreach ($storiesCollection as $story) : ?>
            <div class="story-card">
                <div class="img-container"></div>
                <a href="./storyPage.php?id=<?= $story->getKey(); ?>"><?= $story->getSummary(); ?></a>
            </div>
            </div>
            <?php endforeach; ?>
        </section>
    </main>
</body>
<?php
require_once "./includes/elements/footer.php";
?>

</html>