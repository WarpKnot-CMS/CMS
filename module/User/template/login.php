<div class="login-register">

    <div class="container">
        <div class="row">
            <div class="col">

                <div class="form-container page_builder__form mt-5 mb-5 text-center">

                    <p>You don't have an account? <a href="/user/register">Register</a></p>

                    <form data_id="_USER_LOGIN"
                          action="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>user/post"
                          method="post" class="form-post login-form text-left">

                        <div class="form-group">
                            <div class="errors username_errors"></div>
                            <input type="text" name="username" class="form-control" id="username">
                            <label class="control-label" for="username">Username</label>
                        </div>

                        <div class="form-group">
                            <div class="errors password_errors"></div>
                            <input type="password" name="password" class="form-control" id="password">
                            <label class="control-label" for="password">Password</label>
                        </div>

                        <div class="grid-x grid-margin-x align-center">
                            <div class="cell">
                                <div class="message"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="d-block d-md-inline-block mb-2">
                                <button class="btn btn-primary transparent reverse" type="submit">Log In</button>
                            </div>
                        </div>

                        <div class="text-center pt-3">
                            <a href="/user/recover" class="link">Forgot Password?</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
