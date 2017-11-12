(function($) {
    
    'use strict';

    var Insta_Post = {

        insta_fields: $('[data-name="instagram_post_url"] input'),

        create_preview: function(){

            var _this = this

            this.insta_fields.each(function(){

                $(this).after('<div class="insta-post"><div class="insta-image"></div><div class="insta-title"></div></div>')
                
                _this.get_insta_post($(this))
            })
        },

        events: function(){

            var _this = this

            $(document).on('focus', '[data-name="instagram_post_url"] input', function(e){
                if (!$(this).next().is('.insta-post')) {
                    $(this).after('<div class="insta-post"><div class="insta-image"></div><div class="insta-title"></div></div>')
                }
            })

            $(document).on('keyup', '[data-name="instagram_post_url"] input', function(e){
                _this.get_insta_post($(e.currentTarget))
            })

        },

        get_insta_post: function(el){

            var insta_field = el
            var insta_field_value = insta_field.val()
            var insta_field_value_storage = insta_field.parents('[data-name="instagram_post_url"]').prev().find('textarea')

            if (insta_field_value != '') {

                var ajax_url = ajax_params.ajax_url;
                var data = {
                    'action': 'get_insta_post',
                    'instapost': insta_field_value
                };

                $.post(ajax_url, data, function(response){

                    insta_field_value_storage.val(response)

                    var post_data = JSON.parse(response)

                    var img = $('<img />', { 
                      src: post_data['thumbnail_url']
                    });
                    
                    insta_field.next().find('.insta-image').html(img)
                    insta_field.next().find('.insta-title').html(post_data.title)
                })
                
            } else {

                insta_field.next().find('.insta-image').html('')
                insta_field.next().find('.insta-title').html('')
                insta_field_value_storage.val('')
            }
        },

        run: function(){
            this.create_preview()
            this.events()
        }
    }

    Insta_Post.run()
    
})(jQuery); 