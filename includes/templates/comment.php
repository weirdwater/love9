<div class="comment-row row">
    <div class="comment-col-left col-md-2">
        <?php if (!$user->isLoggedIn() || ($user->isLoggedIn() && $this->from->getId() != $user->getPerson()->getId())): ?>
            <div class="comment-avatar">
                <div class="comment-avatar avatar" data-userid="<?= $this->from->getId() ?>"></div>
            </div>
        <?php endif ?>
    </div>
    <div class="comment-col-middle col-md-8">
        <div class="comment-header">
            <div class="row">
                <div class="col-sm-11">
                    <h4><?= $this->from->getFullName() ?></h4>
                </div>
                <div class="col-sm-1">
                    <?php if (($user->isLoggedIn() && $this->to->getId() == $user->getPerson()->getId())
                                || ($user->isLoggedIn() && $this->from->getId() == $user->getPerson()->getId()) ): ?>
                        <a href="<?= BASE_URL ?>?view=comment&id=<?= $this->id ?>&action=delete">
                            <span class="glyphicon glyphicon-remove"></span>
                        </a>
                    <?php endif ?>
                </div>
            </div>

        </div>
        <div class="comment-body">
            <?= $this->body ?>
        </div>
    </div>
    <div class="comment-col-left col-md-2">
        <?php if ($user->isLoggedIn() && $this->from->getId() == $user->getPerson()->getId()): ?>
            <div class="comment-avatar-user">
                <div class="comment-avatar avatar" data-userid="<?= $this->from->getId() ?>"></div>
            </div>
        <?php endif ?>
    </div>
</div>