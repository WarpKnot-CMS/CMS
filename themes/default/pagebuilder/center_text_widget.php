<? if (!empty($center_text_widget)): ?>
    <div class="widget content content_simple">
        <div class="container">
            <div class="row text-md-center">
                <? foreach ($center_text_widget as $widget):
                    switch ($widget['columns']):
                        case 1:
                            $columns = 'col-md-3 col-lg-1 col-xl-1';
                            break;
                        case 2:
                            $columns = 'col-md-4 col-lg-2';
                            break;
                        case 3:
                            $columns = 'col-md-4 col-lg-3';
                            break;
                        case 4:
                            $columns = 'col-md-6 col-lg-4';
                            break;
                        case 5:
                            $columns = 'col-md-5 col-lg-5';
                            break;
                        case 6:
                            $columns = 'col-md-6 col-lg-6';
                            break;
                        case 7:
                            $columns = 'col-md-7 col-lg-7';
                            break;
                        case 8:
                            $columns = 'col-md-8 col-lg-8';
                            break;
                        case 9:
                            $columns = 'col-md-9 col-lg-9';
                            break;
                        case 10:
                            $columns = 'col-md-10 col-lg-10';
                            break;
                        case 11:
                            $columns = 'col-md-11 col-lg-11';
                            break;
                        case 12:
                            $columns = 'col-md-12 col-lg-12';
                            break;
                    endswitch; ?>
                    <div class="col-sm-12 align-self-center <?= $columns ?>">
                        <div class="widget__container content_simple__container">
                            <? if (!empty($widget['headline'])): ?>
                                <h5 class="widget__headline content_simple__headline mb-2">
                                    <?= $widget['headline'] ?>
                                </h5>
                            <? endif ?>
                            <? if (!empty($widget['title'])): ?>
                                <h2 class="widget__title content_simple__title">
                                    <?= $widget['title'] ?>
                                </h2>
                            <? endif ?>
                            <? if (!empty($widget['text'])): ?>
                                <div class="widget__text content_simple__text">
                                    <?= $widget['text'] ?>
                                </div>
                            <? endif ?>
                            <? if (isset($widget['button']) && !empty($widget['button']['title'])): ?>
                                <div class="widget__button_group content_simple__button_group">
                                    <a href="<?= $widget['button']['href'] ?>"
                                       target="<?= $widget['button']['target'] ?>"
                                       class="btn btn-success transparent reverse">
                                        <?= $widget['button']['title'] ?>
                                    </a>
                                </div>
                            <? endif ?>
                        </div>
                    </div>
                <? endforeach ?>
            </div>
        </div>
    </div>
<? endif ?>