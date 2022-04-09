<?php
$page_title = "Stories";
require_once "./includes/elements/header.php";
?>
<main>
    <section class="stories-list">
        <?php if (StoryCollection::getAll()) : ?>
        <?php foreach (StoryCollection::getAll() as $story) : ?>
        <div class="story-card">
            <h3><?= $story->getSummary() ?></h3>
            <a href="./storyPage.php?id=<?= $story->getKey(); ?>">Read Story</a>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>


    </section>
</main>
</body>
<?php
require_once "./includes/elements/footer.php";
?>

</html>