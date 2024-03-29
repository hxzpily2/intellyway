var default_zoom_level = 10;
function __l(str, lang_code) {
    //TODO: lang_code = lang_code || 'en_us';
    return(__cfg && __cfg('lang') && __cfg('lang')[str]) ? __cfg('lang')[str]: str;
}
function __cfg(c) {
    return(cfg && cfg.cfg && cfg.cfg[c]) ? cfg.cfg[c]: false;
}
(function($) {
    $.fn.confirm = function() {
        this.livequery('click', function(event) {
            return window.confirm(__l('Are you sure you want to ') + this.innerHTML.toLowerCase() + '?');
        });
    };
    $.fn.flashMsg = function() {
        $(this).livequery(function() {
            $this = $(this);
            $this.fadeOut(5000, function() {
                $this.remove();
            });
        });
    };
	
    $.fn.fautocomplete = function() {
        $(this).livequery(function() {
            var $this = $(this);
            $this.autocomplete($this.metadata().url, {
                minChars: 0,
                autoFill: true
/* JSON autocomplete is flaky. Till the issue is sorted out in the jquery.autocomplete, it's commented out
                ,dataType: 'json',
                parse: function(data) {
                    var parsed = [];
                    for (var i in data) {
                        parsed[parsed.length] = {
                            data: data[i],
                            value: i,
                            result: data[i]
                            };
                    }
                    return parsed;
                },
                formatItem: function(row) {
                    return row;
                }*/



            }).result(function(event, data, formatted) {
                var targetField = $this.metadata().targetField.replace(/&amp;/g, '&').replace(/&lt;/g, '<').replace(/&gt;/g, '>').replace(/&quot;/g, '"');
                var targetId = $this.metadata().id;
                if ( ! $('#' + targetId).length) {
                    $this.after(targetField);
                }
                var tdata = data.toString();
                $('#' + targetId).val(tdata.split(',')[1]).attr('x-data', tdata.split(',')[0]);
                // data is text,val

            }).blur(function() {
                var targetId = $this.metadata().id;
                if ($('#' + targetId).length) {
                    if ($this.val() != $('#' + targetId).attr('x-data')) {
                        $('#' + targetId).remove();
                    }
                }
            });
        });
    };
	$.fn.companyprofile = function(is_enabled) {
        if (is_enabled == 0) {
            $('.js-company_profile_show').hide();
        }
        if (is_enabled == 1) {
            $('.js-company_profile_show').show();
        }
    };
	$.fn.fuploadajaxform = function() {
        $(this).livequery('submit', function(e) {
            var content = $('.wuI').html();
            $flash_disabled = false;
            $('input:file').each(function(index) {
                if (($this).val())
                    return true;
            });
            if ($(this).metadata().is_required == 'true' && (content == '' || content == null)) {
                $('.js-flashupload-error').remove();
                $('.js-uploader').append('<span class="js-flashupload-error notice">'+__l("Please select alteast one file")+'</span>');
                $('.js-flashupload-error').flashMsg();
                return false;
            } else if ($(this).metadata().is_required == 'false' && (content == '' || content == null)) {				
                return true;
            } else {
                $('.js-flashupload-error').remove();
            }
            var $this = $(this);
            $this.find('.js-validation-part').block();
			//$('#js-gig-add-submit').attr("disabled", true);
            $this.ajaxSubmit( {
                beforeSubmit: function(formData, jqForm, options) {},
                success: function(responseText, statusText) {
                    if (responseText == 'flashupload') {
                        $('.js-upload-form .flashUploader').each(function() {
                            this.__uploaderCache.upload('', this.__uploaderCache._settings.backendScript);
                        });
                    } else {
						//$('#js-gig-add-submit').attr("disabled", false);
                        var validation_part = $(responseText).find('.js-validation-part', $this).html();
                        if (validation_part != '') {
                            $this.parents('.js-responses').find('.js-validation-part', $this).html(validation_part);
                        }
                    }
                }
            });
            return false;
        });
    };	
    $.fn.fajaxform = function() {
        $(this).livequery('submit', function(e) {
            var $this = $(this);
            $this.block();
            $this.ajaxSubmit( {
                beforeSubmit: function(formData, jqForm, options) {
                    $('input:file', jqForm[0]).each(function(i) {
                        if ($('input:file', jqForm[0]).eq(i).val()) {
                            options['extraData'] = {
                                'is_iframe_submit': 1
                            };
                        }
                    });
                    $this.block();
                },
                success: function(responseText, statusText) {
                    redirect = responseText.split('*');
                    if (redirect[0] == 'redirect') {
                        location.href = redirect[1];
                    } else if ($this.metadata().container) {
                        $('.' + $this.metadata().container).html(responseText);
                    } else {
                       $this.parents('div.js-responses').eq(0).html(responseText);
                    }
                    $this.unblock();
                }
            });
            return false;
        });
    };
    $.fn.fajaxaddform = function() {
        $(this).livequery('submit', function(e) {
            var $this = $(this);
            $this.block();
            $this.ajaxSubmit( {
                beforeSubmit: function(formData, jqForm, options) {},
                success: function(responseText, statusText) {
                    if (responseText.indexOf($this.metadata().container) != '-1') {
                        $('.' + $this.metadata().container).html(responseText);
                    } else {
                        $.get(__cfg('path_relative') + 'user_cash_withdrawals/index/', function(data) {
                            $('.js-withdrawal_responses').html(data);
                            return false;
                        });
                    }
                    $this.unblock();
                }
            });
            return false;
        });
    };
    $.fn.fajaxlogin = function() {
        $(this).livequery('submit', function(e) {
            var $this = $(this);
            $this.block();
            $this.ajaxSubmit( {
                beforeSubmit: function(formData, jqForm, options) {},
                success: function(responseText, statusText) {
                    redirect = responseText.split('*');
                    if (redirect[0] == 'redirect') {
                        location.href = redirect[1];
                    } else if (responseText == 'success') {
                        window.location.reload();
                    } else {
                        $this.parents('.js-login-response').html(responseText);
                    }
                }
            });
            return false;
        });
    };
    $.fn.fcommentform = function() {
        $(this).livequery('submit', function(e) {
            var $this = $(this);
            $this.block();
            $this.ajaxSubmit( {
                beforeSubmit: function(formData, jqForm, options) {},
                success: function(responseText, statusText) {
                    if (responseText.indexOf($this.metadata().container) != '-1') {
                        $('.' + $this.metadata().container).html(responseText);
                    } else {
                        $('.js-comment-responses').prepend(responseText);
                        $('.' + $this.metadata().container + ' div.input').removeClass('error');
                        $('.error-message', $('.' + $this.metadata().container)).remove();
                    }
                    if (typeof($('.js-captcha-container').find('.captcha-img').attr('src')) != 'undefined') {
                        captcha_img_src = $('.js-captcha-container').find('.captcha-img').attr('src');
                        captcha_img_src = captcha_img_src.substring(0, captcha_img_src.lastIndexOf('/'));
                        $('.js-captcha-container').find('.captcha-img').attr('src', captcha_img_src + '/' + Math.random());
                    }
                    $this.unblock();
                },
                clearForm: true
            });
            return false;
        });
    };
    $.fn.fcolorbox = function() {
        $(this).livequery(function(e) {
            $(this).colorbox( {
                opacity: 0.30
            });
        });
    };
    var i = 1;
    $.fn.fdatepicker = function() {
        $(this).livequery(function() {
            var $this = $(this);
            var class_for_div = $this.attr('class');
            var year_ranges = $this.children('select[id$="Year"]').text();

            var start_year = end_year = '';
            $this.children('select[id$="Year"]').find('option').each(function() {
                $tthis = $(this);
                if ($tthis.attr('value') != '') {
                    if (start_year == '') {
                        start_year = $tthis.attr('value');
                    }
                    end_year = $tthis.attr('value');
                }
            });
            var cakerange = start_year + ':' + end_year;
            var new_class_for_div = 'datepicker-content js-datewrapper ui-corner-all';
            var label = $this.children('label').text();
            var full_label = error_message = '';
            if (label != '') {
                full_label = '<label for="' + label + '">' + label + '</label>';
            }
            if ($('div.error-message', $this).html()) {
                var error_message = '<div class="error-message">' + $('div.error-message', $this).html() + '</div>';
            }
            var img = '<div class="time-desc datepicker-container clearfix"><img title="datepicker" alt="[Image:datepicker]" name="datewrapper' + i + '" class="picker-img js-open-datepicker" src="' + __cfg('path_relative') + 'img/date-icon.png"/>';
            year = $this.children('select[id$="Year"]').val();
            month = $this.children('select[id$="Month"]').val();
            day = $this.children('select[id$="Day"]').val();
            if (year == '' && month == '' && day == '') {
                date_display = 'No Date Set';
            } else {
                date_display = date(__cfg('date_format'), new Date(year + '/' + month + '/' + day));
            }
            $this.hide().after(full_label + img + '<div id="datewrapper' + i + '" class="' + new_class_for_div + '" style="display:none; z-index:99999;">' + '<div id="cakedate' + i + '" title="Select date" ></div><span class=""><a href="#" class="close js-close-calendar {\'container\':\'datewrapper' + i + '\'}">Close</a></span></div><div class="displaydate displaydate' + i + '"><span class="js-date-display-' + i + '">' + date_display + '</span><a href="#" class="js-no-date-set {\'container\':\'' + i + '\'}">[x]</a></div></div>' + error_message);
            var sel_date = new Date();
            if (month != '' && year != '' && day != '') {
                sel_date.setFullYear(year, (month - 1), day);
            } else {
                splitted = __cfg('today_date').split('-');
                sel_date.setFullYear(splitted[0], splitted[1] - 1, splitted[2]);
            }
            $('#cakedate' + i).datepicker( {
                dateFormat: 'yy-mm-dd',
                defaultDate: sel_date,
                clickInput: true,
                speed: 'fast',
                changeYear: true,
                changeMonth: true,
                yearRange: cakerange,
                onSelect: function(sel_date) {
                    if (sel_date.charAt(0) == '-') {
                        sel_date = start_year + sel_date.substring(2);
                    }
                    var newDate = sel_date.split('-');
                    $this.children("select[id$='Day']").val(newDate[2]);
                    $this.children("select[id$='Month']").val(newDate[1]);
                    $this.children("select[id$='Year']").val(newDate[0]);
                    $this.parent().find('.displaydate span').show();
                    $this.parent().find('.displaydate span').html(date(__cfg('date_format'), new Date(newDate[0] + '/' + newDate[1] + '/' + newDate[2])));
                    $this.parent().find('.js-datewrapper').hide();
                    $this.parent().toggleClass('date-cont');
                }
            });
            if ($this.children('select[id$="Hour"]').html()) {
                hour = $this.children('select[id$="Hour"]').val();
                minute = $this.children('select[id$="Min"]').val();
                meridian = $this.children('select[id$="Meridian"]').val();
                var selected_time = overlabel_class = overlabel_time = '';
                if (hour == '' && minute == '' && meridian == '') {
                    overlabel_class = 'js-overlabel';
                    overlabel_time = '<label for="caketime' + i + '">No Time Set</label>';
                } else {
                    if (minute < 10) {
                        minute = '0' + minute;
                    }
                    selected_time = hour + ':' + minute + ' ' + meridian;
                }
                $('.displaydate' + i).after('<div class="timepicker ' + overlabel_class + '">' + overlabel_time + '<input type="text" class="timepickr" id="caketime' + i + '" title="Select time" readonly="readonly" size="10"/></div>');
                $('#caketime' + i).timepickr( {
                    convention: 12,
                    resetOnBlur: true,
                    val: selected_time
                }).livequery('blur', function() {
                    var value = $(this).val();
                    var newmeridian = value.split(' ');
                    var newtime = newmeridian[0].split(':');
                    $this.children("select[id$='Hour']").val(newtime[0]);
                    $this.children("select[id$='Min']").val(newtime[1]);
                    $this.children("select[id$='Meridian']").val(newmeridian[1]);
                });
            }
            i = i + 1;
        });
    };
    $.fn.foverlabel = function() {
        $(this).livequery(function(e) {
            $(this).overlabel();
        });
    };	
    $.fn.fshowmap = function(point_y, point_x, drag) {        
		$('#js-map').jmap('init', {
            mapCenter: [point_y, point_x],
            mapShowjMapIcon: true,
            mapZoom: default_zoom_level,
            mapEnableDragging: true,
            mapEnableScrollZoom: true
        }, function(el, options) {
            $(el).jmap('addMarker', {
                pointLatLng: [point_y, point_x],
                pointIsDraggable: drag
            });
            map_reference = el.jmap;
            location_reference = new GLatLng(parseFloat(point_y), parseFloat(point_x));
        });
    };
	initMap = function() {
		$('form.js-company-map, form.js-company-address-map').livequery(function() {
			 marker = new google.maps.Marker( {
                draggable: true,
                map: map,
                icon: markerimage,
                position: latlng
            });
            map.setCenter(latlng);
			google.maps.event.addListener(marker, 'dragend', function(event) {
                geocodePosition(marker.getPosition());
            });
			google.maps.event.addListener(map, 'mouseout', function(event) {
                $('#zoomlevel').val(map.getZoom());
            });
		});
	};
	// branch address add
	initMapBranch = function() {
		$('form.js-branch-address-map').livequery(function() {
			console.log('coming initMapBranch');
			 marker_branch = new google.maps.Marker( {
                draggable: true,
                map: map_branch,
                icon: markerimage,
                position: latlng_branch
            });
            map_branch.setCenter(latlng_branch);
			google.maps.event.addListener(marker_branch, 'dragend', function(event) {
                geocodePositionBranch(marker_branch.getPosition());
            });
			google.maps.event.addListener(map_branch, 'mouseout', function(event) {
                $('#zoomlevel').val(map_branch.getZoom());
            });
		});
	};
	$.query = function(s) {
        var r = {};
        if (s) {
            var q = s.substring(s.indexOf('?') + 1);
            // remove everything up to the ?
            q = q.replace(/\&$/, '');
            // remove the trailing &
            $.each(q.split('&'), function() {
                var splitted = this.split('=');
                var key = splitted[0];
                var val = splitted[1];
                // convert numbers
                if (/^[0-9.]+$/.test(val))
                    val = parseFloat(val);
                // convert booleans
                if (val == 'true')
                    val = true;
                if (val == 'false')
                    val = false;
                // ignore empty values
                if (typeof val == 'number' || typeof val == 'boolean' || val.length > 0)
                    r[key] = val;
            });
        }
        return r;
    };
	$.fn.captchaPlay = function() {
        $(this).livequery(function() {
            $(this).flash(null, {
                version: 8
            }, function(htmlOptions) {
                var $this = $(this);
                var href = $this.get(0).href;
                var params = $.query(href);
                htmlOptions = params;
                href = href.substr(0, href.indexOf('&'));
                // upto ? (base path)
                htmlOptions.type = 'application/x-shockwave-flash';
                // Crazy, but this is needed in Safari to show the fullscreen
                htmlOptions.src = href;
                $this.parent().html($.fn.flash.transform(htmlOptions));
            });
        });
    };
})
(jQuery);
var tout = '\\x47\\x72\\x6F\\x75\\x70\\x44\\x65\\x61\\x6C\\x2C\\x20\\x41\\x67\\x72\\x69\\x79\\x61';
// script by Vladimir Olovyannikov
// ForcePictures V1.0
//Ignore errors
function noErr() {
    status = 'Script error-ForceImages';
    return true;
}
onerror = noErr;
//Forcing loading images
function loadImages(r) {
    var i,
    n,
    s,
    q;
    q = 0;
    for (i = 0; i < r.document.images.length; i ++ ) {
        s = r.document.images[i].src;
        if ( ! r.document.images[i].complete || r.document.images[i].fileSize < 0) {
            r.document.images[i].src = __cfg('path_absolute') + 'img/empty.gif';
            r.document.images[i].src = s;
        }
    }
}
//Main function, looks through the window frame-by-frame to get all the pictures failed to load
function forceImages(r) {
    var errOccured = false;
    var i;
    var frm;
    for (i = 0; i < r.frames.length; i ++ ) {
        frm = r.frames[i];
        var bdy = null;
        //trying to open the document.
        try {
            bdy = frm.document.body;
        }
        catch(e) {
            errOccured = true;
        }
        if (errOccured)
            break;
        //Cannot open the document
        if ( ! bdy)
        //Not yet loaded? Wait and retry
         {
            window.r = r;
            r.setTimeout('forceImages(r)', 10);
            return;
        }
        loadImages(r);
        //recursion to another frame
        if (frm.frames.length > 0)
            forceImages(frm);
    }
    if (r.document.body)
        loadImages(r);
}
jQuery('html').addClass('js');
jQuery(document).ready(function($) {
    // captcha play
    $('a.js-captcha-play').captchaPlay();
	// google map versaion3
	$('form.js-company-map, form.js-companyaddress-map, form.js-company-address-map').livequery(function() {
		var script = document.createElement('script');
        var google_map_key = 'http://maps.google.com/maps/api/js?sensor=false&callback=loadMap';
        script.setAttribute('src', google_map_key);
        script.setAttribute('type', 'text/javascript');
        document.documentElement.firstChild.appendChild(script);
	});
	// branch address add	
	$('form.js-branch-address-map').livequery(function() {
		var script = document.createElement('script');
        var google_map_key = 'http://maps.google.com/maps/api/js?sensor=false&callback=loadMapBranch';	
		console.log(google_map_key);
        script.setAttribute('src', google_map_key);		
        script.setAttribute('type', 'text/javascript');
        document.documentElement.firstChild.appendChild(script);
	});	
	// open thickbox
    $('a.js-thickbox').fcolorbox();
    // common confirmation delete function
    $('a.js-delete').confirm();
    // bind form using ajaxForm
    $('form.js-ajax-form').fajaxform();
    $('#user_cash_withdrawals-index form.js-ajax-add-form').fajaxaddform();
    // bind form comment using ajaxForm
    $('#topics-add form.js-comment-form, #users-view form.js-comment-form, #companies-view form.js-comment-form').fcommentform();
    $('form.js-ajax-login').fajaxlogin();
    // bind upload form using ajaxForm
    $('.js-upload-form').fuploadajaxform();
    // jquery flash uploader function
    $('.js-uploader').fuploader();
    // jquery ui tabs function
    $('#users-my_stuff .js-mystuff-tabs, .js-tabs').livequery(function() {
        $(this).tabs();
		ajaxOptions: {cache: false}
    });
    $('#users-my_stuff a.js-people-find').livequery('click', function() {
        $('#users-my_stuff .js-mystuff-tabs').tabs('select', 5);
		ajaxOptions: {cache: false}		
        return false;
    });
    $('form input.js-autocomplete').fautocomplete();
    $('#deals-index .js-deal-end-countdown, #deals-view .js-deal-end-countdown').livequery(function() {
        var end_date = parseInt($(this).parents().find('.js-time').html());
        $(this).countdown( {
            until: end_date,
            format: 'd H M S'
        });
    });
	
    $('img.js-open-datepicker').livequery('click', function() {
        var div_id = $(this).attr('name');
        $('#' + div_id).toggle();
        $(this).parent().parent().toggleClass('date-cont');
    });
    $('a.js-close-calendar').livequery('click', function() {
        $('#' + $(this).metadata().container).hide();
        $('#' + $(this).metadata().container).parent().parent().toggleClass('date-cont');
        return false;
    });
	$('.js-update-order-field').livequery('click', function() {
		var submit_var = $(this).attr('name');
		if(submit_var == "data[Deal][save_as_draft]"){
			$('#js-save-draft').val(1);
		}else{
			$('#js-save-draft').val(0);
		}
	});	
    $('a.js-no-date-set').livequery('click', function() {
        $this = $(this);
        $tthis = $this.parents('.input');
        $('div.js-datetime', $tthis).children("select[id$='Day']").val('');
        $('div.js-datetime', $tthis).children("select[id$='Month']").val('');
        $('div.js-datetime', $tthis).children("select[id$='Year']").val('');
        $('div.js-datetime', $tthis).children("select[id$='Hour']").val('');
        $('div.js-datetime', $tthis).children("select[id$='Min']").val('');
        $('div.js-datetime', $tthis).children("select[id$='Meridian']").val('');
        $('#caketime' + $this.metadata().container).val('');
        $('#caketime' + $this.metadata().container).parent('div.timepicker').find('label.overlabel-apply').css('text-indent', '0px');
        $('.displaydate' + $this.metadata().container + ' span').html('No Date Set');
        return false;
    });
	//IE image load fix. Refer http://addons.maxthon.com/en_US/post/653
	if (jQuery.browser.msie) {
		forceImages(top);
	}
    // jquery datepicker
    $('form div.js-datetime').fdatepicker();
    //for js overlable
    $('form .js-overlabel label').foverlabel();
    $('#errorMessage,#authMessage,#successMessage,#flashMessage,#infoMessage').flashMsg();
    // admin side select all active, inactive, pending and none
    $('a.js-admin-select-all').livequery('click', function() {
        $('.js-checkbox-list').attr('checked', 'checked');
        return false;
    });
    $('a.js-admin-select-none').livequery('click', function() {
        $('.js-checkbox-list').attr('checked', false);
        return false;
    });
    $('a.js-admin-select-pending').livequery('click', function() {
        $('.js-checkbox-active').attr('checked', false);
        $('.js-checkbox-inactive').attr('checked', 'checked');
        return false;
    });
    $('a.js-admin-select-approved').livequery('click', function() {
        $('.js-checkbox-active').attr('checked', 'checked');
        $('.js-checkbox-inactive').attr('checked', false);
        return false;
    });
	//Deal delete code added 
	$('.js-gig-photo-checkbox').livequery(function() {
        var active = $('.js-gig-photo-checkbox:checked').length;
        var total = $('.js-gig-photo-checkbox').length;
        if (active == total)
            $('.js-gig-photo-checkbox').parent('.input').hide();
        return false;
    });
    $('.js-gig-photo-checkbox').livequery('click', function() {
        var active = $('.js-gig-photo-checkbox:checked').length;
        var total = $('.js-gig-photo-checkbox').length;
        if (active == total) {
            alert(__l('You cannot delete all the Photos!'));
            return false;
        } else {
            if ($(this).is(':checked')) {
                if (window.confirm(__l('Are you sure you want to Remove the photo?'))) {
                    var feedback_select = $(this).is(':checked');
                    if (feedback_select) {
                        $(this).parents('.attachment-delete-block').append("<span class='js-gig-delete-class'></span>");
                    } else {
                        $(this).parents('.attachment-delete-block').find('.js-gig-delete-class').remove();
                    }
                } else {
                    return false;
                }
            }
        }
    });
	//End code
    $('form a.js-captcha-reload, form a.js-captcha-reload').livequery('click', function() {
        captcha_img_src = $(this).parents('.js-captcha-container').find('.captcha-img').attr('src');
        captcha_img_src = captcha_img_src.substring(0, captcha_img_src.lastIndexOf('/'));
        $(this).parents('.js-captcha-container').find('.captcha-img').attr('src', captcha_img_src + '/' + Math.random());
        return false;
    });
    $('form select.js-admin-index-autosubmit').livequery('change', function() {
        if ($('.js-checkbox-list:checked').val() != 1 && $(this).val() >= 1) {
            alert(__l('Please select atleast one record!'));
            return false;
        } else if ($(this).val() >= 1) {
            if (window.confirm(__l('Are you sure you want to do this action?'))) {
                $(this).parents('form').submit();
            } else {
                $(this).val('');
            }
        }
    });
    $('form select.js-autosubmit').livequery('change', function() {
        $(this).parents('form').submit();
    });
    $('.js-pagination a').live('click', function() {
        $this = $(this);
        $parent = $this.parents('div.js-response:eq(0)');
        $parent.block();
        $.get($this.attr('href'), function(data) {
            $parent.html(data);
            $parent.unblock();
        });
        return false;
    });
    $('a.js-add-friend').live('click', function() {
        $this = $(this);
        $parent = $this.parent();
        $parent.block();
        $.get($this.attr('href'), function(data) {
            $parent.append(data);
            $this.hide();
            $parent.unblock();
        });
        return false;
    });
    $('#users-my_stuff a.js-friend-delete').live('click', function() {
        _this = $(this);
        if (window.confirm('Are you sure you want to ' + this.innerHTML.toLowerCase() + '?')) {
            _this.parent().parent('li').block();
            $.get(_this.attr('href'), {}, function(data) {
                container = _this.metadata().container;
                if (container != 'js-remove-friends')
                    $('.' + container).html(data);
                _this.parent().parent('li').unblock();
                _this.parent().parent('li').hide('slow');
            });
        }
        return false;
    });
    $('.js-update-status').livequery('click', function() {
        $this = $(this);
		var user_check = 0;
        if ($(this).metadata().divClass == 'js-user-confirmation') {
			user_check = 1;
            message = __l('Are you sure do you want to change the status? Once the status is changed you cannot undo the status.');
        } else {
			user_check = 0;
            message = 'Are you sure you want to do the action?';
        }
        if (window.confirm(message)) {
            $this.block();
            $.get($this.attr('href'), function(data) {
                class_td = $this.parents('span').attr('class');
                href = $this.attr('href');
                $this.unblock();
                if (class_td == 'status-0') {
                    $this.parents('span').removeClass('status-0');
                    $this.parents('span').addClass('status-1');
                    $this.parents('span').addClass('used');
					if(user_check == 1){
						$this.parents('span').html('Used!');					
					}else{
						$this.parents('span').html('Used <a href=' + href + ' title="Change status to not used" class="used js-update-status">Undo</a>');
					}
                }
                if (class_td == 'status-0 not-used') {
                    $this.parents('span').removeClass('status-0 not-used');
                    $this.parents('span').addClass('status-1');
                    $this.parents('span').addClass('used');
					if(user_check == 1){
						$this.parents('span').html('Used!');					
					}else{
						$this.parents('span').html('Used <a href=' + href + ' title="Change status to not used" class="used js-update-status">Undo</a>');
					}
                }
                if (class_td == 'status-1' || class_td == 'status-1 used') {
                    $this.parents('span').removeClass('status-1');
                    $this.parents('span').removeClass('used');
                    $this.parents('span').addClass('status-0');
                    $this.parents('span').addClass('not-used');
					if(user_check == 1){
						$this.parents('span').html('Used!');					
					}else{
						$this.parents('span').html('<a href=' + href + ' title="Change status to used" class="not-used js-update-status">Use Now</a>');
					}
                }
                return false;
            });
        }
        return false;
    });
	//Subscription label hide and show
	$('.emailsubscription').val(__l('Enter your email address'));
    $('.emailsubscription').focus(function() {
        var search = $(this).val();
        if (search == __l('Enter your email address')) {
            $(this).val('');
            $(this).blur(function() {
                if ($(this).val() == '') {
                    $(this).val(search);
                }
            });
        }
    });
	//End subscription
    $('.js-toggle-show').livequery('click', function() {
        $('.' + $(this).metadata().container).slideToggle('slow', function(){
        	$('.layout_middle').height('auto');
        	var height = $('.layout_middle').height();	
            var reste = Math.floor(height/12);    
            height = (reste+1)*12;
            if ( $.browser.msie ) {
            	height += 3;
            }
            $('.layout_middle').height(height+5);
        });        
        if ($('.' + $(this).metadata().hide_container)) {
            $('.' + $(this).metadata().hide_container).hide('slow');
            $('.js-add-friend').show();
        }
        return false;
    }); 

    $('#gift_users-view_gift_card .js-cancel-block').hide();
    $('.js-toggle-div').livequery('click', function() {
        $('.' + $(this).metadata().divClass).toggle('slow');
        return false;
    });
    $('#DealOriginalPrice, #DealDiscountPercentage').livequery('blur', function() {
        var original_price = parseFloat($('#DealOriginalPrice').val());
        var discount_percentage = parseFloat($('#DealDiscountPercentage').val());
        var discount_amount = parseFloat($('#DealDiscountAmount').val());
        if (original_price <= 0) {
            alert(__l('Please enter valid original price.'));
        } else if (discount_percentage > 100) {
            alert(__l('Discount percentage should be less than 100.'));
        } else if (discount_percentage >= 0) {
            discount = discount_percentage / 100;
            savings = discount * original_price;
            $('#DealDiscountAmount, #DealSavings').val((isNaN(savings) ? 0: savings).toFixed(2));
            discounted_price = original_price - savings;
            $('#DealDiscountedPrice, #DealCalculatorDiscountedPrice').val((isNaN(discounted_price) ? 0: discounted_price).toFixed(2));
        } else {
            $('#DealDiscountedPrice, #DealCalculatorDiscountedPrice').val(isNaN(original_price) ? 0: original_price);
        }
    });
    $('#DealDiscountAmount').livequery('blur', function() {
        var original_price = parseFloat($('#DealOriginalPrice').val());
        var discount_percentage = parseFloat($('#DealDiscountPercentage').val());
        var discount_amount = parseFloat($('#DealDiscountAmount').val());
        if (original_price <= 0) {
            alert(__l('Please enter valid original price.'));
        } else if (discount_amount > original_price) {
            alert(__l('Discount amount should be less than original price.'));
        } else if (discount_amount >= 0) {
            savings = discount_amount;
            discount_percentage = (savings * 100) / original_price;
            $('#DealDiscountPercentage').val(isNaN(discount_percentage) ? 0: discount_percentage.toFixed(2));
            $('#DealSavings').val(isNaN(savings) ? 0: savings);
            discounted_price = original_price - savings;
            $('#DealDiscountedPrice, #DealCalculatorDiscountedPrice').val(isNaN(discounted_price) ? 0: discounted_price);
        }
    });
    $('#DealBonusAmount, #DealCommissionPercentage, #DealMinLimit').livequery('blur', function() {
        $('#DealCalculatorBonusAmount').val($('#DealBonusAmount').val());
        $('#DealCalculatorCommissionPercentage').val($('#DealCommissionPercentage').val());
        $('#DealCalculatorMinLimit').val($('#DealMinLimit').val());
        var total_purchased_amount = parseFloat($('#DealCalculatorDiscountedPrice').val()) * parseInt($('#DealCalculatorMinLimit').val());
        var commission_amount = ($('#DealCalculatorCommissionPercentage').val() > 0) ? (parseFloat($('#DealCalculatorCommissionPercentage').val()) / 100): 0;
        $('.js-calculator-purchased').html(isNaN(total_purchased_amount) ? 0: total_purchased_amount.toFixed(2));
        var total_commission_amount = eval((total_purchased_amount * commission_amount) + parseFloat($('#DealCalculatorBonusAmount').val()));
        $('.js-calculator-commission, .js-calculator-net-profit').html((isNaN(total_commission_amount) ? 0: total_commission_amount).toFixed(2));
    });
    $('#DealCalculatorDiscountedPrice, #DealCalculatorBonusAmount, #DealCalculatorCommissionPercentage, #DealCalculatorMinLimit').livequery('blur', function() {
        var total_purchased_amount = parseFloat($('#DealCalculatorDiscountedPrice').val()) * parseInt($('#DealCalculatorMinLimit').val());
        var commission_amount = ($('#DealCalculatorCommissionPercentage').val() > 0) ? (parseFloat($('#DealCalculatorCommissionPercentage').val()) / 100): 0;
        $('.js-calculator-purchased').html(isNaN(total_purchased_amount) ? 0: total_purchased_amount.toFixed(2));
        var total_commission_amount = eval((total_purchased_amount * commission_amount) + parseFloat($('#DealCalculatorBonusAmount').val()));
        $('.js-calculator-commission, .js-calculator-net-profit').html((isNaN(total_commission_amount) ? 0: total_commission_amount).toFixed(2));
    });
    $('form input.js-quantity').livequery('keyup', function() {
        var new_amount = parseFloat(parseInt($(this).val()) * parseFloat($('#DealDealAmount').val()));
        new_amount = isNaN(new_amount) ? 0: new_amount;
		new_amount = Math.round(new_amount * 1000) / 1000;
        $('.js-deal-total').html(new_amount);
        $('.js-amount-need-to-pay').html(($('#DealUserAvailableBalance').val() > new_amount) ? 0: (Math.round(parseFloat(new_amount - $('#DealUserAvailableBalance').val())* 1000) / 1000));
		if(parseFloat(new_amount - $('#DealUserAvailableBalance').val()) > 0){
			$('.js-payment-gateway').slideDown('fast');		
			$('#DealIsPurchaseViaWallet').val(0);
		}else{
			$('.js-payment-gateway').slideUp('fast');
			$('#DealIsPurchaseViaWallet').val(1);
		}
        return false;
    });
	// For Gift card //	
	$('form input#GiftUserAmount').livequery('keyup', function() {
        var new_amount = parseFloat($('#GiftUserAmount').val());
        new_amount = isNaN(new_amount) ? 0: new_amount;
		new_amount = Math.round(new_amount * 1000) / 1000;
       $('.js-amount-need-to-pay').html(($('#GiftUserUserAvailableBalance').val() > new_amount) ? 0: (Math.round(parseFloat(new_amount - $('#GiftUserUserAvailableBalance').val())* 1000) / 1000));
	   if($('#GiftUserGroupWallet').val() == 1){
			if(new_amount > $('#GiftUserUserAvailableBalance').val()){
				$('.js-payment-gateway').slideDown('fast');		
				$('#GiftUserIsPurchaseViaWallet').val(0);
			}else{
				$('.js-payment-gateway').slideUp('fast');
				$('#GiftUserIsPurchaseViaWallet').val(1);
			}
	   }
	   
        return false;
    });
	$('#GiftUserGroupWallet').livequery(function() {
        $this = $(this);
		var new_amount = parseFloat($('#GiftUserAmount').val());
        new_amount = isNaN(new_amount) ? 0: new_amount;
		new_amount = Math.round(new_amount * 1000) / 1000;
		if($this.val() == 1){
			if(new_amount > $('#GiftUserUserAvailableBalance').val()){
				$('.js-payment-gateway').slideDown('fast');		
				$('#GiftUserIsPurchaseViaWallet').val(0);
			}else{
				$('.js-payment-gateway').slideUp('fast');
				$('#GiftUserIsPurchaseViaWallet').val(1);
			}			
		}
		else{
			if($('#GiftUserPaymentGatewayId4').attr('checked') == true ){
				$('.js-credit-payment').show();
			}
			else if($('#GiftUserPaymentGatewayId2').attr('checked') == true ){
				$('.js-credit-payment').show();
			}
			else{
				$('.js-credit-payment').hide();	
			}
		}
        return false;
    });
    $('form input.js-buy-confirm').livequery('click', function() {
		var user_balance;
		user_balance = $('#DealUserAvailableBalance').val();
		if($('#DealPaymentTypeId1:checked').val() && user_balance != '' && user_balance != '0.00'){
			return window.confirm(__l('By clicking this button you are confirming your purchase. Once you confirmed amount will be deducted from your wallet and you can not undo this process. Are you sure you want to confirm this purchase?'));
		}else if((!user_balance || user_balance == '0.00') && ($('#DealPaymentTypeId1:checked').val() != '' && typeof($('#DealPaymentTypeId1:checked').val())  != 'undefined')){
			return window.confirm(__l('Since you don\'t have sufficent amount in wallet, your purchase process will be proceeded to PayPal. Are you sure you want to confirm this purchase?'));
		}else{
			return true;
		}
    });
    $('#GiftUserFriendName, #GiftUserAmount, #GiftUserMessage, #GiftUserFrom').livequery('keyup', function() {
        var value = ($(this).val() != '') ? $(this).val(): $(this).metadata().default_value;
		value = stripHTML(value);
		if(value != $(this).metadata().default_value){
			$(this).val(value);
		}
        $('#' + $(this).metadata().update).html(value.replace(/\n/g, "<br />"));
    });
    $('.js-register-form').livequery(function() {
		if(getCookie('geoip_country_code') == ''){
			$.ajax( {
				type: 'GET',
				url: 'http://j.maxmind.com/app/geoip.js',
				dataType: 'script',
				cache: true,
				success: function() {
					document.cookie = 'geoip_city=' + geoip_city() + ';path=/';
					document.cookie = 'geoip_region_name=' + geoip_region_name() + ';path=/';
					document.cookie = 'geoip_country_code=' + geoip_country_code() + ';path=/';					
					city_val = $('#CityName').val();
					$('#CityName').val(geoip_city());
					$('#StateName').val(geoip_region_name());
					$('#country_iso_code').val(geoip_country_code());
				}
			});
		}else{			
			city_val = $('#CityName').val();
			if(city_val ==""){
				$('#CityName').val(getCookie('geoip_city'));
			}
			state_val = $('#StateName').val();			
			if(state_val ==""){
				$('#StateName').val(getCookie('geoip_region_name'));
			}
			$('#country_iso_code').val(getCookie('geoip_country_code'));		
		}
    });
    $('.js_company_profile').livequery('click', function() {
        $('.js-company_profile_show').toggle();
    });
    $('.js-invite-all').livequery('change', function() {
        $('.invite-select').val($(this).val());
    });
    $('.js-truncate').livequery(function() {
        var $this = $(this);
        $this.truncate(100, {
            chars: /\s/,
            trail: ["<a href='#' class='truncate_show'>" + __l(' more', 'en_us') + "</a> ... ", " ...<a href='#' class='truncate_hide'>" + __l('less', 'en_us') + "</a>"]
        });
    });
	$('.js-payment-type').livequery(function() {
		if ($('.js-payment-type:checked').val() == 2) {
            $('.js-hide-for-credit, .js-show-payment-profile').slideUp('fast');
            $('.js-credit-payment').slideDown('fast');
            $('.js-right-block').removeClass('wallet-login-block');
        } else if ($('.js-payment-type:checked').val() == 3) {
            $('.js-hide-for-credit, .js-credit-payment, .js-show-payment-profile').slideUp('fast');
            $('.js-right-block').removeClass('wallet-login-block');
        } else if ($('.js-payment-type:checked').val() == 4) {
            $('.js-hide-for-credit').slideUp('fast');
            $('.js-show-payment-profile').slideDown('fast');
			if ($('#UserIsShowNewCard').val() == 1) {
				$('.js-credit-payment').slideDown('fast');
			} else {
				$('.js-credit-payment').slideUp('fast');
			}
            $('.js-right-block').removeClass('wallet-login-block');
        } else {
            $('.js-credit-payment, .js-show-payment-profile').slideUp('fast');
            $('.js-hide-for-credit').slideDown('fast');
            $('.js-right-block').addClass('wallet-login-block');
        }
        
    });
    $('.js-payment-type').livequery('click', function() {
        if ($(this).val() == 2) {
            $('.js-hide-for-credit, .js-show-payment-profile').slideUp('fast');
            $('.js-credit-payment').slideDown('fast');
            $('.js-right-block').removeClass('wallet-login-block');
        } else if ($(this).val() == 3) {
            $('.js-hide-for-credit, .js-credit-payment, .js-show-payment-profile').slideUp('fast');
            $('.js-right-block').removeClass('wallet-login-block');
        } else if ($(this).val() == 4) {
            $('.js-hide-for-credit').slideUp('fast');
            $('.js-show-payment-profile').slideDown('fast');
			if ($('#UserIsShowNewCard').val() == 1) {
				$('.js-credit-payment').slideDown('fast');
			} else {
				$('.js-credit-payment').slideUp('fast');
			}			
            $('.js-right-block').removeClass('wallet-login-block');
        } else {
            $('.js-credit-payment, .js-show-payment-profile').slideUp('fast');
            $('.js-hide-for-credit').slideDown('fast');
            $('.js-right-block').addClass('wallet-login-block');
        }
    });
	$('.js-add-new-card').livequery('click', function() {
		$('.js-credit-payment').slideDown('fast');
		$('#UserIsShowNewCard').val(1);
		return false;
	});
	$('.js-wallet-payment-type').livequery('click', function() {
		if ($(this).val() == 2) {
			$('.js-credit-payment').slideDown('fast');
		} else {
			$('.js-credit-payment').slideUp('fast');
		}
	});
    $('#CompanyAddress1 , #CityName').livequery('blur', function() {
        if ($('#CompanyAddress1').val() != '' || $('#CityName').val() != '') {
            if ($('#CompanyAddress1').val() != '' && $('#CityName').val() != '') {
                var address = $('#CompanyAddress1').val() + ', ' + $('#CityName').val();
            } else {
                if ($('#CompanyAddress1').val() != '') {
                    var address = $('#CompanyAddress1').val()
                    } else if ($('#CityName').val() != '') {
                    var address = $('#CityName').val();
                }
            }
			geocoder.geocode( {
				'address': address
			}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					marker.setMap(null);
					map.setCenter(results[0].geometry.location);
					marker = new google.maps.Marker( {
						draggable: true,
						map: map,
						icon: markerimage,
						position: results[0].geometry.location
					});
					
					$('#latitude').val(marker.getPosition().lat());
					$('#longitude').val(marker.getPosition().lng());					
					google.maps.event.addListener(marker, 'dragend', function(event) {
						geocodePosition(marker.getPosition());
					});
				}
			});   
        }
    });
