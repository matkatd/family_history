<?php
$page_title = "Story";
require_once "./includes/elements/header.php";

if (empty($_GET['id'])) {
    header('Location: stories.php');
}

# 1 - Eliminate whitespace
$story_id = trim($_GET['id']);
# 2 - Sanitize
$story_id = htmlspecialchars($story_id);

if (!$story_id) {
    header('Location: stories.php');
}

# 3 Get record data
$story_record = StoryCollection::get($story_id);
$people_for_story = StoryCollection::getPeopleForStory($story_id);
//var_dump($people_for_story);    

?>
<main>
    <h3><?= $story_record->getSummary() ?></h3>
    <ul>
        <?php foreach ($people_for_story as $person) : ?>
        <li><a href="./personPage.php?id=<?= $person->getPersonID() ?>"><?= $person->getFullName() ?></a></li>
        <?php endforeach; ?>
    </ul>
    <section>
        <?= $story_record->getStoryContent() ?>
    </section>
</main>
</body>
<?php
require_once "./includes/elements/footer.php";
?>

</html>