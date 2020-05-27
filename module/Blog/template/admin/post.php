<?php

use _MODULE\PageBuilder;

?>
<?= selfRender('Dashboard', 'partials/top-navigation.php') ?>

    <div class="container-fluid">
        <div class="row">

            <?= selfRender('Dashboard', 'partials/left-menu.php') ?>

            <main role="main" class="col-md-12 ml-sm-auto col-lg-12 dashboard-container">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <? if (isset($object)): ?>
                        <h2>Update post</h2>
                    <? else: ?>
                        <h2>Add new post</h2>
                    <? endif; ?>
                </div>

                <form data_id="<? if (isset($object)): ?>_POST_UPDATE<? else: ?>_POST_CREATE<? endif ?>"
                      action="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/blog/post"
                      method="post" class="form-post label-design">

                    <input type="hidden" id="bpid" name="bpid" class="object_id"
                           value="<?= (isset($object['bpid']) ? $object['bpid'] : '') ?>"/>

                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-8">
                            <div class="post-details">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <input slug="object_slug" type="text" name="object_name"
                                                   class="form-control document_title" id="object_name"
                                                   value="<?= (isset($object['bp_title']) ? $object['bp_title'] : '') ?>">
                                            <label for="object_name" class="control-label">Post name</label>
                                        </div>
                                        <div class="errors object_name_errors"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <input type="text" name="object_slug" class="form-control document_slug"
                                                   id="object_slug"
                                                   value="<?= (isset($object['bp_slug']) ? $object['bp_slug'] : '') ?>">
                                            <label for="object_slug" class="control-label">Post slug</label>
                                        </div>
                                        <div class="errors object_slug_errors"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-mg-12 col-lg-12">
                                        <div class="form-group">
                                        <textarea name="object_preview" class="form-control"
                                                  id="object_preview"><?= (isset($object['bp_preview']) ? $object['bp_preview'] : '') ?></textarea>
                                            <label for="object_preview" class="control-label">Preview</label>
                                        </div>
                                        <div class="errors object_preview_errors"></div>
                                    </div>
                                </div>

                                <?= PageBuilder::widget(
                                    [
                                        'group' => 'post_header'
                                    ]
                                ) ?>

                                <div class="row">
                                    <div class="col-sm-12 col-mg-12 col-lg-12">
                                        <div class="form-group">
                                        <textarea name="object_body" class="form-control editor"
                                                  id="object_body"><?= (isset($object['bp_body']) ? $object['bp_body'] : '') ?></textarea>
                                            <label for="object_body" class="control-label">Body</label>
                                        </div>
                                        <div class="errors object_body_errors"></div>
                                    </div>
                                </div>

                                <?= PageBuilder::widget(
                                    [
                                        'group' => 'post_footer'
                                    ]
                                ) ?>

                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-4">

                            <div class="post-settings">
                                <div class="row">

                                    <div class="col-sm-12 col-md-12 col-lg-12 order-1 order-lg-5">
                                        <div class="form-group">

                                            <div class="file-load">
                                                <input type="hidden" name="cover" class="form-control"
                                                       id="cover"
                                                       value="<?= (isset($object['bp_cover']) ? $object['bp_cover'] : '') ?>">

                                                <div class="picture-select picture-preview">
                                                    <div class="clear pictureClear">x</div>
                                                    <div class="image-container">
                                                        <? if (isset($object['bp_cover'])):if (!empty($object['bp_cover'])): ?>
                                                            <img src="<?= fileSrc($object['bp_cover']) ?>"/>
                                                        <? endif;endif ?>
                                                    </div>


                                                    <div class="file-select select-image" object="blog" save_to="cover"
                                                         group="images">
                                                        select image
                                                    </div>
                                                </div>
                                            </div>

                                            <label for="cover" class="control-label">Featured Image</label>
                                        </div>

                                        <div class="errors cover_errors"></div>
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-12 order-1 order-lg-5">
                                        <div class="form-group">
                                            <input type="text" name="object_seo_name" class="form-control"
                                                   id="object_seo_name"
                                                   value="<?= (isset($object['bpd_seo_title']) ? $object['bpd_seo_title'] : '') ?>">
                                            <label for="object_seo_name" class="control-label">SEO Name</label>
                                        </div>
                                        <div class="errors object_seo_name_errors"></div>
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-12 order-2 order-lg-6">
                                        <div class="form-group">
                                    <textarea rows="4" name="object_seo_description" class="form-control"
                                              id="object_seo_description"><?= (isset($object['bpd_seo_description']) ? $object['bpd_seo_description'] : '') ?></textarea>
                                            <label for="object_seo_description" class="control-label">SEO
                                                Description</label>
                                        </div>
                                        <div class="errors object_seo_description_errors"></div>
                                    </div>


                                    <div class="col-sm-12 col-md-6 col-lg-12 order-3 order-lg-1">
                                        <div class="form-group">
                                            <select id="object_template" name="object_template" class="form-control">
                                                <option value="">Select template</option>
                                                <? if (!empty($objectTemplates)): ?>
                                                    <? foreach ($objectTemplates as $key => $value): ?>
                                                        <option value="<?= $value ?>"<?= ($value == (isset($object['bpd_template']) ? $object['bpd_template'] : '') ? ' selected' : '') ?>><?= $key ?></option>
                                                    <? endforeach; ?>
                                                <? endif; ?>
                                            </select>
                                            <label for="object_template" class="control-label">Template</label>
                                        </div>
                                        <div class="errors object_template_errors"></div>
                                    </div>

                                    <div class="col-sm-12 col-md-6 col-lg-12 order-4 order-lg-2">
                                        <div class="form-group">
                                            <select id="object_status" name="object_status" class="form-control">
                                                <option value=""<?= ((isset($object['bpd_status']) ? $object['bpd_status'] : '') == '' ? ' selected' : '') ?>>
                                                    Select Status
                                                </option>
                                                <option value="DRAFT"<?= ((isset($object['bpd_status']) ? $object['bpd_status'] : '') == 'DRAFT' ? ' selected' : '') ?>>
                                                    Draft
                                                </option>
                                                <option value="PUBLISHED"<?= ((isset($object['bpd_status']) ? $object['bpd_status'] : '') == 'PUBLISHED' ? ' selected' : '') ?>>
                                                    Published
                                                </option>
                                            </select>
                                            <label for="object_status" class="control-label">Status</label>
                                        </div>
                                        <div class="errors object_status_errors"></div>
                                    </div>


                                    <div class="col-sm-12 col-md-12 col-lg-12 order-5 order-lg-3">
                                        <div>
                                            <? if (empty($categories)): ?>
                                                <a class="btn custom-btn btn-info mt-2 d-inline" target="_blank"
                                                   href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/blog/categories/add">New
                                                    category</a>
                                            <? else: ?>
                                                <div class="max-height-group">
                                                    <ul>
                                                        <? foreach ($categories as $category): ?>
                                                            <? if ($category['bcd_parent'] === 0): ?>
                                                                <li>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input group="category"
                                                                               unique_id="<?= $category['bcid'] ?>"
                                                                               type="checkbox"
                                                                               class="custom-control-input multiple"
                                                                               id="category_<?= $category['bcid'] ?>"
                                                                               name="category_<?= $category['bcid'] ?>"<? if (isset($attachedCategories)): if (in_array($category['bcid'], $attachedCategories)): ?> checked<? endif;endif; ?>>
                                                                        <label class="custom-control-label"
                                                                               for="category_<?= $category['bcid'] ?>">
                                                                            <?= $category['bc_title'] ?>
                                                                        </label>
                                                                    </div>
                                                                    <ul>

                                                                        <? foreach ($categories as $subcategory): ?>
                                                                            <? if ($subcategory['bcd_parent'] === $category['bcid']): ?>
                                                                                <li>
                                                                                    <div class="custom-control custom-checkbox">
                                                                                        <input group="category"
                                                                                               unique_id="<?= $subcategory['bcid'] ?>"
                                                                                               type="checkbox"
                                                                                               class="custom-control-input multiple"
                                                                                               id="category_<?= $subcategory['bcid'] ?>"
                                                                                               name="category_<?= $subcategory['bcid'] ?>"<? if (isset($attachedCategories)): if (in_array($subcategory['bcid'], $attachedCategories)): ?> checked<? endif;endif; ?>>
                                                                                        <label class="custom-control-label"
                                                                                               for="category_<?= $subcategory['bcid'] ?>">
                                                                                            <?= $subcategory['bc_title'] ?>
                                                                                        </label>
                                                                                    </div>
                                                                                </li>
                                                                            <? endif ?>
                                                                        <? endforeach; ?>
                                                                    </ul>
                                                                </li>
                                                            <? endif ?>
                                                        <? endforeach; ?>
                                                    </ul>
                                                </div>
                                            <? endif ?>
                                            <label for="category_<?= $category['bcid'] ?>"
                                                   class="control-label">Category</label>
                                        </div>
                                        <div class="errors object_category_errors"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-8">
                            <div class="message"></div>
                        </div>
                    </div>

                    <div class="form-group row btn-container">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <button class="btn custom-btn btn-info">
                                Save
                            </button>
                        </div>
                    </div>

                </form>

            </main>
        </div>
    </div>
<?= PageBuilder::modal() ?>