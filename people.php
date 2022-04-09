<?php
$page_title = "People";
require_once "./includes/elements/header.php";
?>
<main>
    <section class="people-list">
        <?php if (PeopleRecordCollection::getAll()) : ?>
        <?php foreach (PeopleRecordCollection::getAll() as $person) : ?>
        <div class="person-card">
            <h3><?= $person->getFullName() ?></h3>
            <a href="./personPage.php?id=<?= $person->getPersonID(); ?>">Learn More</a>
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