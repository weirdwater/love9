<div class="row">
    <div class="col-md-1"></div>
    <main class="profile col-md-10">
        <div class="page-header">
            <h1>Welcome! <small>Please tell us about yourself.</small></h1>
        </div>
        <form action="<?= BASE_URL ?>?view=profile&action=create" method="post">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label  for="name">Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="John"
                            <?php if (isset($_POST['name'])): ?>
                                value="<?= $_POST['name'] ?>"
                            <?php endif ?>
                        "/>
                    </div>
                    <?php $signupHandler->showAlert('name') ?>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label  for="surname">Surname</label>
                        <input type="text" id="surname" name="surname" class="form-control" placeholder="Smith"
                            <?php if (isset($_POST['surname'])): ?>
                                value="<?= $_POST['surname'] ?>"
                            <?php endif ?>
                        "/>
                    </div>
                    <?php $signupHandler->showAlert('surname') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="dob">Birthday</label>
                        <input type="date" id="dob" name="dob" class="form-control"
                            <?php if (isset($_POST['dob'])): ?>
                                    value="<?= $_POST['dob'] ?>"
                            <?php endif ?>
                        "/>
                    </div>
                    <?php $signupHandler->showAlert('dob') ?>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="height">Height</label>
                        <input type="number" id="height" name="height" class="form-control" placeholder="In cm"
                        <?php if (isset($_POST['height'])): ?>
                               value="<?= $_POST['height'] ?>"
                        <?php endif ?>
                        "/>
                    </div>
                    <?php $signupHandler->showAlert('height') ?>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" id="city" name="city" class="form-control" placeholder="Cincinnati"
                                    <?php if (isset($_POST['city'])): ?>
                                        value="<?= $_POST['city'] ?>"
                                    <?php endif ?>
                                "/>
                            </div>
                            <?php $signupHandler->showAlert('city') ?>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="state">State/Country</label>
                                <select name="state" id="state" name="state" class="form-control">
                                    <?= $signupHandler->getOptions('state') ?>
                                </select>
                            </div>
                            <?php $signupHandler->showAlert('state') ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Sex</label>
                        <div class="radio">
                            <label for="sexM"><input type="radio" name="sex" id="sexM" value="m"
                                    <?php if (isset($_POST['sex']) && $_POST['sex'] == 'm'): ?>
                                        checked
                                    <?php endif ?>
                            />
                                Male
                            </label>
                        </div>
                        <div class="radio">
                            <label for="sexF"><input type="radio" name="sex" id="sexF" value="f"
                                    <?php if (isset($_POST['sex']) && $_POST['sex'] == 'f'): ?>
                                        checked
                                    <?php endif ?>
                            />
                                Female
                            </label>
                        </div>
                    </div>
                    <?php $signupHandler->showAlert('sex') ?>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Preferred sex</label>
                        <div class="radio">
                            <label for="prefSexM"><input type="radio" name="prefSex" id="prefSexM" value="m"
                                    <?php if (isset($_POST['prefSex']) && $_POST['prefSex'] == 'm'): ?>
                                        checked
                                    <?php endif ?>
                            />
                                Male
                            </label>
                        </div>
                        <div class="radio">
                            <label for="prefSexF"><input type="radio" name="prefSex" id="prefSexF" value="f"
                                    <?php if (isset($_POST['prefSex']) && $_POST['prefSex'] == 'f'): ?>
                                        checked
                                    <?php endif ?>
                            />
                                Female
                            </label>
                        </div>
                    </div>
                    <?php $signupHandler->showAlert('prefSex') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="eyeColor">Eye color</label><br/>
                        <select class="form-control" name="eyeColor" id="eyeColor">
                            <?= $signupHandler->getOptions('eyeColor') ?>
                        </select>

                    </div>
                    <?php $signupHandler->showAlert('eyeColor') ?>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="hairColor">Hair color</label><br/>
                        <select class="form-control" name="hairColor" id="hairColor">
                            <?= $signupHandler->getOptions('hairColor') ?>
                        </select>
                    </div>
                    <?php $signupHandler->showAlert('hairColor') ?>
                </div>
            </div>
            <div class="form-group">
                <label for="bio">Bio</label>
                <textarea name="bio" id="bio" cols="30" rows="10" class="form-control"><?php if (isset($_POST['bio'])): ?><?= $_POST['bio'] ?><?php endif ?></textarea>
            </div>
            <?php $signupHandler->showAlert('bio') ?>
            <div class="form-group">
                <label for="interests">Interests</label>
                <input type="text" id="interests" name="interests" class="form-control" placeholder="Reading, Puppies, Cooking, Going out for drinks..."
                    <?php if (isset($_POST['interests'])): ?>
                        value="<?= $_POST['interests'] ?>"
                    <?php endif ?>
                />
            </div>
            <?php $signupHandler->showAlert('interests') ?>
            <div class="form-group">
                <label for="dislikes">Dislikes</label>
                <input type="text" id="dislikes" name="dislikes" class="form-control" placeholder="Rats, Public Bathrooms, Nose Picking..."
                    <?php if (isset($_POST['dislikes'])): ?>
                        value="<?= $_POST['dislikes'] ?>"
                    <?php endif ?>
                />
            </div>
            <?php $signupHandler->showAlert('dislikes') ?>
            <input type="submit" class="btn btn-primary"/>
        </form>
    </main>
    <div class="col-md-1"></div>
</div>