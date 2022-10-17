<?php

$page = "CRUDE";
$page_title = "Stories";
require_once "../admin_header.php";

if (empty($_GET['signal'])) {
    header('Location: index.php');
}

# 1 - Eliminate whitespace
$signal = trim($_GET['signal']);
# 2 - Sanitize
$signal = htmlspecialchars($signal);

if (!$signal) {
    header('Location: index.php');
}

?>
<main>
    <section class="stories-list">
        <?php if (StoryCollection::getAll()) : ?>
        <?php foreach (StoryCollection::getAll() as $story) : ?>
        <div class="story-card">
            <h3><?= $story->getSummary() ?></h3>
            <a href="./<?= $signal ?>.php?id=<?= $story->getKey(); ?>"><?= ucwords($signal) ?> Story</a>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>


    </section>
</main>
</body>
<?php
require_once "../../includes/elements/footer.php";
?>

</html>