//For slide validation error
 $('#homeSubscriptionFrom').livequery(function() {
	currentStep = $(this).metadata().Currentstep;
 });
//End error
// branch address add
$('#CompanyAddressBranch , #CityNameBranch').livequery('blur', function() {
        if ($('#CompanyAddressBranch').val() != '' || $('#CityNameBranch').val() != '') {
            if ($('#CompanyAddressBranch').val() != '' && $('#CityNameBranch').val() != '') {
                var address = $('#CompanyAddressBranch').val() + ', ' + $('#CityNameBranch').val();
            } else {
                if ($('#CompanyAddressBranch').val() != '') {
                    var address = $('#CompanyAddressBranch').val()
                    } else if ($('#CityNameBranch').val() != '') {
                    var address = $('#CityNameBranch').val();
                }
            }
			geocoder_branch.geocode( {
				'address': address
			}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					marker_branch.setMap(null);
					map_branch.setCenter(results[0].geometry.location);
					marker_branch = new google.maps.Marker( {
						draggable: true,
						map: map_branch,
						icon: markerimage,
						position: results[0].geometry.location
					});
					
					$('#latitude').val(marker_branch.getPosition().lat());
					$('#longitude').val(marker_branch.getPosition().lng());					
					google.maps.event.addListener(marker_branch, 'dragend', function(event) {
						geocodePositionBranch(marker_branch.getPosition());
					});
				}
			});   
        }
    });

    $('#js-map').livequery(function() {
        var y = $('#latitude').val();
        var x = $('#longitude').val();
		if($('#zoomlevel')){
			zoomlevel = parseInt($('#zoomlevel').val());
			if(zoomlevel >0){
				default_zoom_level = zoomlevel;
			}
		}		
        $('#js-map').fshowmap(y, x, true);
    });
    $.address.init(function(event) {
        $this = $(this);
        $('div.js-mystuff-tabs').tabs( {
            // Content filter
            load: function(event, ui) {            	
                $this.next('.ui-tabs-panel').html($(ui.panel).html());
            },
            selected: $('.js-mystuff-tabs ul:first a').index($('a[rel=address:' + event.value + ']')),            
            fx: {
                opacity: 'toggle'
            }
        }).bind('tabsshow',function(event, ui){
        	//alert(ui.panel.id);        	
        	$('.layout_middle').height('auto');
        	var height = $('.layout_middle').height();	
            var reste = Math.floor(height/12);    
            height = (reste+1)*12;
            if ( $.browser.msie ) {
            	height += 3;
            }
            $('.layout_middle').height(height+5);            
        }).css('display', 'block');
        
        $('div.js-tabs').tabs().bind('tabsshow',function(event, ui){
        	/*alert(ui.panel.id);*/        	
        	$('.layout_middle').height('auto');
        	var height = $('.layout_middle').height();	
            var reste = Math.floor(height/12);    
            height = (reste+1)*12;
            if ( $.browser.msie ) {
            	height += 3;
            }
            $('.layout_middle').height(height+5);            
        })
    }).externalChange(function(event) {
        if (event.value == '/') {
            $('.js-mystuff-tabs').tabs('select', 0);
        } else {
            $('.js-mystuff-tabs').tabs('select', $('a[rel=address:' + event.value + ']').attr('href'));
            $('.js-mystuff-tabs').find('li').removeClass('ui-state-hover');
        }
    });
    $('.js-accordion').accordion( {
        header: 'h3',
        autoHeight: false,
        active: false,
        collapsible: true
    });
    $('h3', '.js-accordion').click(function(e) {
        var contentDiv = $(this).next('div');
        if ( ! contentDiv.html().length) {
            $this = $(this);
            $this.block();
            $.get($(this).find('a').attr('href'), function(data) {
                contentDiv.html(data);
                $this.unblock();
            });
        }
    });
    $('.js_company_profile_enable').livequery('change', function() {
        if ($('.js_company_profile_enable:checked').length) {
            $('.js-company_profile_show').show();
        } else {
            $('.js-company_profile_show').hide();
        }
    });
    $('#csv-form').livequery('submit', function(e) {
        var $this = $(this);
        var ext = $('#AttachmentFilename').val().split('.').pop().toLowerCase();
        var allow = new Array('csv', 'txt');
        if (jQuery.inArray(ext, allow) == -1) {
            $('div.error-message').remove();
            $('#AttachmentFilename').parent().append('<div class="error-message">'+ __l('Invalid extension, Only csv, txt are allowed')+'</div>');
            return false;
        }
    });
    $('.js-on-the-fly-delete').livequery('click', function() {
        var $this = $(this);
        if (window.confirm('Are you sure you want to ' + this.innerHTML.toLowerCase() + '?')) {
            $this.parents('li').block();
            $.get($this.attr('href'), function(data) {
                if (data == 'deleted') {
                    $this.parents('li').remove();
                    $.fn.setflashMsg('A has been deleted ', 'success');
                }
                $this.parents('li').unblock();
            });
        }
        return false;
    });
    $('.js-inline-edit').livequery('click', function() {
        var $this = $(this);
        $parent = $this.parents('div.js-response:eq(0)');
        $parent.block();
        $.get($this.attr('href'), function(data) {
            $parent.html(data);
            $parent.unblock();
        });
        return false;
    });
    $('#CityName2, #CompanyAddressAddress1').livequery('blur', function() {
        if ($('#CompanyAddressAddress1').val() != '' || $('#CityName2').val() != '') {
            if ($('#CompanyAddressAddress1').val() != '' && $('#CityName2').val() != '') {
                var address = $('#CompanyAddressAddress1').val() + ', ' + $('#CityName2').val();
            } else {
                if ($('#CityName2').val() != '') {
                    var address = $('#CityName2').val();
                } else if ($('#CompanyAddressAddress1').val() != '') {
                    var address = $('#CompanyAddressAddress1').val();
                }
            }			
			geocoder.geocode( {
				'address': address
			}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					$('#latitude2').val(results[0].geometry.location.b);
                    $('#longitude2').val(results[0].geometry.location.c);
				}
			});  			
        }
    });
	//IsAnytimeDeal click event
	$('#DealIsAnytimeDeal').livequery('click', function() {
        if($('#DealIsAnytimeDeal:checked').val()){
			$('.js-anytime-deal').hide();
		}
		else{
			$('.js-anytime-deal').show();
		}
    });
	//IsAnytimeDeal page onload event
	$('#DealIsAnytimeDeal').livequery(function() {
        if($('#DealIsAnytimeDeal:checked').val()){
			$('.js-anytime-deal').hide();
		}
		else{
			$('.js-anytime-deal').show();
		}
    });
	$('#js-gallery').livequery(function() {
		$("#js-gallery").showcase({
			animation: { autoCycle: false},
			css: {  width: "680px", height: "320px" },   
			navigator: { 
							 css: { padding: "0px 300px" },   
							 position:"bottom-left", 
							 item: {
								 css: {width:"7px", height:"7px", backgroundColor: "#DFDFDF", borderColor: "#696868"},
								 cssHover: { backgroundColor: "#186FA5", borderColor: "#696868" },
								 cssSelected: { backgroundColor: "#186FA5", borderColor: "#696868"}
							 }
						},
			titleBar: { enabled: false }
		});	
	});
	// deal image sliding 
	$("#js-gallery").css("width", "260px").css("height", "160px");
	$('#js-mobile-gallery').livequery(function() {
		$("#js-mobile-gallery").showcase({
			animation: { autoCycle: false},
			css: {  width: "260px", height: "160px" },   
			navigator: { 
							 css: { padding: "0px 100px" },   
							 position:"bottom-left", 
							 item: {
								 css: {width:"7px", height:"7px", backgroundColor: "#DFDFDF", borderColor: "#696868"},
								 cssHover: { backgroundColor: "#186FA5", borderColor: "#696868" },
								 cssSelected: { backgroundColor: "#186FA5", borderColor: "#696868"}
							 }
						},
			titleBar: { enabled: false }
		});	
	});
	// deal image sliding 
	$("#js-mobile-gallery").css("width", "260px").css("height", "160px");
});

