$(function(){function t(e,t,o){var a=new Date;a.setTime(a.getTime()+864e5*o),document.cookie=e+"="+t+";path=/;expires="+a.toGMTString()}$(".form-post").ajaxSubmit({ajax_error:function(){},ajax_ok:function(){}}),$(document).slugGenerator({title:"document_title",slug:"document_slug"}),$(document).on("click",".left-menu-action",function(){$("body").toggleClass("left-menu-show-hide"),$("body").hasClass("left-menu-show-hide")?t("left-menu-show-hide",!0,31):function(e){t(e,"",-1)}("left-menu-show-hide")}),$(document).on("click",".mobile-menu",function(){$("#mobile-menu-burger").toggleClass("open"),$(".overlay").toggleClass("open")}),tinymce.init({selector:".editor",plugins:"print preview searchreplace autolink directionality  visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount  imagetools textpattern help code",toolbar:"formatselect | forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat",image_advtab:!0,images_upload_url:window.location.protocol+"//"+window.location.hostname+"/filesmanagement/upload/images?location=editor",images_upload_base_path:"",image_list:window.location.protocol+"//"+window.location.hostname+"/filesmanagement/load",automatic_uploads:!1,relative_urls:!1,remove_script_host:!1,templates:[],height:300,statusbar:!1,branding:!1})});
!function(u){u.fn.galleryManager=function(t){u.extend({},t),u(".file-load");var s,n,c,r=u(".gallery-modal"),i=window.location.protocol+"//"+window.location.hostname+"/filesmanagement/load",e=window.location.protocol+"//"+window.location.hostname+"/filesmanagement/upload",l=".gallery-modal .modal-body #files-list .files-container .item",a=".gallery-modal .modal-footer #objectInsert",d=".picture-preview .image-container",o=u(".filemanager-upload");u(document).on("click",".file-load .file-select",function(){n&&n.attr("group")!==u(this).attr("group")&&r.find("#files-list .files-container").html('<div class="col">Loading...</div>'),r.find("#objectInsert").attr({object:"",save_to:"",group:"",display_to:"",location:""}),n=u(this),s=n.closest(".file-load");var t=n.attr("object"),i=n.attr("save_to"),e=n.attr("group"),l=n.attr("display_to"),a=n.attr("gallery");r.find("#objectInsert").attr({object:t,save_to:i,group:e,display_to:l,gallery:a}),r.modal("show")}),u(document).on("click",".file-load .clear",function(){u("#"+u(this).closest(".file-load").find(".select-image").attr("save_to")).val(""),u(this).closest(".file-load").find("input").val(""),u(this).closest(".file-load").find(".file-current").text(""),u(d).html("")}),u(document).on("click",".file-load .clearGallery",function(){u(this).closest(".picture-select").remove()}),r.on("shown.bs.modal",function(){o.fileupload({url:e+"/"+n.attr("group")+"?location="+u(a).attr("object"),dataType:"json",done:function(t,i){var e=u(this).attr("id");"images"===n.attr("group")?r.find("#files-list .files-container").append('<div class="col-auto"><div class="item" object_name="'+i.result.title+'" location="'+i.result.src_location+'"><div class="image"><img src="'+i.result.location+'"/></div><div class="title">'+i.result.title+"</div></div></div>"):r.find("#files-list .files-container").append('<div class="col-auto"><div class="item" object_name="'+i.result.title+'" location="'+i.result.src_location+'"><div class="file"><div><img src="'+i.result.extension_image+'"/><div class="title">'+i.result.title+"</div></div></div></div></div>"),u("#"+e+"-progress .progress-bar").css("width","0%")},progressall:function(t,i){var e=u(this).attr("id"),l=parseInt(i.loaded/i.total*100,10);u("#"+e+"-progress .progress-bar").css("width",l+"%")}}).prop("disabled",!u.support.fileInput).parent().addClass(u.support.fileInput?void 0:"disabled"),u.get(i+"?group="+n.attr("group"),function(t){var e="";u.each(t,function(t,i){"images"===n.attr("group")?e+=function(t){return'<div class="col-auto"><div location="'+t.location+'" class="item" object_name="'+t.title+'"><div class="image"><img src="'+t.value+'"/></div><div class="title">'+t.title+"</div></div></div>"}(i):e+=function(t){return'<div class="col-auto"><div location="'+t.location+'" class="item" object_name="'+t.title+'"><div class="file"><div><img src="'+t.extension_image+'"/><div class="title">'+t.title+"</div></div></div></div></div>"}(i)}),r.find("#files-list .files-container").html(e)}).done(function(){}).fail(function(){})}),u(document).on("click",l,function(){c=u(this),u(l).removeClass("selected"),c.addClass("selected"),u(a).attr({location:u(this).attr("location"),object_name:u(this).attr("object_name"),location_src:u(this).find("img").attr("src")})}),u(document).on("click",a,function(){$this=u(this);$this.attr("object");var t,i=$this.attr("save_to"),e=($this.attr("group"),$this.attr("location")),l=$this.attr("display_to"),a=$this.attr("location_src"),o=$this.attr("object_name");o&&(t=o),n.attr("gallery")?l&&s.find(l).append('<div class="picture-select picture-preview-simple d-inline-block picture-object">   <input type="hidden" class="form-control" id="gallery_picture[]" name="gallery_picture[]" value="'+c.attr("location")+'">   <div class="clearGallery">x</div>   <div class="image-container">       <img src="'+c.find("img").attr("src")+'">   </div></div>'):l&&s.find(l).html(t+" (x)"),e&&(s.find("#"+i).val(e),s.find(d).html("<img src='"+a+"'/>")),r.modal("hide")})}}(jQuery),$(function(){$(document).galleryManager({})});
!function(l){l.fn.pageBuilder=function(e){var t=l.extend({},e),o=".gallery-images",i=".sortable-repeater";function r(){try{tinymce.remove()}catch(e){console.log(e)}tinymce.init({selector:".editor",plugins:"print preview searchreplace autolink directionality  visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount  imagetools textpattern help code",toolbar:"formatselect | forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat",image_advtab:!0,images_upload_url:window.location.protocol+"//"+window.location.hostname+"/filesmanagement/upload/images?location=editor",images_upload_base_path:"",image_list:window.location.protocol+"//"+window.location.hostname+"/filesmanagement/load",automatic_uploads:!1,relative_urls:!1,remove_script_host:!1,templates:[],height:300,statusbar:!1,branding:!1}),l(".tox-tinymce").show(),l("input.form-control").show(),l(o).length&&l(o).sortable({}),l(i).length&&l(i).sortable({beforeStop:r})}function d(e){return e.replace(/'/g,"").replace(/"/g,"")}l(document).machineName({name:"object_name",machine:"machine_name"}),l("."+t.widget).each(function(e,t){var a=l("#pageBuilderObject"),n="#pageBuilderObject .widget-manage",d="#pageBuilderObject .widgets .widget",i="#pageBuilderObject .objects .widget";l(".current-fields").sortable({beforeStop:r}),r(),l(o).length&&l(o).sortable({}),l(document).on("click",".pagebuilder-add-widget",function(){l(n).attr("group",l(this).attr("group")),l(a).modal("show"),a.find(".widget-objects").hide(),a.find(".current-element").html(""),a.find(".elements").html("").hide(),a.find(".field-manage").attr("item","").attr("disabled",!0),l(d).show()}),l(document).on("click",".repeater",function(){var e=(new Date).getUTCMilliseconds(),t=l(this).closest(".repeater-container").find(".repeat-fields").html().replace("editor-object","editor").replace("timestamp",e),i=l(this).closest(".widget-items-list").find(".repeater-container");l("<div class='wi'>"+t+"</div>").insertBefore(i),r()}),l(document).on("click",d,function(){var e=l(this),t=e.attr("object"),i=e.attr("object_id"),o={};l(n).attr("widget",l(this).attr("object_id")),l("#pageBuilderObject .page-builder-title").addClass("back-active"),a.find(".current-element").html(" - "+l(this).text()),l(d).hide(),o.group={object:t,object_id:i},l.post(window.location.protocol+"//"+window.location.hostname+"/admin/page-builder/post",{data_id:"_LOAD_WIDGETS",data:o},function(e){l(".elements").show().html(e)},"json"),l(this).closest(".modal-body").find(".elements").html(l(this).attr("group")).show()}),l(document).on("click",i,function(){l(i).removeClass("selected"),l(this).addClass("selected"),l(n).attr("item",l(this).attr("object_id")).attr("disabled",!1)}),l(document).on("click",n,function(){var t=l(this).attr("group"),e=l(this).attr("widget"),i=l(this).attr("item"),o={pagebuilderSection:t,widget:e,itemID:i};l.post(window.location.protocol+"//"+window.location.hostname+"/admin/page-builder/post",{data_id:"_LOAD_OBJECT",data:o},function(e){l(t).append(e.replace("widget-content-hide","").replace("oi-plus","oi-minus")).sortable("refresh"),r(),l(a).modal("hide")},"json")}),l(document).on("click","#pageBuilderObject .page-builder-title",function(){l("#pageBuilderObject .page-builder-title").removeClass("back-active"),l(n).attr("item",l(this).attr("object_id")).attr("disabled",!0),a.find(".widget-objects").hide(),a.find(".current-element").html(""),a.find(".elements").html("").hide(),l(d).show()}),l(document).on("click",".current-fields .widget-delete",function(){l(this).closest(".widget-items").remove()}),l(document).on("click",".current-fields .widget-control,.current-fields .widget-name",function(){l(this).closest(".widget-items").find(".widget-items-list").hasClass("widget-content-hide")?(l(this).closest(".widget-items").find(".widget-items-list").removeClass("widget-content-hide"),l(this).closest(".widget-items").find("span.oi").addClass("oi-minus").removeClass("oi-plus")):(l(this).closest(".widget-items").find(".widget-items-list").addClass("widget-content-hide"),l(this).closest(".widget-items").find("span.oi").addClass("oi-plus").removeClass("oi-minus"))}),l(document).on("click",".wi-remove",function(){l(this).parents(".wi").remove()})}),l("."+t.widget_field).each(function(e,t){var a=l("#pageBuilderObject"),n=l("#pageBuilderObjectEdit"),i="#pageBuilderObject .widgets .widget";l(document).on("click",".page-builder-modal-action",function(){l("#pageBuilderObject").modal("show"),a.find(".widget-objects").hide(),a.find(".current-element").html(""),a.find(".elements").html("").hide(),a.find(".field-manage").attr("item","").attr("disabled",!0),l(i).show()}),l(".current-fields").sortable({beforeStop:r}),r(),l(document).on("click",i,function(){l(".elements").html(),a.find(".current-element").html(" - "+l(this).text()),l(i).hide(),a.find(".field-manage").attr("item",l(this).attr("object")).attr("disabled",!1),l.post(window.location.protocol+"//"+window.location.hostname+"/admin/page-builder/post",{data_id:l(this).attr("object")},function(e){l(".elements").show().html(e),l(document).machineName({name:"object_name",machine:"machine_name"})},"json"),l(document).on("click","#pageBuilderObject .page-builder-title",function(){l("#pageBuilderObject .page-builder-title").removeClass("back-active"),a.find(".widget-objects").hide(),a.find(".current-element").html(""),a.find(".elements").html("").hide(),a.find(".field-manage").attr("item","").attr("disabled",!0),l(i).show()})}),l(document).on("click",".field-manage",function(){var i=!1,t=l(this).attr("action");if(l(".required").each(function(e,t){switch(l(t).attr("validation")){case"input":case"textarea":""===l(t).val()?(l(t).parent(".form-group").addClass("error"),i=!0):l(t).parent(".form-group").removeClass("error");break;case"select":""===l(t).val()||0===l(t).val()?(l(t).parent(".form-group").addClass("error"),i=!0):l(t).parent(".form-group").removeClass("error")}}),!i){var e={},o=l(this).attr("item_id");e.form_serialize="insert"===t?d(a.find(".field-container").serialize()):d(n.find(".field-container").serialize())+"&item_id="+o,l.post(window.location.protocol+"//"+window.location.hostname+"/admin/page-builder/post",{data_id:"_GENERATE"+l(this).attr("item"),data:e},function(e){"insert"===t?(l(".current-fields").append(e).sortable("refresh"),r(),a.modal("hide")):(l("<div id='tmp-object'></div>").insertBefore("#"+o),l("#"+o).remove(),l(e).insertBefore("#tmp-object"),l("#tmp-object").remove(),l(".current-fields").sortable("refresh"),r(),n.modal("hide"))},"json")}}),l(document).on("click",".object-destroy",function(){l(this).parent(".object").remove()}),l(document).on("click",".object-edit",function(){var t=l("#pageBuilderObjectEdit"),e=l(this).parent(".object").attr("json"),i=l(this).attr("temp_id"),o=l(this).attr("object");t.find(".field-manage").attr("item_id",i),t.find(".field-manage").attr("item",l(this).attr("object"));var a={};a.form_serialize=l.param(JSON.parse(e)),l.post(window.location.protocol+"//"+window.location.hostname+"/admin/page-builder/post",{data_id:o,data:a},function(e){t.find("#edit-element").html(e),l(document).machineName({name:"object_name",machine:"machine_name"})},"json"),l(t).modal("show")})})}}(jQuery),$(function(){$(document).pageBuilder({widget:"page-builder-widgets-add",widget_field:"page-builder-object"})});
!function(c){c.fn.machineName=function(e){function r(e){e=(e=e.replace(/^\s+|\s+$/g,"")).toLowerCase();for(var a="àáäâèéëêìíïîòóöôùúüûñç·/_,:;",n=0,t=a.length;n<t;n++)e=e.replace(new RegExp(a.charAt(n),"g"),"aaaaeeeeiiiioooouuuunc------".charAt(n));return e=e.replace(/[^a-z0-9 -]/g,"").replace(/\s+/g,"_").replace(/-+/g,"_")}var a=c.extend({},e);0<parseFloat(c(".object_id").length)&&c("."+a.name).each(function(e,a){var n=c("#"+c(a).attr("id")),t=c("#"+c(a).attr("machine"));c(n).keyup(function(){var e=c("#"+c(n).attr("id")).val();c(t).attr("overwrite")||c(t).val(r(e))})}),c("."+a.machine).each(function(e,a){c(a).change(function(){c(a).val(r(c(a).val()))})})}}(jQuery);
!function($){$.fn.ajaxSubmit=function(options){function getCookie(e){var r=null;if(document.cookie&&""!=document.cookie)for(var t=document.cookie.split(";"),a=0;a<t.length;a++){var i=jQuery.trim(t[a]);if(i.substring(0,e.length+1)==e+"="){r=decodeURIComponent(i.substring(e.length+1));break}}return r}function editorUpdate(){try{if(tinyMCE.editors)for(var e in tinyMCE.triggerSave(),tinyMCE.editors)tinyMCE.editors[e].setContent("")}catch(e){}}function clearAll(){$(".form-control").each(function(){$(this).val("")}),$(".picture-preview .image-container").html(""),$(".emptyDiv").html("");try{editorUpdate()}catch(e){}}function clearPassword(){$("input[type=password]").each(function(){$(this).val("")})}$.ajaxSetup({beforeSend:function(e,r){/^http:.*/.test(r.url)||/^https:.*/.test(r.url)||e.setRequestHeader("X-CSRFToken",getCookie("csrftoken"))}});var settings=$.extend({},options);this.each(function(){$(this).on("submit",function(){var action=$(this).attr("action"),data_id=$(this).attr("data_id"),method=$(this).attr("data_method"),form_obj=$(this);options.form=$(this),options.form.find(".message").html(""),$(form_obj).find("button").prop("disabled",!0);var editor_read={};try{tinyMCE.triggerSave(),$(".editor").each(function(e,r){editor_read[$(r).attr("id")]=tinyMCE.editors[$(r).attr("id")].getContent()})}catch(e){}var pageBuilder={},pageBuilderErrors=!1,requiredValidation;$(".page-builder-group").each(function(e,r){var n=$(r).find(".current-fields").attr("id");pageBuilder[n]={},$("#"+n+" .widget-items").each(function(o,e){var r=$(e).attr("id"),t=$(e).attr("machine_name"),a=$(e).attr("repeater");pageBuilder[n][o]={id:r,machine_name:t,weight:o,repeater:!!a,items:{}},a?$(e).find(".wi").each(function(d,e){pageBuilder[n][o].items[d]={},$(e).find(".object").each(function(e,r){var t;switch(requiredValidation=$(this).attr("objectRequired"),$(r).removeClass("requiredError"),$(r).attr("object")){case"_GALLERY":var a={};$(r).find(".picture-object").each(function(e,r){a[e]={value:$(r).find("input").val(),weight:e}}),t=a,"true"===requiredValidation&&0===a.length&&($(r).addClass("requiredError"),pageBuilderErrors=!0);break;case"_IMAGE":case"_FILE":t=$(r).find("input").val(),"true"===requiredValidation&&""===t&&($(r).addClass("requiredError"),pageBuilderErrors=!0);break;case"_TEXTAREA":t=$(r).find("textarea").val(),"true"===requiredValidation&&""===t&&($(r).addClass("requiredError"),pageBuilderErrors=!0);break;case"_LINK":t={title:$(r).find(".object-name").val(),href:$(r).find(".object-link").val(),target:$(r).find("select").val()},"true"===requiredValidation&&""===$(r).find(".object-link").val()&&($(r).addClass("requiredError"),pageBuilderErrors=!0);break;case"_CHECKBOX":t=$(r).find("input").is(":checked")?1:0,"true"!==requiredValidation||t||($(r).addClass("requiredError"),pageBuilderErrors=!0);break;case"_SELECT":t=$(r).find("select").val(),"true"!==requiredValidation||""!==t&&0!==t||($(r).addClass("requiredError"),pageBuilderErrors=!0);break;case"_TEXT_EDITOR":var i=$(r).find("textarea").attr("id");t=tinyMCE.editors[i].getContent(),"true"===requiredValidation&&""===t&&($(r).addClass("requiredError"),pageBuilderErrors=!0);break;case"_RADIO":t=$(r).find("input").filter(":checked").val();break;case"_INPUT":t=$(r).find("input").val(),"true"===requiredValidation&&""===t&&($(r).addClass("requiredError"),pageBuilderErrors=!0)}pageBuilder[n][o].items[d][e]={id:$(r).attr("id"),object_type:$(r).attr("object"),value:t}})}):$(e).find(".object").each(function(e,r){var t;switch(requiredValidation=$(this).attr("objectRequired"),$(r).removeClass("requiredError"),$(r).attr("object")){case"_GALLERY":var a={};$(r).find(".picture-object").each(function(e,r){a[e]={value:$(r).find("input").val(),weight:e}}),t=a,"true"===requiredValidation&&0===a.length&&($(r).addClass("requiredError"),pageBuilderErrors=!0);break;case"_IMAGE":case"_FILE":t=$(r).find("input").val(),"true"===requiredValidation&&""===t&&($(r).addClass("requiredError"),pageBuilderErrors=!0);break;case"_TEXTAREA":t=$(r).find("textarea").val(),"true"===requiredValidation&&""===t&&($(r).addClass("requiredError"),pageBuilderErrors=!0);break;case"_LINK":t={title:$(r).find(".object-name").val(),href:$(r).find(".object-link").val(),target:$(r).find("select").val()},"true"===requiredValidation&&""===$(r).find(".object-link").val()&&($(r).addClass("requiredError"),pageBuilderErrors=!0);break;case"_CHECKBOX":t=$(r).find("input").is(":checked")?1:0,"true"!==requiredValidation||t||($(r).addClass("requiredError"),pageBuilderErrors=!0);break;case"_SELECT":t=$(r).find("select").val(),"true"!==requiredValidation||""!==t&&0!==t||($(r).addClass("requiredError"),pageBuilderErrors=!0);break;case"_TEXT_EDITOR":var i=$(r).find("textarea").attr("id");t=tinyMCE.editors[i].getContent(),"true"===requiredValidation&&""===t&&($(r).addClass("requiredError"),pageBuilderErrors=!0);break;case"_RADIO":t=$(r).find("input").filter(":checked").val();break;case"_INPUT":t=$(r).find("input").val(),"true"===requiredValidation&&""===t&&($(r).addClass("requiredError"),pageBuilderErrors=!0)}pageBuilder[n][o].items[e]={id:$(r).attr("id"),object_type:$(r).attr("object"),value:t}})})});var multiple_read={};$(".multiple").each(function(e,r){"object"!==jQuery.type(multiple_read[$(r).attr("group")])&&(multiple_read[$(r).attr("group")]={}),$(r).is(":checkbox")?$(r).is(":checked")&&(multiple_read[$(r).attr("group")][$(r).attr("unique_id")]=$(r).val()):multiple_read[$(r).attr("group")][$(r).attr("unique_id")]=$(r).val()});var json_object={},$weight=0;$(".json_object").each(function(e,r){$(this).attr("json")&&(json_object[$(r).attr("id")]={weight:++$weight,json:JSON.parse($(this).attr("json"))})});var postData={};return postData.editor_read=JSON.stringify(editor_read),postData.multiple_read=JSON.stringify(multiple_read),postData.pageBuilder=JSON.stringify(pageBuilder),postData.json_object=JSON.stringify(json_object),postData.form_serialize=options.form.serialize(),pageBuilderErrors?(options.form.find("button").prop("disabled",!1),options.form.find(".message").html('<div class="mt-2 mb-4 alert alert-danger">Please fix the errors above.</div>')):$.post(action,{data_id:data_id,method:method,data:postData},function(data){if(options.form.find("button").prop("disabled",!1),data.error)options.ajax_error();else{options.form.find(".errors").html(""),options.form.find(".message").html(""),data.message&&options.form.find(".message").html('<div class="mt-2 mb-4 alert alert-'+data.message.type+'">'+data.message.text+"</div>"),data.errors?$.each(data.errors,function(e,r){options.form.find("."+e+"_errors").prepend("<div>"+r.join("")+"</div>")}):data.redirect&&(window.location=data.redirect);try{eval(data.action.function)(data.action.arguments)}catch(e){}options.ajax_ok()}},"json"),!1})})}}(jQuery);
!function(c){c.fn.slugGenerator=function(e){function n(e){e=(e=e.replace(/^\s+|\s+$/g,"")).toLowerCase();for(var a="àáäâèéëêìíïîòóöôùúüûñç·/_,:;",t=0,r=a.length;t<r;t++)e=e.replace(new RegExp(a.charAt(t),"g"),"aaaaeeeeiiiioooouuuunc------".charAt(t));return e=e.replace(/[^a-z0-9 -]/g,"").replace(/\s+/g,"-").replace(/-+/g,"-")}var a=c.extend({},e);0<parseFloat(c(".object_id").length)&&c("."+a.title).each(function(e,a){var t=c("#"+c(a).attr("id")),r=c("#"+c(a).attr("slug"));c(t).keyup(function(){var e=c("#"+c(t).attr("id")).val();c(r).attr("overwrite")||c(r).val(n(e))})}),c("."+a.slug).each(function(e,a){c(a).change(function(){c(a).val(n(c(a).val()))})})}}(jQuery);