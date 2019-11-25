<div class="login-register">

    <div class="container-fluid">
        <div class="row">
            <div class="col">

                <div class="form-container mt-5 mb-5 text-center page_builder__form">
                    <p>Already have an account? please <a href="/user/login">Log In</a></p>

                    <form data_id="_USER_REGISTER"
                          action="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>user/post"
                          method="post" class="form-post login-form text-left">

                        <div class="form-group">
                            <div class="errors username_errors"></div>
                            <input type="text" name="username" class="form-control" id="username">
                            <label class="control-label" for="username">Username</label>
                        </div>

                        <div class="form-group">
                            <div class="errors email_errors"></div>
                            <input type="text" name="email" class="form-control" id="email">
                            <label class="control-label" for="email">Email</label>
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
                                <button class="btn btn-primary transparent reverse" type="submit">Register</button>
                            </div>
                        </div>

                        <p class="text-center text-muted mb-0 mt-4">
                            By creating an account you agree with the <a
                                    href="/terms-conditions/">Terms & Conditions</a>.
                        </p>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>