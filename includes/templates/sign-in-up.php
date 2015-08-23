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
                    <form action="<?= BASE_URL ?>?view=login" method="post">
                        <div class="form-group">
                            <label for="login-email">Email address</label>
                            <input type="text" class="form-control" placeholder="Email" name="login-email" id="login-email"/>
                        </div>
                        <div class="form-group">
                            <label for="login-password">Password</label>
                            <input type="password" class="form-control" placeholder="Password" name="login-password" id="login-password"/>
                        </div>
                        <input class="btn btn-primary" type="submit"/>
                    </form>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="signup">
                    <form action="<?= BASE_URL ?>?view=signup" method="post">
                        <div class="form-group">
                            <label for="signup-email">Email address</label>
                            <input type="text" class="form-control" placeholder="Email" id="signup-email"/>
                        </div>
                        <div class="form-group">
                            <label for="signup-password">Password</label>
                            <input type="password" class="form-control" placeholder="Password" id="signup-password"/>
                        </div>
                        <div class="form-group">
                            <label for="signup-password-check">Verify password</label>
                            <input type="password" class="form-control" placeholder="Password" id="signup-password-check"/>
                        </div>
                        <input class="btn btn-primary" type="submit"/>
                    </form>
                </div>
            <?php elseif ($view == 'signup'): ?>
                <div role="tabpanel" class="tab-pane fade" id="login">
                    <form action="<?= BASE_URL ?>?view=login" method="post">
                        <div class="form-group">
                            <label for="login-email">Email address</label>
                            <input type="text" class="form-control" placeholder="Email" id="login-email"/>
                        </div>
                        <div class="form-group">
                            <label for="login-password">Password</label>
                            <input type="password" class="form-control" placeholder="Password" id="login-password"/>
                        </div>
                        <input class="btn btn-primary" type="submit"/>
                    </form>
                </div>
                <div role="tabpanel" class="tab-pane fade in active" id="signup">
                    <form action="<?= BASE_URL ?>?view=signup" method="post">
                        <div class="form-group">
                            <label for="signup-email">Email address</label>
                            <input type="text" class="form-control" placeholder="Email" id="signup-email"/>
                        </div>
                        <div class="form-group">
                            <label for="signup-password">Password</label>
                            <input type="password" class="form-control" placeholder="Password" id="signup-password"/>
                        </div>
                        <div class="form-group">
                            <label for="signup-password-check">Verify password</label>
                            <input type="password" class="form-control" placeholder="Password" id="signup-password-check"/>
                        </div>
                        <input class="btn btn-primary" type="submit"/>
                    </form>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>