<div class="login-register">
    <div class="container">
        <div class="row">
            <div class="col mt-5 mb-5">
                <h5>
                    This is a one-time login.
                </h5>
                <p>Click on this button to visit your profile and change your password.</p>
                <a href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>user"
                   class="btn btn-primary transparent reverse">
                    Password Update
                </a>
            </div>
        </div>
    </div>
</div>