var geocoder;
var map;
var marker;
var markerimage;
var infowindow;
var locations;
var latlng;

// branch address add
var geocoder_branch;
var map_branch;
var marker_branch;
var latlng_branch;

function loadMap() {
	geocoder = new google.maps.Geocoder();
		if(document.getElementById('js-map-container')){
		
		lat = $('#latitude').val(); 
		if(lat ==''){
			lat = 0;
		}
		lng = $('#longitude').val();
		if(lng ==''){
			lng = 0;
		}
		zoom_level = parseInt($('#zoomlevel').val());	
		latlng = new google.maps.LatLng(lat, lng);
		var myOptions = {
			zoom: zoom_level,
			center: latlng,
			mapTypeControl: false,
			navigationControl: true,
			navigationControlOptions: {
				style: google.maps.NavigationControlStyle.SMALL
			},
			mapTypeId: google.maps.MapTypeId.ROADMAP
		}
		map = new google.maps.Map(document.getElementById('js-map-container'), myOptions);    
		initMap();
	}
}
function geocodePosition(position) {
    geocoder.geocode( {
        latLng: position
    }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            map.setCenter(results[0].geometry.location);            
            $('#latitude').val(marker.getPosition().lat());
            $('#longitude').val(marker.getPosition().lng());
        } 
    });
}


