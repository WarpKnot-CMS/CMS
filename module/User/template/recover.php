<div class="login-register">


    <div class="container">
        <div class="row">
            <div class="col">

                <div class="form-container page_builder__form mt-5 mb-5 text-center">
                    <p>We'll send a password reset link to your email.</p>
                    <form data_id="_USER_RECOVER"
                          action="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>user/post"
                          method="post" class="form-post login-form text-left">

                        <div class="form-group">
                            <div class="errors email_errors"></div>
                            <input type="text" name="email" class="form-control" id="email">
                            <label class="control-label" for="email">Email</label>
                        </div>

                        <div class="grid-x grid-margin-x align-center">
                            <div class="cell">
                                <div class="message"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="d-block d-md-inline-block mb-2">
                                <button class="btn btn-primary transparent reverse" type="submit">
                                    Reset Password
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>