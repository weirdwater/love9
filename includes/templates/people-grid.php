<div class="container">
    <main class="profile-picture-grid">
        <div class="page-header">
            <h1>You might like these:</h1>
        </div>
        <?php if (!$this->recordCount): ?>
            <h1>Looks like you're first!</h1>
            <p>Go where no-one has gone before and sign-up for Love9!</p>
        <?php else: ?>
            <?php $count = 0; ?>
            <?php foreach ($this->people as $person): ?>
                <?php if (!($count % 3)) : ?>
                    <div class="clearfix profile-picture-row">
                <?php endif ?>
                    <div class="pull-left profile-picture-item avatar" data-userid="<?= $person->getId() ?>">
                        <?php if($person->isInUserFavorites()): ?>
                            <a href="<?= BASE_URL ?>?view=favorite&id=<?= $person->getId() ?>&action=delete" class="glyphicon glyphicon glyphicon-heart favorites-toggle" data-favorite="true" aria-hidden="true"></a>
                        <?php else: ?>
                            <a href="<?= BASE_URL ?>?view=favorite&id=<?= $person->getId() ?>&action=add" class="glyphicon glyphicon glyphicon-heart-empty favorites-toggle" data-favorite="false" aria-hidden="true"></a>
                        <?php endif ?>
                        <div class="profile-picture-overlay">
                            <a href="<?= BASE_URL . '?view=person&id=' . $person->getId() ?>"><?= $person->getFullName() ?></a>
                        </div>
                    </div>
                <?php $count++; ?>
                <?php if (!($count % 3) || $count >= 9): ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
            <nav>
                <ul class="pagination">
                    <li <?php if ($this->page == 1): ?>class="disabled"<?php endif ?>>
                        <a href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="active"><a href="#">1</a></li>
                    <li <?php if ($this->page >= $this->pages): ?>class="disabled"<?php endif ?>>
                        <a href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        <?php endif ?>
    </main>
</div>