<? if (!isset($ignorePartials)): ?>
    <?= render('partials', 'header.php') ?>
<? endif ?>
    <div class="container mt-5 mb-5 text-center">
        <div class="row">
            <div class="col-sm-12">
                <div class="mt-4">
                    <h4>Homepage not found. Please go on the admin and set your homepage.</h4>
                </div>
                <div class="mt-5 mb-3">
                    <a class="btn btn-primary transparent reverse" href="/admin/settings">Set Homepage</a>
                </div>
            </div>
        </div>
    </div>
<? if (!isset($ignorePartials)): ?>
    <?= render('partials', 'footer.php') ?>
<? endif ?>