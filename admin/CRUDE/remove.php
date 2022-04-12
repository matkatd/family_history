<?php
spl_autoload_register(function ($class) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/family_history/includes/classes/{$class}.php";
});
if (empty($_GET['id'])) {
    header('Location: index.php');
}

# 1 - Eliminate whitespace
$story_key = trim($_GET['id']);
# 2 - Sanitize
$story_key = htmlspecialchars($story_key);

if ($story_key) {
    header('Location: index.php');
}

# 3 - Remove from database
$removedStory = StoryCollection::remove($story_key);

# 4 - Redirect on success
if ($removedStory) {
    header('Location: index.php');
}