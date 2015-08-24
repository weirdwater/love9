<div class="login-panel panel panel-default">
    <div class="panel-heading">
        <ul class="nav nav-pills nav-justified" role="tablist">
            <?php if ($view == 'login'):?>
                <li role="presentation" class="active"><a href="#login" aria-controls="home" role="tab" data-toggle="tab">Login</a></li>
                <li role="presentation"><a href="#signup" aria-controls="profile" role="tab" data-toggle="tab">Sign up</a></li>
            <?php elseif ($view == 'signup'): ?>
                <li role="presentation"><a href="#login" aria-controls="home" role="tab" data-toggle="tab">Login</a></li>
                <li role="presentation" class="active"><a href="#signup" aria-controls="profile" role="tab" data-toggle="tab">Sign up</a></li>
            <?php endif ?>
        </ul>
    </div>
    <div class="panel-body">
        <div class="tab-content">
            <?php if($view == 'login'):?>
                <div role="tabpanel" class="tab-pane fade in active" id="login">
            <?php elseif ($view == 'signup'): ?>
                <div role="tabpanel" class="tab-pane fade" id="login">
            <?php endif ?>
                <form action="<?= BASE_URL ?>?view=login" method="post">
                    <div class="form-group">
                        <label for="login-email">Email address</label>
                        <input type="text" class="form-control" placeholder="Email" id="login-email" name="login-email"/>
                    </div>
                    <div class="form-group">
                        <label for="login-password">Password</label>
                        <input type="password" class="form-control" placeholder="Password" id="login-password" name="login-password"/>
                    </div>
                    <input class="btn btn-primary" type="submit"/>
                </form>
            </div>
            <?php if($view == 'login'):?>
                <div role="tabpanel" class="tab-pane fade" id="signup">
            <?php elseif ($view == 'signup'): ?>
                <div role="tabpanel" class="tab-pane fade in active" id="signup">
            <?php endif ?>
                <form action="<?= BASE_URL ?>?view=signup" method="post">
                    <div class="form-group">
                        <label for="signup-email">Email address</label>
                        <input type="text" class="form-control" placeholder="Email" id="signup-email" name="signup-email"
                            <?php if (isset($_POST['signup-email'])): ?>
                                value="<?= $_POST['signup-email'] ?>"
                            <?php endif ?>
                        />
                    </div>
                    <?php $signupHandler->showAlert('signup-email') ?>
                    <div class="form-group">
                        <label for="signup-password">Password</label>
                        <input type="password" class="form-control" placeholder="Password" id="signup-password" name="signup-password"
                            <?php if (isset($_POST['signup-password'])): ?>
                                value="<?= $_POST['signup-password'] ?>"
                            <?php endif ?>
                        />
                    </div>
                    <?php $signupHandler->showAlert('signup-password') ?>
                    <div class="form-group">
                        <label for="signup-password-check">Verify password</label>
                        <input type="password" class="form-control" placeholder="Password" id="signup-password-check" name="signup-password-check"
                            <?php if (isset($_POST['signup-password-check'])): ?>
                                value="<?= $_POST['signup-password-check'] ?>"
                            <?php endif ?>
                        />
                    </div>
                    <?php $signupHandler->showAlert('signup-password-check') ?>
                    <input class="btn btn-primary" type="submit"/>
                </form>
            </div>
        </div>
    </div>
</div>