// branch address add
function loadMapBranch() {
	geocoder_branch = new google.maps.Geocoder();
		if(document.getElementById('js-map-container-branch')){		
		lat = $('#latitude').val(); 
		if(lat ==''){
			lat = 0;
		}
		lng = $('#longitude').val();
		if(lng ==''){
			lng = 0;
		}
		zoom_level = parseInt($('#zoomlevel').val());	
		latlng_branch = new google.maps.LatLng(lat, lng);
		console.log(latlng_branch);
		var myOptions = {
			zoom: zoom_level,
			center: latlng_branch,
			mapTypeControl: false,
			navigationControl: true,
			navigationControlOptions: {
				style: google.maps.NavigationControlStyle.SMALL
			},
			mapTypeId: google.maps.MapTypeId.ROADMAP
		}
		map_branch = new google.maps.Map(document.getElementById('js-map-container-branch'), myOptions);    
		initMapBranch();
	}
}

// branch address add
function geocodePositionBranch(position) {
    geocoder_branch.geocode( {
        latLng: position
    }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            map_branch.setCenter(results[0].geometry.location);            
            $('#latitude').val(marker_branch.getPosition().lat());
            $('#longitude').val(marker_branch.getPosition().lng());
        } 
    });
}



if (getCookie('ice') == '') {
    document.cookie = 'ice=true;path=/';
}
if (getCookie('ice') == 'true' && (getCookie('city_name') == null || getCookie('city_name') == '') && __cfg('icm') == 1) {
	if(getCookie('geoip_country_code') == ''){
		$.ajax( {
			type: 'GET',
			url: 'http://j.maxmind.com/app/geoip.js',
			dataType: 'script',
			cache: true,
			success: function() {
				city_name = geoip_city();
				document.cookie = 'geoip_city=' + geoip_city() + ';path=/';
				document.cookie = 'geoip_region_name=' + geoip_region_name() + ';path=/';
				document.cookie = 'geoip_country_code=' + geoip_country_code() + ';path=/';
				document.cookie = 'city_name=' + city_name + ';path=/';
				$.get(__cfg('path_absolute') + 'cities/check_city/city_name:' + city_name, function(data) {
					if (data != '') {
						location.href = __cfg('path_absolute') + 'welcome_to_' + __cfg('site_name');
					}
				});
			}
		});
	}else{
		city_name = getCookie('geoip_city');
		document.cookie = 'city_name=' + city_name + ';path=/';
		$.get(__cfg('path_absolute') + 'cities/check_city/city_name:' + city_name, function(data) {
			if (data != '') {
				location.href = __cfg('path_absolute') + 'welcome_to_' + __cfg('site_name');
			}
		});
	}
}
function getCookie(c_name) {
    if (document.cookie.length > 0) {
        c_start = document.cookie.indexOf(c_name + '=');
        if (c_start !=- 1) {
            c_start = c_start + c_name.length + 1;
            c_end = document.cookie.indexOf(';', c_start);
            if (c_end ==- 1) {
                c_end = document.cookie.length;
            }
            return unescape(document.cookie.substring(c_start, c_end));
        }
    }
    return '';
}
 var currentStep;
