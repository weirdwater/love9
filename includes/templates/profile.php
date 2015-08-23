<div class="container">
    <?php $exceptionHandler->showAlerts(); ?>
    <div class="row">
        <div class="col-md-1"></div>
        <main class="profile col-md-10">
            <div class="profile-overview row">
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-picture avatar" data-sex="<?= $this->person->getSex() ?>" data-userid="<?= $this->person->getId() ?>">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h1><?= $this->person->getFullName() ?></h1>
                        <ul>
                            <li>Sex: <?= $this->person->getSex() ?></li>
                            <li>Age: <?= $this->person->getAge() ?></li>
                            <li>Height: <?= $this->person->getHeightInCm() ?></li>
                            <li>Eye Color: <?= $this->person->getEyeColor() ?></li>
                            <li>Hair Color: <?= $this->person->getHairColor() ?></li>
                            <li>Location: <?= $this->person->location->getLocation() ?></li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-7">
                        <section class="profile-bio">
                            <h3>Bio</h3>
                            <p><?= $this->person->getBio() ?></p>
                        </section>
                    </div>
                    <div class="row col-md-5">
                        <div class="row">
                            <div class="col-md-4">
                                <section>
                                    <h3>Rating</h3>
                                    <div class="rating">4<span class="decimal">.3</span></div>
                                </section>
                            </div>
                            <div class="col-md-8">
                                <section>
                                    <h3>My Rating</h3>
                                    <div class="rating-stars">
                                        <span class="rating-star glyphicon glyphicon-star-empty" id="star5"></span><span class="rating-star glyphicon glyphicon-star-empty" id="star4"></span><span class="rating-star glyphicon glyphicon-star-empty" id="star3"></span><span class="rating-star glyphicon glyphicon-star-empty" id="star2"></span><span class="rating-star glyphicon glyphicon-star-empty" id="star1"></span>
                                    </div>
                                </section>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h3>Interests</h3>
                                <div class="interests">
                                    <?php foreach ($this->person->getInterests() as $interest): ?>
                                        <?php if ($user->isLoggedIn() && $user->getPerson()->dislikesInterest($interest->getId())): ?>
                                            <span class="label label-success"><?= $interest->getName() ?></span>
                                        <?php elseif ($user->isLoggedIn() && $user->getPerson()->likesInterest($interest->getId())): ?>
                                            <span class="label label-success"><?= $interest->getName() ?></span>
                                        <?php else: ?>
                                            <span class="label label-default"><?= $interest->getName() ?></span>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 comments-section">
                    <h2>Comments</h2>
                    <?php
                    foreach ($this->comments as $comment) {
                        $comment->showComment();
                    }
                    ?>
                    <?php if ($user->isLoggedIn()): ?>
                        <div class="comment-row row">
                            <div class="comment-col-left col-md-2">
                            </div>
                            <div class="comment-col-middle col-md-8">
                                <form action="" method="post">
                                    <div class="form-group">
                                        <label for="comment">Reply:</label>
                                        <textarea class="form-control" rows="5" id="comment"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <input type="button" class=" btn btn-link" value="Clear"/>
                                        <input type="submit" class=" btn btn-primary"/>
                                    </div>
                                </form>
                            </div>
                            <div class="comment-col-left col-md-2">
                                <div class="comment-avatar-user comment-user-reply avatar" data-userid="<?= $user->getPerson()->getId() ?>"> </div>
                            </div>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </main>
        <div class="col-md-1"></div>
    </div>
</div>