/* eslint no-eval: 0 */
(function ($) {
    "use strict";
    $.fn.ajaxSubmit = function (options) {
        function getCookie(name) {
            var cookieValue = null;
            if (document.cookie && document.cookie != '') {
                var cookies = document.cookie.split(';');
                for (var i = 0; i < cookies.length; i++) {
                    var cookie = jQuery.trim(cookies[i]);
                    // Does this cookie string begin with the name we want?

                    if (cookie.substring(0, name.length + 1) == (name + '=')) {
                        cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                        break;
                    }
                }
            }
            return cookieValue;
        }

        function editorUpdate() {
            try {
                if (tinyMCE.editors) {
                    tinyMCE.triggerSave();
                    for (var instance in tinyMCE.editors) {
                        tinyMCE.editors[instance].setContent('');
                    }
                }
            } catch (err) {
            }
        }

        function clearAll() {
            $('.form-control').each(function () {
                $(this).val("");
            });
            $(".picture-preview .image-container").html("");
            $(".emptyDiv").html("");
            try {
                editorUpdate();
            } catch (err) {
            }
            /**
             * Recaptcha Reload
             */
            try {
                grecaptcha.reset();
            } catch (err) {
            }
        }

        function clearPassword() {
            $('input[type=password]').each(function () {
                $(this).val("");
            });
        }

        $.ajaxSetup({
            beforeSend: function (xhr, settings) {
                if (!(/^http:.*/.test(settings.url) || /^https:.*/.test(settings.url))) {
                    // Only send the token to relative URLs i.e. locally.
                    xhr.setRequestHeader("X-CSRFToken", getCookie('csrftoken'));
                }
            }
        });

        /**
         * This is the easiest way to have default options.
         * @type {jQuery|void}
         */
        var settings = $.extend({}, options);

        this.each(function () {

            $(this).on('submit', function () {
                var action = $(this).attr('action'),
                    data_id = $(this).attr('data_id'),
                    method = $(this).attr('data_method'),
                    form_obj = $(this);

                options.form = $(this);
                // Form generic error reset
                options.form.find(".message").html('');

                $(form_obj).find("button").prop('disabled', true);

                /**
                 * Editor Append
                 */
                var editor_read = {};
                try {
                    tinyMCE.triggerSave();
                    $('.editor').each(function (i, obj) {
                        editor_read[$(obj).attr("id")] = tinyMCE.editors[$(obj).attr("id")].getContent();
                    });
                } catch (err) {
                }

                /**
                 * Page Builder Read
                 */
                var pageBuilder = {},
                    pageBuilderErrors = false,
                    requiredValidation;
                /**
                 * Generate a list with each container
                 */
                $('.page-builder-group').each(function (a, container) {
                    var groupId = $(container).find(".current-fields").attr("id");
                    pageBuilder[groupId] = {};
                    /**
                     * Generate a list with each widget
                     */
                    //widget-items
                    $("#" + groupId + " .widget-items").each(function (b, widget) {
                        var widgetId = $(widget).attr("id"),
                            machine_name = $(widget).attr("machine_name"),
                            repeater = $(widget).attr("repeater");
                        pageBuilder[groupId][b] = {
                            'id': widgetId,//page_builder_object
                            'machine_name': machine_name,
                            'weight': b,
                            'repeater': repeater ? true : false,
                            'items': {}//page_builder_object_list
                        };
                        if (repeater) {
                            /**
                             * Use a different logic for the repeater widget
                             */
                            $(widget).find(".wi").each(function (e, wi) {
                                pageBuilder[groupId][b]['items'][e] = {};// jshint ignore:line
                                /**
                                 * Generate a list with each field
                                 */
                                $(wi).find(".object").each(function (c, object) {
                                    requiredValidation = $(this).attr("objectRequired");
                                    /**
                                     * Read the value
                                     */
                                    var fieldValue;
                                    $(object).removeClass("requiredError");
                                    switch ($(object).attr("object")) {
                                        case '_GALLERY':
                                            /**
                                             * Generate a list with all the images
                                             * Also, keep the same order
                                             */
                                            var imagesList = {};
                                            $(object).find(".picture-object").each(function (d, imageObject) {
                                                imagesList[d] = {
                                                    'value': $(imageObject).find("input").val(),
                                                    'weight': d
                                                };
                                            });
                                            fieldValue = imagesList;
                                            if (requiredValidation === 'true' && imagesList.length === 0) {
                                                // Set the error
                                                $(object).addClass("requiredError");
                                                pageBuilderErrors = true;
                                            }
                                            break;

                                        case '_IMAGE':
                                            fieldValue = $(object).find("input").val();
                                            if (requiredValidation === 'true' && fieldValue === '') {
                                                // Set the error
                                                $(object).addClass("requiredError");
                                                pageBuilderErrors = true;
                                            }
                                            break;

                                        case '_FILE':
                                            fieldValue = $(object).find("input").val();
                                            if (requiredValidation === 'true' && fieldValue === '') {
                                                // Set the error
                                                $(object).addClass("requiredError");
                                                pageBuilderErrors = true;
                                            }
                                            break;

                                        case '_TEXTAREA':
                                            fieldValue = $(object).find("textarea").val();
                                            if (requiredValidation === 'true' && fieldValue === '') {
                                                // Set the error
                                                $(object).addClass("requiredError");
                                                pageBuilderErrors = true;
                                            }
                                            break;

                                        case '_LINK':
                                            fieldValue = {
                                                'title': $(object).find(".object-name").val(),
                                                'href': $(object).find(".object-link").val(),
                                                'target': $(object).find("select").val()
                                            };
                                            if (requiredValidation === 'true' && $(object).find(".object-link").val() === '') {
                                                // Set the error
                                                $(object).addClass("requiredError");
                                                pageBuilderErrors = true;
                                            }
                                            break;

                                        case '_CHECKBOX':
                                            fieldValue = $(object).find("input").is(':checked') ? 1 : 0;
                                            if (requiredValidation === 'true' && !fieldValue) {
                                                // Set the error
                                                $(object).addClass("requiredError");
                                                pageBuilderErrors = true;
                                            }
                                            break;

                                        case '_SELECT':
                                            fieldValue = $(object).find("select").val();
                                            if (requiredValidation === 'true' && (fieldValue === '' || fieldValue === 0)) {
                                                // Set the error
                                                $(object).addClass("requiredError");
                                                pageBuilderErrors = true;
                                            }
                                            break;

                                        case '_TEXT_EDITOR':
                                            var editorId = $(object).find("textarea").attr("id");
                                            fieldValue = tinyMCE.editors[editorId].getContent();
                                            if (requiredValidation === 'true' && fieldValue === '') {
                                                // Set the error
                                                $(object).addClass("requiredError");
                                                pageBuilderErrors = true;
                                            }
                                            break;

                                        case '_RADIO':
                                            fieldValue = $(object).find("input").filter(":checked").val();
                                            break;

                                        case '_INPUT':
                                            fieldValue = $(object).find("input").val();
                                            if (requiredValidation === 'true' && fieldValue === '') {
                                                // Set the error
                                                $(object).addClass("requiredError");
                                                pageBuilderErrors = true;
                                            }
                                            break;
                                    }

                                    pageBuilder[groupId][b]['items'][e][c] = {// jshint ignore:line
                                        'id': $(object).attr("id"),
                                        'object_type': $(object).attr("object"),
                                        'value': fieldValue
                                    };
                                });


                            });
                        } else {
                            /**
                             * Generate a list with each field
                             */
                            $(widget).find(".object").each(function (c, object) {
                                requiredValidation = $(this).attr("objectRequired");
                                $(object).removeClass("requiredError");
                                /**
                                 * Read the value
                                 */
                                var fieldValue;
                                switch ($(object).attr("object")) {
                                    case '_GALLERY':
                                        /**
                                         * Generate a list with all the images
                                         * Also, keep the same order
                                         */
                                        var imagesList = {};
                                        $(object).find(".picture-object").each(function (d, imageObject) {
                                            imagesList[d] = {
                                                'value': $(imageObject).find("input").val(),
                                                'weight': d
                                            };
                                        });
                                        fieldValue = imagesList;
                                        if (requiredValidation === 'true' && imagesList.length === 0) {
                                            // Set the error
                                            $(object).addClass("requiredError");
                                            pageBuilderErrors = true;
                                        }
                                        break;

                                    case '_IMAGE':
                                        fieldValue = $(object).find("input").val();
                                        if (requiredValidation === 'true' && fieldValue === '') {
                                            // Set the error
                                            $(object).addClass("requiredError");
                                            pageBuilderErrors = true;
                                        }
                                        break;

                                    case '_FILE':
                                        fieldValue = $(object).find("input").val();
                                        if (requiredValidation === 'true' && fieldValue === '') {
                                            // Set the error
                                            $(object).addClass("requiredError");
                                            pageBuilderErrors = true;
                                        }
                                        break;

                                    case '_TEXTAREA':
                                        fieldValue = $(object).find("textarea").val();
                                        if (requiredValidation === 'true' && fieldValue === '') {
                                            // Set the error
                                            $(object).addClass("requiredError");
                                            pageBuilderErrors = true;
                                        }
                                        break;

                                    case '_LINK':
                                        fieldValue = {
                                            'title': $(object).find(".object-name").val(),
                                            'href': $(object).find(".object-link").val(),
                                            'target': $(object).find("select").val()
                                        };
                                        if (requiredValidation === 'true' && $(object).find(".object-link").val() === '') {
                                            // Set the error
                                            $(object).addClass("requiredError");
                                            pageBuilderErrors = true;
                                        }
                                        break;

                                    case '_CHECKBOX':
                                        fieldValue = $(object).find("input").is(':checked') ? 1 : 0;
                                        if (requiredValidation === 'true' && !fieldValue) {
                                            // Set the error
                                            $(object).addClass("requiredError");
                                            pageBuilderErrors = true;
                                        }
                                        break;

                                    case '_SELECT':
                                        fieldValue = $(object).find("select").val();
                                        if (requiredValidation === 'true' && (fieldValue === '' || fieldValue === 0)) {
                                            // Set the error
                                            $(object).addClass("requiredError");
                                            pageBuilderErrors = true;
                                        }
                                        break;

                                    case '_TEXT_EDITOR':
                                        var editorId = $(object).find("textarea").attr("id");
                                        fieldValue = tinyMCE.editors[editorId].getContent();
                                        if (requiredValidation === 'true' && fieldValue === '') {
                                            // Set the error
                                            $(object).addClass("requiredError");
                                            pageBuilderErrors = true;
                                        }
                                        break;

                                    case '_RADIO':
                                        fieldValue = $(object).find("input").filter(":checked").val();
                                        break;

                                    case '_INPUT':
                                        fieldValue = $(object).find("input").val();
                                        if (requiredValidation === 'true' && fieldValue === '') {
                                            // Set the error
                                            $(object).addClass("requiredError");
                                            pageBuilderErrors = true;
                                        }
                                        break;
                                }

                                pageBuilder[groupId][b]['items'][c] = {// jshint ignore:line
                                    'id': $(object).attr("id"),
                                    'object_type': $(object).attr("object"),
                                    'value': fieldValue
                                };
                            });
                        }
                    });
                });

                /**
                 * Multiple
                 */
                var multiple_read = {};
                $('.multiple').each(function (i, obj) {
                    if (jQuery.type(multiple_read[$(obj).attr("group")]) !== 'object') {
                        multiple_read[$(obj).attr("group")] = {};
                    }
                    if ($(obj).is(':checkbox')) {
                        if ($(obj).is(':checked')) {
                            multiple_read[$(obj).attr("group")][$(obj).attr("unique_id")] = $(obj).val();
                        }
                    } else {
                        multiple_read[$(obj).attr("group")][$(obj).attr("unique_id")] = $(obj).val();
                    }
                });

                /**
                 * Json Data Read
                 * @type {{}}
                 */
                var json_object = {},
                    $weight = 0;
                $('.json_object').each(function (i, obj) {
                    if ($(this).attr("json")) {
                        json_object[$(obj).attr("id")] = {
                            'weight': ++$weight,
                            'json': JSON.parse($(this).attr("json"))
                        };
                    }
                });

                var postData = {};
                postData.editor_read = JSON.stringify(editor_read);
                postData.multiple_read = JSON.stringify(multiple_read);
                postData.pageBuilder = JSON.stringify(pageBuilder);
                postData.json_object = JSON.stringify(json_object);
                postData.form_serialize = options.form.serialize();

                if (pageBuilderErrors) {
                    /**
                     * Enable that button
                     */
                    options.form.find("button").prop('disabled', false);

                    /**
                     * Set a default error
                     */
                    options.form.find(".message").html('<div class="mt-2 mb-4 alert alert-danger">Please fix the errors above.</div>');
                } else {
                    $.post(action, {
                        'data_id': data_id,
                        'method': method,
                        'data': postData,
                    }, function (data) {

                        /**
                         * Enable that button
                         */
                        options.form.find("button").prop('disabled', false);

                        if (data.error) {
                            options.ajax_error();
                        } else {
                            options.form.find(".errors").html("");
                            options.form.find(".message").html("");

                            /**
                             * check for the message
                             */
                            if (data.message) {
                                options.form.find(".message").html('<div class="mt-2 mb-4 alert alert-' + data.message.type + '">' + data.message.text + '</div>');
                            }
                            if (data.errors) {
                                /**
                                 * Recaptcha Reload
                                 */
                                try {
                                    grecaptcha.reset();
                                } catch (err) {
                                }
                                $.each(data.errors, function (index, value) {
                                    options.form.find("." + index + "_errors").prepend('<div>' + value.join('') + '</div>');
                                });
                            } else {
                                if (data.redirect) {
                                    window.location = data.redirect;
                                }
                            }
                            try {
                                eval(data.action.function)(data.action.arguments);// jshint ignore:line
                            } catch (err) {
                            }

                            options.ajax_ok();
                        }

                    }, 'json');
                }

                return false;
            });
        });
    };
}(jQuery));