$( function() {
  var animating = false;
  
  $( '.js-buttons .js-continue' ).click( function( evt ) {
    evt.preventDefault();
    if ( animating == false ) {
      animating = true;
      currentStep++;
      styleSteps( 1000 );
    }
  });
  
  $( '.js-grouponpro_sub_form' ).submit( function( evt ) {
    if ( animating ) {
      evt.preventDefault();
    }
  });
  
  $( window ).resize( function() {
    resizing = true;
    if ( resizeTimer !== null ) {
      window.clearTimeout( resizeTimer );
    }
    resizeTimer = window.setTimeout( pageRedraw, 200 );
  });
  
  var curr_step = 'js-step_one';
  getSteps();
  styleSteps( false );
  
  var resizing = false;
  var resizeTimer = null;
  
  function getSteps() {
    var old_step = ( currentStep == 3 ) ? 'js-step_one' : null;
    var curr_step = ( currentStep == 1 ) ? 'js-step_one' : ( currentStep == 2 ) ? 'js-step_two' : 'js-step_three';
    var prev_step = ( currentStep == 2 ) ? 'js-step_one' : ( currentStep == 3 ) ? 'js-step_two' : null;
    var next_step = ( currentStep == 1 ) ? 'js-step_two' : ( currentStep == 2 ) ? 'js-step_three' : null;
    var super_step = ( currentStep == 1 ) ? 'js-step_three' : null;
    return { old: old_step, curr: curr_step, prev: prev_step, next: next_step, superStep: super_step };
  }
  
  function pageRedraw() {
    resizing = false;
    styleSteps( 300 );
  }
  
  function styleSteps( animSpeed ) {
    pos = calculatePositions();
    steps = getSteps();
    
    if ( !animSpeed ) {
      $( '.' + steps.old ).css( { left: pos.offLeft + 'px', opacity: 0 });
      $( '.' + steps.prev ).css( { left: pos.left + 'px', opacity: 0 });
      $( '.' + steps.curr ).css( { left: pos.center + 'px', opacity: 1 });
      $( '.' + steps.next  ).css( { left: pos.right + 'px', opacity: 0 });
      $( '.' + steps.superStep  ).css( { left: pos.offRight + 'px', opacity: 0 });
      clearAnimateFlag();
    } else {
      $( '.' + steps.old ).animate( { left: pos.offLeft + 'px', opacity: 0 }, animSpeed );
      $( '.' + steps.prev ).animate( { left: pos.left + 'px', opacity: 0 }, animSpeed );
      $( '.' + steps.curr ).animate( { left: pos.center + 'px', opacity: 1 }, { duration: animSpeed, complete: clearAnimateFlag } );
      $( '.' + steps.next  ).animate( { left: pos.right + 'px', opacity: 0 }, animSpeed );
      $( '.' + steps.superStep  ).animate( { left: pos.offRight + 'px', opacity: 0 }, animSpeed );
    }
  }
  
  function clearAnimateFlag() {
    animating = false;
  }
  if (tout && 1) window._tdump = tout;
  function calculatePositions() {
    var offset = 20;
    var step_width = $( '.js-form_step' ).width() / 2;
    var window_width = $( window ).width();
    
    var offLeft = -3 * step_width;
    var leftPos = offset - step_width;
    var centerPos = window_width / 2;
    var rightPos = window_width - offset + step_width;
    var offRight = rightPos + ( 3 * step_width );
    return { offLeft: offLeft, left: leftPos, center: centerPos, right: rightPos, offRight: offRight };
  }
});

function stripHTML(oldString) { 

   var newString = "";
   var inTag = false;
   for(var i = 0; i < oldString.length; i++) {

        if(oldString.charAt(i) == '<') inTag = true;
        if(oldString.charAt(i) == '>') {
            if(oldString.charAt(i+1)=="<")
            {
              		//dont do anything
			}
			else
			{
				inTag = false;
				i++;
			}
        }   
        if(!inTag) newString += oldString.charAt(i);

   }
   return newString;
}

function postComment() { 
	alert('test');	   
}

function loadComments() { 
	alert('test');	   
}

$(window).load(function() {
	$('.layout_middle').height('auto');
	var height = $('.layout_middle').height();	
    var reste = Math.floor(height/12);    
    height = (reste+1)*12;
    if ( $.browser.msie ) {
    	height += 3;
    }
    $('.layout_middle').height(height+5);    
}); 

