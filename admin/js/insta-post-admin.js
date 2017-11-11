(function($) {
    
    'use strict';

    var instagram = {}

    console.log('INSTAGRAM')

    var fields = $('[data-name="instagram_post_url"] input')

    fields.each(function(){

        var field = $(this)
        var field_value = field.val()
        var field_value_storage = field.parents('[data-name="instagram_post_url"]').prev().find('textarea')

        field.after('<div class="insta-post"><div class="insta-image"></div><div class="insta-title"></div></div>')

        console.log(field, field_value)

        if (field_value != '') {

            var ajax_url = ajax_params.ajax_url;
            var data = {
                'action': 'get_insta_post',
                'instapost': field_value
            };

            $.post(ajax_url, data, function(response){

            	field_value_storage.val(response)

                var post_data = JSON.parse(response)

                var img = $('<img />', { 
                  src: post_data['thumbnail_url']
                });
                
                field.next().find('.insta-image').html(img)
                field.next().find('.insta-title').html(post_data.title)
            })
        } else {
            field.next().find('.insta-image').html('')
            field.next().find('.insta-title').html('')
            field_value_storage.val('')
        }
    })

    $(document).on('focus', '[data-name="instagram_post_url"] input', function(e){
        if (!$(this).next().is('.insta-post')) {
            $(this).after('<div class="insta-post"><div class="insta-image"></div><div class="insta-title"></div></div>')
        }
    })

    $(document).on('keyup', '[data-name="instagram_post_url"] input', function(e){

        var field = $(e.currentTarget)
        var field_value = field.val()
        
        var field_value_storage = field.parents('[data-name="instagram_post_url"]').prev().find('textarea')

        if (field_value != ''){

            var ajax_url = ajax_params.ajax_url;
            var data = {
                'action': 'get_insta_post',
                'instapost': field_value
            };

            console.log(field_value)
            $.post(ajax_url, data, function(response){

                console.log(response)
                

                field_value_storage.val(response)

                var post_data = JSON.parse(response)

                var img = $('<img />', { 
                  src: post_data['thumbnail_url']
                });

                field.next().find('.insta-image').html(img)
                field.next().find('.insta-title').html(post_data.title)

            })
        } else {
            field.next().find('.insta-image').html('')
            field.next().find('.insta-title').html('')
            field_value_storage.val('')
        }
    })
    
})(jQuery); 