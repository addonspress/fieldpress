(function ( $, window, document, undefined ) {
    'use strict';

    var fieldpress_document = $(document),
    fieldpress_body = $('body'),
    fieldpress_window = $(window);

    /*Color Picker*/
    if( typeof Color === 'function' ) {

        /*adding alpha support for Automattic Color.js toString function.*/
        Color.fn.toString = function () {

            /*check for alpha*/
            if ( this._alpha < 1 ) {
                return this.toCSS('rgba', this._alpha).replace(/\s+/g, '');
            }

            var hex = parseInt( this._color, 10 ).toString( 16 );

            if ( this.error ) { return ''; }

            /*maybe left pad it*/
            if ( hex.length < 6 ) {
                for (var i = 6 - hex.length - 1; i >= 0; i--) {
                    hex = '0' + hex;
                }
            }
            return '#' + hex;
        };
    }

    var FPPARSERGBACOLOR = function( val ) {

        var value = val.replace(/\s+/g, ''),
            alpha = ( value.indexOf('rgba') !== -1 ) ? parseFloat( value.replace(/^.*,(.+)\)/, '$1') * 100 ) : 100,
            rgba  = ( alpha < 100 );
        return { value: value, alpha: alpha, rgba: rgba };
    };

    var FPCOLORPICKER = function( $this ) {
       
        /*Default Color Picker*/
        if( $this.data('rgba') && $this.data('rgba') === 1 ){
            /*parse rgba*/
            var picker = FPPARSERGBACOLOR( $this.val() );
            $this.wpColorPicker({

                /*wpColorPicker.clear*/
                clear: function() {
                    $this.trigger('keyup');
                },

                /*wpColorPicker.change*/
                change: function( event, ui ) {

                    var ui_color_value = ui.color.toString();

                    /*update checkerboard background color*/
                    $this.closest('.wp-picker-container').find('.fp-rgba-slider-offset').css('background-color', ui_color_value);
                    $this.val(ui_color_value).trigger('change');
                },

                /*wpColorPicker.create*/
                create: function() {

                    /*set variables for alpha slider*/
                    var a8cIris       = $this.data('a8cIris'),
                        $container    = $this.closest('.wp-picker-container'),

                        /*appending alpha wrapper*/
                        $alpha_wrap   = $('<div class="fp-rgba-wrap">' +
                            '<div class="fp-rgba-slider"></div>' +
                            '<div class="fp-rgba-slider-offset"></div>' +
                            '<div class="fp-rgba-text"></div>' +
                            '</div>').appendTo( $container.find('.wp-picker-holder') ),

                        $alpha_slider = $alpha_wrap.find('.fp-rgba-slider'),
                        $alpha_text   = $alpha_wrap.find('.fp-rgba-text'),
                        $alpha_offset = $alpha_wrap.find('.fp-rgba-slider-offset');

                    /*alpha slider*/
                    $alpha_slider.slider({

                        /*slider.slide*/
                        slide: function( event, ui ) {

                            var slide_value = parseFloat( ui.value / 100 );

                            /*update iris data alpha && wpColorPicker color option && alpha text*/
                            a8cIris._color._alpha = slide_value;
                            $this.wpColorPicker( 'color', a8cIris._color.toString() );
                            $alpha_text.text( ( slide_value < 1 ? slide_value : '' ) );
                        },

                        /*slider: create*/
                        create: function() {

                            var slide_value = parseFloat( picker.alpha / 100 ),
                                alpha_text_value = slide_value < 1 ? slide_value : '';

                            /*update alpha text && checkerboard background color*/
                            $alpha_text.text(alpha_text_value);
                            $alpha_offset.css('background-color', picker.value);

                            /*wpColorPicker clear for update iris data alpha && alpha text && slider color option*/
                            $container.on('click', '.wp-picker-clear', function() {

                                a8cIris._color._alpha = 1;
                                $alpha_text.text('').trigger('change');
                                $alpha_slider.slider('option', 'value', 100).trigger('slide');
                            });

                            /*wpColorPicker default button for update iris data alpha && alpha text && slider color option*/
                            $container.on('click', '.wp-picker-default', function() {

                                var default_picker = FPPARSERGBACOLOR( $this.data('default-color') ),
                                    default_value  = parseFloat( default_picker.alpha / 100 ),
                                    default_text   = default_value < 1 ? default_value : '';
                                a8cIris._color._alpha = default_value;
                                $alpha_text.text(default_text);
                                $alpha_slider.slider('option', 'value', default_picker.alpha).trigger('slide');
                            });

                            /*show alpha wrapper on click color picker button*/
                            $container.on('click', '.wp-color-result', function() {
                                $alpha_wrap.toggle();
                            });

                            /*hide alpha wrapper on click body*/
                            fieldpress_document.on( 'click.wpcolorpicker', function() {
                                $alpha_wrap.hide();
                            });
                        },

                        /* slider: options  */
                        value: picker.alpha,
                        step: 1,
                        min: 1,
                        max: 100
                    });
                }
            });
        }
        else{
            $this.wpColorPicker( {
                change: _.throttle( function() {  /* For Customizer  */

                    $this.trigger( 'change' );
                }, 3000 ),
                clear: _.throttle( function() {  /* For Customizer  */
                    $this.trigger( 'change' );
                }, 4000 )
            });
        }
    };

    /*time picker*/
    var FPDATEPICKER = function( $this ) {
        if( $this.data('fieldpress-time') && $this.data('time-only')){
            $this.timepicker({
                timeFormat: $this.data('time-format')
            });
        }
        else if( $this.data('fieldpress-time') ){
            $this.datetimepicker({
                timeFormat: $this.data('time-format'),
                dateFormat: $this.data('date-format')
            });
        }
        else{
            $this.datepicker({
                showButtonPanel: true,
                dateFormat: $this.data('date-format')
            });
        }
    };

    /*SELECT2*/
    var FPSELECT2 = function( $this ) {
        $this.select2({
            width: 'resolve'
        });
    };

    /*image loader*/
    var FPIMAGEUPLOAD = function () {
        fieldpress_document.on('click', '.fieldpress-image-uploader-open', function (e){
            e.preventDefault();
            var image_uploader_open = $(this),
                image_wrapper = image_uploader_open.closest('.fieldpress-field.fieldpress-image'),
                preview = image_wrapper.find('.fieldpress-image-preview'),
                input   = image_wrapper.find('input'),
                image     = image_wrapper.find('img'),
                wp_media_frame;

            /* Check if the `wp.media.gallery` API exists. */
            if ( typeof wp === 'undefined' || ! wp.media || ! wp.media.gallery ) {
                return;
            }
            /* If the media frame already exists, reopen it. */
            if ( wp_media_frame ) {
                wp_media_frame.open();
                return;
            }
            /* Create the media frame. */
            wp_media_frame = wp.media({
                library: {
                    type: 'image'
                },
                title: image_uploader_open.data('upload'),
                button: {
                    text: image_uploader_open.data('button-text')
                }
            });

            /*select selected image*/
            wp_media_frame.on('open', function(){
                var selected = input.val(); // the id of the image
                if (selected) {
                    var selection = wp_media_frame.state().get('selection'),
                        attachment = wp.media.attachment(selected);
                    selection.add(attachment);
                }
            });

            /* When an image is selected, run a callback. */
            wp_media_frame.on( 'select', function() {
                var attachment = wp_media_frame.state().get('selection').first().toJSON(),
                    thumbnail  = ( typeof attachment.sizes.thumbnail !== 'undefined' ) ? attachment.sizes.thumbnail.url : attachment.url;

                preview.removeClass('hidden');
                image.attr('src', thumbnail);
                input.val( attachment.id );
                input.trigger('change');
            });

            /* Finally, open the modal. */
            wp_media_frame.open();
        });

        /* Remove image */
        fieldpress_document.on('click','.fieldpress-clear',function (e) {
            e.preventDefault();
            var image_wrapper = $(this).closest('.fieldpress-field.fieldpress-image'),
                preview = image_wrapper.find('.fieldpress-image-preview'),
                input   = image_wrapper.find('input');

            input.val('');
            preview.addClass('hidden');
        });
    };

    /*image loader*/
    var FPGALLERYUPLOAD = function () {
        fieldpress_document.on('click', '.fieldpress-gallery-uploader-open,.fieldpress-gallery-updater-open', function (e){
            e.preventDefault();
            var image_uploader_open = $(this),
                image_wrapper = image_uploader_open.closest('.fieldpress-field.fieldpress-gallery'),
                preview = image_wrapper.find('.fieldpress-gallery-preview'),
                add = image_wrapper.find('.fieldpress-gallery-uploader-open'),
                update = image_wrapper.find('.fieldpress-gallery-updater-open'),
                remove = image_wrapper.find('.fieldpress-remove'),
                input   = image_wrapper.find('input'),
                wp_media_frame,
                state = ( image_uploader_open.hasClass('fieldpress-gallery-updater-open') ) ? 'gallery-edit' : 'gallery-library';

            /* Check if the `wp.media.gallery` API exists. */
            if ( typeof wp === 'undefined' || ! wp.media || ! wp.media.gallery ) {
                return;
            }
            /*  If the media frame already exists, reopen it. */

            /* Create the media frame. */
            wp_media_frame = wp.media({
                library: {
                    type: 'image'
                },
                title: image_uploader_open.data('upload'),
                button: {
                    text: image_uploader_open.data('button-text')
                },
                frame: 'post',
                state: state,
                multiple: true
            });

            /* select selected image */
            wp_media_frame.on('open', function(){
                var selected = input.val();
                if ( !selected )
                    return;

                var selection_array = selected.split(','),
                    selection   = wp_media_frame.state().get( 'library' );

                selection_array.forEach(function(selected) {
                    var attachment = wp.media.attachment(selected);
                    attachment.fetch();
                    selection.add( attachment ? [ attachment ] : [] );
                });
            });

            /* When an image is selected, run a callback. */
            wp_media_frame.on( 'update', function() {

                var image_html  = '',
                    ids = [],
                    attachments = wp_media_frame.state().get('library');

                attachments.each(function(attachment) {
                    attachment = attachment.toJSON();
                    var thumbnail  = ( typeof attachment.sizes.thumbnail !== 'undefined' ) ? attachment.sizes.thumbnail.url : attachment.url;
                    image_html += '<li><img src="'+ thumbnail +'"></li>';
                    ids.push(attachment.id);
                });


                input.val(ids);
                preview.html('').append(image_html);
                add.addClass('hidden');
                preview.removeClass('hidden');
                update.removeClass('hidden');
                remove.removeClass('hidden');
                input.trigger('change');
            });

            /* Finally, open the modal. */
            wp_media_frame.open();
        });

        /* Remove image */
        fieldpress_document.on('click','.fieldpress-remove',function (e) {
            e.preventDefault();
            var remove = $(this),
                image_wrapper = $(this).closest('.fieldpress-field.fieldpress-gallery'),
                preview = image_wrapper.find('.fieldpress-gallery-preview'),
                update = image_wrapper.find('.fieldpress-gallery-updater-open'),
                add = image_wrapper.find('.fieldpress-gallery-uploader-open'),
                input   = image_wrapper.find('input');

            input.val('');
            preview.html('');
            remove.addClass('hidden');
            update.addClass('hidden');
            add.removeClass('hidden');
        });
    };

    /* file loader */
    var FPFILEUPLOAD = function () {
        fieldpress_document.on('click', '.fieldpress-file-uploader-open', function (e){
            e.preventDefault();
            var media_uploader_open = $(this),
                file_wrapper = media_uploader_open.closest('.fieldpress-field.fieldpress-file'),
                preview = file_wrapper.find('.fieldpress-file-preview-holder'),
                icon_wrap     = file_wrapper.find('img'),
                title_wrap     = file_wrapper.find('.fieldpress-file-title'),
                name_wrap     = file_wrapper.find('.fieldpress-file-name'),
                size_wrap     = file_wrapper.find('.fieldpress-file-size'),
                type     = media_uploader_open.data('file-type'),
                button_text     = media_uploader_open.data('button-text'),
                title     = media_uploader_open.data('title'),
                input   = file_wrapper.find('input'),
                multiple   = input.data('multiple'),
                wp_media_frame;

            multiple = multiple !== '';

            /* Check if the `wp.media.gallery` API exists. */
            if ( typeof wp === 'undefined' || ! wp.media || ! wp.media.gallery ) {
                return;
            }
            /*If the media frame already exists, reopen it. */
            if ( wp_media_frame ) {
                wp_media_frame.open();
                return;
            }
            /* Create the media frame.*/
            wp_media_frame = wp.media({
                library: {
                    type: type
                },
                title: media_uploader_open.data('upload'),
                button: {
                    text: media_uploader_open.data('button-text')
                },
                multiple : multiple
            });

            /*select selected image*/
            wp_media_frame.on('open', function(){
                var selected = input.val();
                if ( !selected )
                    return;

                if (selected) {

                    var selection_array = selected.split(','),
                        selection   = wp_media_frame.state().get( 'selection' );

                    selection_array.forEach(function(selected) {
                        var attachment = wp.media.attachment(selected);
                        attachment.fetch();
                        selection.add( attachment ? [ attachment ] : [] );
                    });
                }
            });

            /* When an image is selected, run a callback. */
            wp_media_frame.on( 'select', function() {

                /* Indented with tab */
                var file_preview_html  = '';
                if( multiple ){
                    var ids = [],
                        attachments = wp_media_frame.state().get('selection');

                    attachments.each(function(attachment) {

                        attachment = attachment.toJSON();

                        var icon  = attachment.icon,
                            title  = attachment.title,
                            name  = attachment.filename,
                            url  = attachment.url,
                            val  = attachment.id,
                            filesizeHumanReadable  = attachment.filesizeHumanReadable;

                        file_preview_html += '<div class="fieldpress-file-preview" data-value="'+val+'">';
                        file_preview_html += '<div class="fieldpress-file-wrap">';
                        file_preview_html += '<i class="dashicons dashicons-no fieldpress-file-clear"></i>';
                        file_preview_html += '<div class="fieldpress-icon-wrapper">';
                        file_preview_html += '<a data-file-type="'+type+'" data-button-text="'+button_text+'" data-title="'+title+'" href="#" class="fieldpress-file-uploader-open">';
                        file_preview_html += '<img src="'+icon+'">';
                        file_preview_html += '</a>';
                        file_preview_html += '</div>';
                        file_preview_html += '<div class="fieldpress-file-details">';
                        file_preview_html += '<div class="fieldpress-file-title">'+title+'</div>';
                        file_preview_html += '<div class="fieldpress-file-name"><a class="fieldpress-file-link" href="'+url+'" target="_blank">'+name+'</a></div>';
                        file_preview_html += '<div class="fieldpress-file-size">'+filesizeHumanReadable+'</div>';
                        file_preview_html += '</div>';
                        file_preview_html += '</div>';
                        file_preview_html += '</div>';

                        ids.push(attachment.id);
                    });

                    preview.removeClass('hidden');
                    preview.html(file_preview_html);

                    input.val(ids);
                    input.trigger('change');
                }
                else{
                    var attachment  = wp_media_frame.state().get('selection').first().toJSON(),
                        icon        = attachment.icon,
                        title       = attachment.title,
                        name        = attachment.filename,
                        url         = attachment.url,
                        val         = attachment.id,
                        filesizeHumanReadable  = attachment.filesizeHumanReadable;
                    file_preview_html += '<div class="fieldpress-file-preview" data-value="'+val+'">';
                    file_preview_html += '<div class="fieldpress-file-wrap">';
                    file_preview_html += '<i class="dashicons dashicons-no fieldpress-file-clear"></i>';
                    file_preview_html += '<div class="fieldpress-icon-wrapper">';
                    file_preview_html += '<a data-file-type="'+type+'" data-button-text="'+button_text+'" data-title="'+title+'" href="#" class="fieldpress-file-uploader-open">';
                    file_preview_html += '<img src="'+icon+'">';
                    file_preview_html += '</a>';
                    file_preview_html += '</div>';
                    file_preview_html += '<div class="fieldpress-file-details">';
                    file_preview_html += '<div class="fieldpress-file-title">'+title+'</div>';
                    file_preview_html += '<div class="fieldpress-file-name"><a class="fieldpress-file-link" href="'+url+'" target="_blank">'+name+'</a></div>';
                    file_preview_html += '<div class="fieldpress-file-size">'+filesizeHumanReadable+'</div>';
                    file_preview_html += '</div>';
                    file_preview_html += '</div>';
                    file_preview_html += '</div>';

                    preview.removeClass('hidden');
                    preview.html(file_preview_html);

                    input.val( val );
                    input.trigger('change');
                }
            });

            /* Finally, open the modal. */
            wp_media_frame.open();
        });

        /* Remove image */
        fieldpress_document.on('click','.fieldpress-file-clear',function (e) {
            e.preventDefault();
            var remove = $(this),
                file_wrapper = remove.closest('.fieldpress-field.fieldpress-file'),
                preview = remove.closest('.fieldpress-file-preview'),
                val = preview.data('value'),
                input   = file_wrapper.find('input'),
                input_val = input.val(),
                input_array = input_val.split(','),
                ids = [];

            input_array.forEach(function(selected) {
                if( val != selected ){
                    ids.push(selected);
                }
            });

            input.val(ids);
            preview.remove();
        });
    };

    // ======================================================
    /*Icon Selector*/
    var FPICONSSELECTOR = function() {

        var icon_loaded = false;
        fieldpress_document.on('click', '.fieldpress-icon-selector-open', function( e ) {
            e.preventDefault();

            var icon_selector   = $(this),
                icon_wrapper = icon_selector.closest('.fieldpress-field.fieldpress-icon'),
                icon_preview = icon_wrapper.find('.fieldpress-icon-preview'),
                input   = icon_selector.next('input'),
                icon_modal = $('#fieldpress-icon-modal'),
                icon_loader = $('#fieldpress-select-icons-load');

            /* open modal */
            icon_modal.removeClass('hidden');

            /* load icons  */
            if( !icon_loaded ) {

                $.ajax({
                    type: 'POST',
                    url: fieldpress.ajaxurl,
                    data: {
                        action: 'fieldpress_select_icons'
                    },
                    success: function( content ) {

                        icon_loader.html( content );
                        icon_loaded = true;

                        icon_loader.on('click', '.single-icon', function( e ) {
                            e.preventDefault();
                            var single_icon = $(this),
                                icon_display_value = single_icon.children('i').attr('class'),
                                icon_split_value = icon_display_value.split(' '),
                                icon_value = icon_split_value[1];

                            icon_modal.addClass('hidden');

                            input.val( icon_value );
                            icon_preview.removeClass('hidden');
                            icon_preview.find('a').html('<i class="' + icon_display_value + '"></i>');
                        });

                        fieldpress_document.on('keyup', '#fieldpress-icon-search', function() {
                            var text = $(this),
                                value = text.val();

                            icon_loader.find('i').each(function () {
                                var icon = $(this);
                                if (icon.attr('class').search(value) > -1) {
                                    icon.parent('.single-icon').show();
                                }
                                else {
                                    icon.parent('.single-icon').hide();
                                }
                            });
                        });
                    }
                });

            }

        });

        fieldpress_document.on('click','.fieldpress-icon-modal-close',function (e) {
            var icon_modal = $('#fieldpress-icon-modal');
            icon_modal.addClass('hidden');
        });
        /* Remove icon */
        fieldpress_document.on('click','.fieldpress-icon-clear',function (e) {
            e.preventDefault();
            var remove = $(this),
                icon_wrapper = remove.closest('.fieldpress-field.fieldpress-icon'),
                preview = icon_wrapper.find('.fieldpress-icon-preview'),
                input   = icon_wrapper.find('input');

            input.val('');
            preview.addClass('hidden');
        });
    };
    // ======================================================
    /*google map*/
    if (typeof google !== 'undefined' && google && google.maps){
        var FPGOOGLEMAPLOADER = (function ( ) {
            fieldpress_document.on('click', '.fieldpress-show-map', function (e){
                e.preventDefault();
                var show_map = $(this),
                    map_wrapper = show_map.closest('.fieldpress-field.fieldpress-map'),

                    map_wrap = map_wrapper.find('.fieldpress-map-wrapper'),
                    map_holder = map_wrapper.find('.fieldpress-map-holder'),
                    lat = map_holder.data('lat'),
                    long = map_holder.data('long'),

                    set_address = map_wrapper.find('.fieldpress-address'),
                    search_input     = map_wrapper.find('.fieldpress-search-map'),
                    find_button     = map_wrapper.find('.fieldpress-find-map'),
                    set_lat_long     = map_wrapper.find('.fieldpress-map-lat-long'),
                    zoom     = parseInt( set_lat_long.attr('zoom') ),

                    marker;
                map_wrap.slideDown();

                var geocodePosition = function ( position ) {
                    var geocoder = new google.maps.Geocoder();
                    setTimeout(function () {
                        geocoder.geocode({
                            latLng: position
                        }, function (responses) {
                            if (responses && responses.length > 0) {
                                updateMarkerAddress(responses[0].formatted_address );
                            }
                        });
                    }, 2000);
                };
                var updateMarkerAddress = function ( address ) {
                    set_address.show().text( address );
                };
                var searchauto = function ( ) {
                    search_input.autocomplete({
                        /*This bit uses the geocoder to fetch address values */
                        source: function (request, response) {
                            geocoder.geocode({'address': request.term}, function (results, status) {
                                response($.map(results, function (item) {
                                    return {
                                        label: item.formatted_address,
                                        value: item.formatted_address
                                    };
                                }));
                            });
                        }
                    });
                };
                var find = function () {
                    find_button.click(function(e){
                        e.preventDefault();
                        var address = search_input.val();
                        geocoder.geocode({'address': address}, function (results, status) {
                            if (status === google.maps.GeocoderStatus.OK) {
                                map.setCenter(results[0].geometry.location);
                                marker.setPosition(results[0].geometry.location);
                                set_lat_long.val(marker.getPosition().lat() + ',' + marker.getPosition().lng());
                                geocodePosition(marker.getPosition(), set_address);
                                map.setZoom(14);
                            } else {
                                alert("Geocode was not successful for the following reason: " + status);
                            }
                        });
                        e.preventDefault();
                    });
                };

                /*load map*/
                var latlng = new google.maps.LatLng(lat, long);
                var options = {
                    zoom: zoom,
                    center: latlng,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                var map = new google.maps.Map(document.getElementById(map_holder.attr('id')), options);

                var geocoder = new google.maps.Geocoder();

                marker = new google.maps.Marker({
                    map: map,
                    draggable: true,
                    position: latlng
                });
                google.maps.event.addListener(marker, "dragend", function (event) {
                    var point = marker.getPosition();
                    map.panTo(point);
                    geocodePosition(point);
                });

                /*Add listener to marker for reverse geocoding */
                google.maps.event.addListener(marker, 'drag', function () {
                    geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {
                        if (status === google.maps.GeocoderStatus.OK) {
                            if (results[0]) {
                                set_lat_long.val(marker.getPosition().lat() + ',' + marker.getPosition().lng());
                                set_lat_long.trigger('change');
                            }
                        }
                    });
                });

                searchauto();
                find();
                show_map.hide();
            });
            fieldpress_document.on('click', '.fieldpress-map-clear', function (e){
                e.preventDefault();
                var hide_map = $(this),
                    map_wrapper = hide_map.closest('.fieldpress-field.fieldpress-map'),
                    map_wrap = map_wrapper.find('.fieldpress-map-wrapper'),
                    map_holder = map_wrapper.find('.fieldpress-map-holder'),
                    show_map = map_wrapper.find('.fieldpress-show-map');
                map_wrap.slideUp();
                map_holder.html('');
                show_map.show();
            });
        })
    }

    // ======================================================
    /*tabs*/
    var FPTABS = function(  ) {
        fieldpress_document.on('click', '.fields-tabs > li > a', function (event) {

            event.preventDefault();
            var this_tab = $(this),
                tab_href = this_tab.attr('href'),
                tab_id = tab_href.replace("#", ""),
                tab_wrap = this_tab.closest('.fieldpress-tabs');

            this_tab.parent('li').siblings('li').removeClass('active');
            this_tab.parent('li').addClass('active');

            tab_wrap.find('.fields-tabs-content').each(function (index, el) {
                var this_body = $(this),
                    this_id = this_body.attr('id');
                if ( this_id === tab_id ) {
                    this_body.removeClass('hidden');
                    FPWYSIWYG(this_body);
                }
                else {
                    this_body.addClass('hidden');
                }
            });
        });

        fieldpress_document.on('click', '.fieldpress-main-tabs > li > a', function (event) {

            event.preventDefault();
            var this_tab = $(this),
                tab_href = this_tab.attr('href'),
                tab_id = tab_href.replace("#", ""),
                tab_wrap = this_tab.closest('.fieldpress-wrap'),
                tab_current_section = tab_wrap.find('.fieldpress-current-section');

            this_tab.parent('li').siblings('li').removeClass('active');
            this_tab.parent('li').addClass('active');
            tab_current_section.val(tab_id);
            tab_wrap.find('.fieldpress-tabs-content-wrapper').each(function (index, el) {
                var this_body = $(this),
                    this_id = this_body.attr('id');
                if ( this_id === tab_id ) {
                    this_body.removeClass('hidden');
                    FPWYSIWYG(this_body);
                }
                else {
                    this_body.addClass('hidden');
                }
            });
        });
    };

    /*invalid value handler*/
    var FPVALIDATION = function( form ) {

        var first_invalid = $('input:invalid').first(),
            tabs_wrapper = first_invalid.closest('.fieldpress-tabs-content-wrapper'),
            tabs_wrapper_id = tabs_wrapper.attr('id'),
            fieldpress_main_tabs = $('.fieldpress-main-tabs');

        if( !tabs_wrapper.hasClass('hidden')){
            return true;
        }

        tabs_wrapper.siblings('.fieldpress-tabs-content-wrapper').addClass('hidden');
        tabs_wrapper.removeClass('hidden');
        fieldpress_main_tabs.find('li').each(function () {
            var this_li = $(this),
                this_li_hash_id = this_li.children('a').attr('href'),
                this_li_id = this_li_hash_id.replace("#", "");

            if( tabs_wrapper_id === this_li_id ){
                this_li.siblings('li').removeClass('active');
                this_li.addClass('active');
            }
        })

    };
    // ======================================================
    /*wysiwyg*/
    fieldpress_document.on('click', '.fieldpress-open-wysiwyg', function (e) {
        e.preventDefault();
        var open_wysiwyg = $(this),
            wysiwyg_wrapper = open_wysiwyg.closest('.fieldpress-field.fieldpress-wysiwyg');
        FPWYSIWYG( wysiwyg_wrapper );
    });
    var FPWYSIWYG =  function ( $this ) {
        var wysiwyg_wrapper = $this,
            open_wysiwyg = wysiwyg_wrapper.find('.fieldpress-open-wysiwyg'),
            textarea = wysiwyg_wrapper.find('.fieldpress-wysiwyg-textarea'),
            id = textarea.attr( 'id' ),
            mediaButtons = textarea.attr( 'mediaButtons' ),
            quicktags = textarea.attr( 'quicktags' ),
            plugins = textarea.attr( 'plugins' ),
            toolbar1 = textarea.attr( 'toolbar1' ),
            block_formats = textarea.attr( 'block_formats' );

        /*tabs fixed*/
        if( FIELD_PRES_IS_PROCESS(textarea)){
            return;
        }
        /**
         * Build (or re-build) the visual editor.
         * Main JS wp-admin/js/editor.js
         * @returns {void}
         */
        function buildEditor() {
            var editor, triggerChangeIfDirty, onInit,
                changeDebounceDelay = 1000,
                restoreTextMode = false,
                editorFocused = false;

            /* Abort building if the textarea is gone, likely due to the widget having been deleted entirely. */
            if ( ! document.getElementById( id ) ) {
                return;
            }

            /* Destroy any existing editor so that it can be re-initialized after a widget-updated event. */
            if ( tinymce.get( id ) ) {
                restoreTextMode = tinymce.get( id ).isHidden();
                wp.editor.remove( id );
                tinymce.EditorManager.execCommand('mceRemoveEditor',true, id);
            }

            wp.editor.initialize( id, {
                tinymce: {
                    wpautop : true,
                    plugins : plugins,
                    toolbar1 : toolbar1,
                    block_formats : block_formats,
                },
                mediaButtons : mediaButtons,
                quicktags : quicktags
            });

            editor = window.tinymce.get( id );
            if ( ! editor ) {
                throw new Error( 'Failed to initialize editor' );
            }
            onInit = function() {

                /* When a widget is moved in the DOM the dynamically-created TinyMCE iframe will be destroyed and has to be re-built. */
                $( editor.getWin() ).on( 'unload', function() {
                    _.defer( buildEditor );
                });

                /* If a prior mce instance was replaced, and it was in text mode, toggle to text mode. */
                if ( restoreTextMode ) {
                    switchEditors.go( id, 'toggle' );
                }
            };

            if ( editor.initialized ) {
                onInit();
            } else {
                editor.on( 'init', onInit );
            }

            triggerChangeIfDirty = function() {
                /* See wp.customize.Widgets.WidgetControl._setupUpdateUI() which uses 250ms for updateWidgetDebounced. */
                var updateWidgetBuffer = 300; 
                if ( editor.isDirty() ) {

                    /*
                     * Account for race condition in customizer where user clicks Save & Publish while
                     * focus was just previously given to to the editor. Since updates to the editor
                     * are debounced at 1 second and since widget input changes are only synced to
                     * settings after 250ms, the customizer needs to be put into the processing
                     * state during the time between the change event is triggered and updateWidget
                     * logic starts. Note that the debounced update-widget request should be able
                     * to be removed with the removal of the update-widget request entirely once
                     * widgets are able to mutate their own instance props directly in JS without
                     * having to make server round-trips to call the respective WP_Widget::update()
                     * callbacks. See <https://core.trac.wordpress.org/ticket/33507>.
                     */
                    if ( wp.customize ) {
                        wp.customize.state( 'processing' ).set( wp.customize.state( 'processing' ).get() + 1 );
                        _.delay( function() {
                            wp.customize.state( 'processing' ).set( wp.customize.state( 'processing' ).get() - 1 );
                        }, updateWidgetBuffer );
                    }

                    editor.save();
                    textarea.trigger( 'change' );
                }
            };
            editor.on( 'focus', function() {
                editorFocused = true;
            });
            editor.on( 'NodeChange', _.debounce( triggerChangeIfDirty, changeDebounceDelay ) );
            editor.on( 'blur', function() {
                editorFocused = false;
                triggerChangeIfDirty();
            });

            open_wysiwyg.hide();

        }
        buildEditor()

    };
    /*sortable*/
    var FPSORTABLE = function () {
        var sortables = $('.fieldpress-sortable');
        sortables.each(function () {

            var sortable  = $(this),
                active  = sortable.find('.active-sortable'),
                inactive = sortable.find('.inactive-sortable');

            active.sortable({
                connectWith: inactive,
                placeholder: 'ui-sortable-placeholder',
                update: function( event, ui ){
                    var item = ui.item,
                        input = item.find('input');

                    if( item.parent().hasClass('active-sortable') ) {
                        input.attr('name', input.attr('name').replace('inactive', 'active'));
                    }
                    else {
                        input.attr('name', input.attr('name').replace('active', 'inactive'));
                    }

                }
            });

            /* avoid conflict var updateWidgetBuffer = 300; */
            inactive.sortable({
                connectWith: active,
                placeholder: 'ui-sortable-placeholder'
            });

        });
    };
    /**repeater**/
    /*nested sortable helper functions*/
    var FPPXTODEPTH = function ( px, pos_position ) {
        return Math.floor(px / pos_position);
    };
    var FPREPEATERDEPTH = function ( item ) {
        return item.attr('data-depth');
    };

    var FPREPEATERCHILDREN = function ( parent, depth ) {
        var result = $();
        parent.nextAll( ".repeater-table" ).each(function(){
            var next = $(this);
            if( FPREPEATERDEPTH(next) > depth ){
                result = result.add( next );
            }
            else{
                return false;
            }
        });
        return result;
    };
    
    /*trigger change*/
    var FPREFRESHVALUE = function (wrapObject) {
        wrapObject.find('[name]').each(function(){
            $(this).trigger('change');
        });
    };
    var FPREPEATERSORTABLE = function () {
        var repeaters = $('.fieldpress-repeater'),

            fpsorttrigger,
            transport,
            original_depth,
            current_depth, 
            depth,
            pos_position = 32,
            max_depth,
            min_allowed_depth,
            max_allowed_depth;

        repeaters.sortable({
            placeholder: 'fp-sortable-placeholder',
            items: '> .repeater-table',
            handle: '> .fieldpress-repeater-top > .fieldpress-repeater-title',
            cursor: 'move',
            distance: 2,
            containment: '#wpwrap',
            tolerance: 'pointer',
            refreshPositions: true,

            start: function(event, ui) {
                fpsorttrigger = ui.item.closest('.fieldpress-repeater');
                if( fpsorttrigger.data( 'nested') !== 1 ){
                    return;
                }
                max_depth = fpsorttrigger.attr('data-max-depth')?fpsorttrigger.data('max-depth'):10;
                if( max_depth > 10 ){
                    max_depth = 10;
                }
                transport = ui.item.children('.fs-repeater-transport');

                /* Set depths. current_depth must be set before children are located. */
                original_depth = FPREPEATERDEPTH(ui.item);

                /* Attach child elements to parent 
                *  Skip the placeholder
                */

                var parent = ( ui.item.next()[0] == ui.placeholder[0] ) ? ui.item.next() : ui.item,
                    children = FPREPEATERCHILDREN(parent,original_depth);

                transport.append( children );

                /*Update the height of the placeholder to match the moving item.*/
                var height = transport.outerHeight();
                /* If there are children, account for distance between top of children and parent */
                height += ( height > 0 ) ? (ui.placeholder.css('margin-top').slice(0, -2) * 1) : 0;
                height += ui.helper.outerHeight();

                var helperHeight = height;
                height -= 2; /*Subtract 2 for borders */
                ui.placeholder.height(height);


                /* Update the list of menu items.*/
                ui.placeholder.detach(); /* detach or jQuery UI will think the placeholder is a menu item */
                $(this).sortable( 'refresh' ); /* The children aren't sortable. We should let jQ UI know.*/
                ui.item.after( ui.placeholder ); /* reattach the placeholder.*/
            },

            sort: function(event, ui) {

                if( fpsorttrigger.data( 'nested') !== 1 ){
                    return;
                }
                /*LOGIC
                * If not prev -> it is in first level -> depth 0
                * else
                *   if not next -> it is is last level -> allow all level of previous and 0
                *   else
                *      if next greater than parent it is sub so allow sub only
                *      else
                *       its previous doesnot have child allow same level of previous or it child and its level
                * */
                var offset = ui.helper.offset(),
                    edge = offset.left,
                    repeater_edge = fpsorttrigger.offset().left,
                    depth = FPPXTODEPTH( edge - repeater_edge , pos_position);

                /*place holder previous repeater table*/
                var prev = ui.placeholder.prev('.repeater-table');
                if( prev.hasClass('ui-sortable-helper')){
                    prev = prev.prev('.repeater-table');
                }

                /*place holder next repeater table*/
                var next = ui.placeholder.next('.repeater-table');
                if( next.hasClass('ui-sortable-helper')){
                    next = next.next('.repeater-table');
                }
                /*if we have previous repeater-table on placeholder*/
                if( !prev.length ){
                    depth = 0;
                    ui.item.css('margin-left',0);
                    ui.placeholder.css('margin-left',0);
                    current_depth = 0

                    ui.item.attr('data-depth',current_depth);
                }
                else{
                    var allowed_depth = [];
                    current_depth = depth;

                    var parentDepth = parseInt( FPREPEATERDEPTH( prev ) );
                    if( !next.length ){

                        prev.prevAll( ".repeater-table" ).each(function(){
                            var prev = $(this),
                                prevDepth = parseInt ( FPREPEATERDEPTH(prev));

                            if( prevDepth === 0){
                                return false;
                            }
                            allowed_depth.push(prevDepth);
                        });
                        allowed_depth.push(0);
                        allowed_depth.push(parentDepth);
                        allowed_depth.push(parentDepth+1);

                    }
                    else{
                        var nextDepth = parseInt ( FPREPEATERDEPTH(next));
                        if( nextDepth > parentDepth ){
                            allowed_depth.push(parentDepth+1);
                        }
                        else{
                            allowed_depth.push(parentDepth);
                            allowed_depth.push(parentDepth+1);
                            allowed_depth.push(nextDepth);
                        }
                    }

                    min_allowed_depth= Math.min.apply(Math,allowed_depth);
                    max_allowed_depth = Math.max.apply(Math,allowed_depth);

                    if( max_allowed_depth > max_depth ){
                        max_allowed_depth = max_depth;
                    }

                    if( current_depth < min_allowed_depth ){
                        current_depth =  min_allowed_depth;
                    }
                    else if( current_depth > max_allowed_depth ){
                        current_depth =  max_allowed_depth;
                    }

                    var margin_left = current_depth * pos_position;
                    ui.item.attr('data-depth',current_depth);
                    ui.placeholder.css('margin-left',margin_left);
                }
                
            },

            update: function( event, ui ) {
                FPREFRESHVALUE(ui.item);
            },

            stop: function(event, ui) {
                if( fpsorttrigger.data( 'nested') !== 1 ){
                    return;
                }
                
                var children,
                    depth_change = current_depth - original_depth;

                /*Return child elements to the list */
                children = transport.children().insertAfter(ui.item);

                /* Update depth */
                if ( 0 !== depth_change ) {
                    var margin_left = current_depth * pos_position;
                    ui.item.css('margin-left',margin_left);
                    children.each(function () {
                        var child = $(this),
                            child_depth = parseInt( child.attr('data-depth') ),
                            new_depth = child_depth + depth_change;

                        if( new_depth < 0 ){
                            new_depth =  0;
                        }
                        else if( new_depth > max_depth ){
                            new_depth =  max_depth;
                        }

                        var margin_left = new_depth * pos_position;
                        child.css('margin-left',margin_left);
                        child.attr('data-depth',new_depth);
                    });
                }

                /*repeater order*/
                fpsorttrigger.find('.repeater-table').each( function(index, el) {

                    var this_repeater = $(this),
                        fp_parent = this_repeater.find('.fp-parent'),
                        fp_depth = this_repeater.find('.fp-depth'),
                        fp_index = this_repeater.find('.fp-index'),
                        this_depth = parseInt ( FPREPEATERDEPTH(this_repeater));

                    fp_depth.attr('data-index',index);


                    var parent_index = -1;
                    this_repeater.prevAll( ".repeater-table" ).each(function(){
                        var prev = $(this),
                            prevDepth = parseInt ( FPREPEATERDEPTH(prev));

                        if( prevDepth <  this_depth ){
                            parent_index = prev.attr('data-index');
                            return false;
                        }
                    });

                    fp_parent.attr('value', parent_index );
                    fp_depth.attr('value', this_depth );
                    fp_index.attr('value', index );

                });

                /*repeater order*/
                fpsorttrigger.find('.repeater-table').each( function(index, el) {

                    var this_repeater = $(this),
                        fp_parent = this_repeater.find('.fp-parent'),
                        fp_depth = this_repeater.find('.fp-depth'),
                        fp_index = this_repeater.find('.fp-index'),
                        this_depth = parseInt ( FPREPEATERDEPTH(this_repeater));

                    this_repeater.attr('data-index',index);

                    var parent_index = -1;
                    this_repeater.prevAll( ".repeater-table" ).each(function(){
                        var prev = $(this),
                            prevDepth = parseInt ( FPREPEATERDEPTH(prev));

                        if( prevDepth <  this_depth ){
                            parent_index = prev.attr('data-index');
                            return false;
                        }
                    });

                    fp_parent.attr('value', parent_index );
                    fp_depth.attr('value', this_depth );
                    fp_index.attr('value', index );

                });

            }
        });
    };
    /*replace*/
    var FPREPLACE = function( str, replaceWhat, replaceTo ){
        var re = new RegExp(replaceWhat, 'g');
        return str.replace(re,replaceTo);
    };
    var FPREPEATER =  function (){
        fieldpress_document.on('click','.fieldpress-add-repeater',function (e) {
            e.preventDefault();
            var add_repeater = $(this),
                repeater_wrap = add_repeater.closest('.fieldpress-repeater'),
                code_for_repeater = repeater_wrap.children('.fieldpress-code-for-repeater'),
                total_repeater = repeater_wrap.children('.fieldpress-total-repeater'),
                total_repeater_value = parseInt ( total_repeater.val()),
                repeater_html = code_for_repeater.html();

            total_repeater.val( total_repeater_value +1 );
            var final_repeater_html = FPREPLACE( repeater_html, add_repeater.attr('id'),total_repeater_value );
            final_repeater_html = FPREPLACE( final_repeater_html, 'fieldpress-tab-id','tab-'+total_repeater_value );
            final_repeater_html = FPREPLACE( final_repeater_html, 'fieldpress-filed-name','name' );
            add_repeater.before($('<div class="repeater-table open" data-depth="0"></div>').append( final_repeater_html ));
            var new_html_object = add_repeater.prev('.repeater-table');
            FIELDPRESS_RELOAD_METHODS( new_html_object );
        });
        fieldpress_document.on('click', '.fieldpress-repeater-top, .fieldpress-repeater-close', function (e) {
            e.preventDefault();
            var accordion_toggle = $(this),
                repeater_field = accordion_toggle.closest('.repeater-table'),
                repeater_inside = repeater_field.find('.fieldpress-repeater-inside:first');

            if ( repeater_inside.is( ':hidden' ) ) {
                repeater_inside.slideDown( 'fast',function () {
                    repeater_field.addClass( 'open' );
                    FPWYSIWYG(repeater_field);
                } );
            }
            else {
                repeater_inside.slideUp( 'fast', function() {
                    repeater_field.removeClass( 'open' );
                });
            }
        });
        fieldpress_document.on('click', '.fieldpress-repeater-remove', function (e) {
            e.preventDefault();
            var repeater_remove = $(this),
                repeater_field = repeater_remove.closest('.repeater-table');

            repeater_field.remove();
        });
    };


    /*load methods*/
    var FIELDPRESS_MAIN_LOAD_METHODS = function() {
        /*for image upload*/
        FPIMAGEUPLOAD();

        /*for gallery*/
        FPGALLERYUPLOAD();

        /*for file*/
        FPFILEUPLOAD();

        /*for icon*/
        FPICONSSELECTOR();

        /*for tabs*/
        FPTABS();

        /*for google map*/
        if (typeof google !== 'undefined' && google && google.maps){
            FPGOOGLEMAPLOADER();
        }

        /*for repeater*/
        FPREPEATER();

        /*no need to call below functions on widget page*/
        if ( 'widgets' === window.pagenow ) {
            return;
        }

        FIELDPRESS_RELOAD_METHODS( fieldpress_body );
    };
    /*CHECK IF ANCESTOR IS PLACEHOLDER OF REPEATER*/
    var FIELD_PRES_IS_PROCESS = function ( child ) {
        return (child.closest('.fieldpress-code-for-repeater').length > 0 )
    };
    /*RELOAD METHODS*/
    var FIELDPRESS_RELOAD_METHODS = function( wrapper ) {
        /*colorpicker*/
        wrapper.find('.fieldpress-color-picker').each(function(){
            if( !FIELD_PRES_IS_PROCESS($(this))){
                FPCOLORPICKER($(this));
            }
        });
        /*date picker*/
        wrapper.find('.fieldpress-date-picker').each(function(){
            if( !FIELD_PRES_IS_PROCESS($(this))){
                FPDATEPICKER($(this));
            }
        });
        /*select2*/
        wrapper.find('.fieldpress-select2').each(function(){
            if( !FIELD_PRES_IS_PROCESS($(this))){
                FPSELECT2($(this));
            }
        });
        /*wysiwyg*/
        wrapper.find('.fieldpress-wysiwyg').each(function(){
            if( !FIELD_PRES_IS_PROCESS($(this))){
                FPWYSIWYG($(this));
            }
        });
        if ($('.fieldpress-repeater').length > 0) {
            FPREPEATERSORTABLE();
        }
        if ($('.fieldpress-sortable').length > 0) {
            FPSORTABLE();
        }
    };

    var WIDGET_RELOAD_METHODS = function() {
        fieldpress_document.on('widget-added widget-updated', function( event, widgetContainer ) {
            FIELDPRESS_RELOAD_METHODS( widgetContainer );
        });

        /*
         * Manually trigger widget-added events for media widgets on the admin
         * screen once they are expanded. The widget-added event is not triggered
         * for each pre-existing widget on the widgets admin screen like it is
         * on the customizer. Likewise, the customizer only triggers widget-added
         * when the widget is expanded to just-in-time construct the widget form
         * when it is actually going to be displayed. So the following implements
         * the same for the widgets admin screen, to invoke the widget-added
         * handler when a pre-existing media widget is expanded.
         */
        $( function initializeExistingWidgetContainers() {
            var widgetContainers;
            if ( 'widgets' !== window.pagenow ) {
                return;
            }
            widgetContainers = $( '.widgets-holder-wrap:not(#available-widgets)' ).find( 'div.widget' );
            widgetContainers.one( 'click.toggle-widget-expanded', function toggleWidgetExpanded() {
                var widgetContainer = $( this );
                FIELDPRESS_RELOAD_METHODS( widgetContainer );
            });
        });
    };

    /*Dependencies Fields*/
    var fieldpress_addons = $('.fieldpress-addons');
    // Handle individual checkboxes & radio
    function controller_value(controller) {
        if ( controller.attr("type") === "checkbox" || controller.attr("type") === "radio" ) {
            return controller.is(":checked");
        }
        return controller.val();
    }
    function check_condition(id, value){
        fieldpress_addons.find('.fieldpress-dependent.'+id).each(function () {
            var dependent = $(this),
                condition = dependent.data('condition'),
                conditional_value = dependent.data('conditional-value'),
                result;

            if( condition == "==" ) {
                result = value == conditional_value;
            }
            else if( condition == "!=" ) {
                result = value != conditional_value;
            }
            else if( condition == ">=" ) {
                result = Number( value ) >= Number( conditional_value );
            }
            else if( condition == "<=" ) {
                result = Number( value ) <= Number( conditional_value );
            }
            else if( condition == ">" ) {
                result = Number( value ) > Number( conditional_value );
            }
            else if( condition == "<" ) {
                result = Number( value ) < Number ( conditional_value );
            }
            else if( condition == "empty" ) {
                result = value.length === 0;
            }
            else if( condition == "!empty" ) {
                result = value.length !== 0;
            }
            else {
                result = false;
                throw new Error("Undefined condition: " + condition);
            }
            if( result ){
                dependent.removeClass('fieldpress-hidden');
            }
            else{
                dependent.addClass('fieldpress-hidden');
            }
        });
    }
    fieldpress_addons.find('.fieldpress-controller').each(function () {

        var controller = $(this),
            value = controller_value( controller ),
            id = controller.attr('id');

        check_condition(id, value )
    });
    /*Dependencies Fields End*/

    /*call all methods on window load*/
    fieldpress_window.on("load", function() {
        FIELDPRESS_MAIN_LOAD_METHODS();
        WIDGET_RELOAD_METHODS();

        /*menu framework*/
        fieldpress_document.on('click','.fieldpress-actions .action',function (e) {
            var form = $(this).closest('form');
            FPVALIDATION(form);
        });
        /*meta framework*/
        fieldpress_document.on('click','#submitpost :submit',function (e) {
            var form = $(this).closest('form');
            FPVALIDATION(form);
        });
        /*widget framework*/
        fieldpress_document.on('click','.widget-control-actions .widget-control-save',function (e) {
            var form = $(this).closest('form');
            FPVALIDATION(form);
        });

        /*conditional field*/
        fieldpress_document.on('keyup change','.fieldpress-controller',function (e) {
            var controller = $(this),
                value = controller_value( controller ),
                id = controller.attr('id');

            check_condition(id, value )
        });

        /*Reset Notification*/
        fieldpress_document.on('click','#fieldpress-reset',function (e) {
            var is_confirm = confirm( fieldpress.reset_confirm );
            if ( is_confirm == true ) {
                return true;
            } else {
                e.preventDefault();
                return false;
            }
        });

    });

})( jQuery, window, document );