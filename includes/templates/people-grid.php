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
                        <?php if ($user->isLoggedIn()): ?>
                            <?php if($person->isInUserFavorites()): ?>
                                <a href="<?= BASE_URL ?>?view=favorite&id=<?= $person->getId() ?>&action=delete" class="glyphicon glyphicon glyphicon-heart favorites-toggle" data-favorite="true" aria-hidden="true"></a>
                            <?php else: ?>
                                <a href="<?= BASE_URL ?>?view=favorite&id=<?= $person->getId() ?>&action=add" class="glyphicon glyphicon glyphicon-heart-empty favorites-toggle" data-favorite="false" aria-hidden="true"></a>
                            <?php endif ?>
                        <?php else: ?>
                            <a href="#" class="glyphicon glyphicon glyphicon-heart favorites-toggle invisible" data-favorite="true" aria-hidden="true"></a>
                        <?php endif ?>
                        <div class="profile-picture-overlay">
                            <a href="<?= BASE_URL . '?view=person&id=' . $person->getId() ?>"><?= $person->getFullName() ?></a>
                        </div>
                    </div>
                <?php $count++; ?>
                <?php if (!($count % 3) || $count >= count($this->people)): ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
            <nav>
                <ul class="pagination">
                    <li <?php if ($this->page == 1): ?>class="disabled"<?php endif ?>>
                        <a href="<?= BASE_URL ?>?id=<?= $this->page - 1 ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php for ( $i = 1; $i <= $this->pages; $i++): ?>
                        <?php if ($i == $this->page): ?>
                            <li class="active"><a href="<?= BASE_URL ?>?id=<?= $i ?>"><?= $i ?></a></li>
                        <?php else: ?>
                            <li><a href="<?= BASE_URL ?>?id=<?= $i ?>"><?= $i ?></a></li>
                        <?php endif ?>
                    <?php endfor ?>
                    <li <?php if ($this->page >= $this->pages): ?>class="disabled"<?php endif ?>>
                        <a href="<?= BASE_URL ?>?id=<?= $this->page + 1 ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        <?php endif ?>
    </main>
</div>