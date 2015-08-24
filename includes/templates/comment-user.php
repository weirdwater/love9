<div class="comment-row row">
    <div class="comment-col-left col-md-2">
        <div class="comment-avatar">
        </div>
    </div>
    <div class="comment-col-middle col-md-8">
        <div class="comment-header">
            <div class="row">
                <div class="col-sm-11">
                    <h4><?= $this->from->getFullName() ?></h4>
                </div>
                <div class="col-sm-1 hidden">
                    <div class="glyphicon glyphicon-remove">
                    </div>
                </div>
            </div>
        </div>
        <div class="comment-body">
            <?= $this->body ?>
        </div>
    </div>
    <div class="comment-col-left col-md-2">
        <div class="comment-avatar-user avatar" data-userid="<?= $this->from->getId() ?>"></div>
    </div>
</div>