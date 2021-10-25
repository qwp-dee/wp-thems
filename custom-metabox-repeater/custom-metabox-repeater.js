var repeatable_field = {
    init: function(){
        this.addRow();
        this.removeRow();
        this.addImageUploader();
        this.removeImage();
        this.dragnDrop();
    },
     dragnDrop: function(){

        jQuery("#sortable").sortable();
       
        jQuery("#sortable").disableSelection();
    },
    addRow: function(){
        jQuery(document).on('click', '#add-row', function (e) {
            e.preventDefault();
            var row = jQuery('.empty-row.screen-reader-text').clone(true);
            row.removeClass('empty-row screen-reader-text');
            row.insertBefore('#repeatable-fieldset-one tbody>tr:last');
            // return false;
        });
    },
    removeRow: function(){
        jQuery(document).on('click', '.remove-row', function () {
            jQuery(this).parents('tr').remove();
            return false;
        });
    },
    addImageUploader: function(){
        jQuery(document).on('click', '.upload_image_button', function (event) {
            event.preventDefault();

            var inputField = jQuery(this).prev('.nts-logo');

            // Create the media frame.
            var pevent = event,
                button = jQuery(this),
                file_frame = wp.media({
                    title: wp_media.title,
                    library: {
                        type: 'image',
                    },
                    button: {
                        text: wp_media.btn_txt
                    },
                    multiple: false
                }).on('select', function () {
                    var attachment = file_frame.state().get('selection').first().toJSON();
                    var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;

                    button.closest('.repeater-logo-wrapper').find('.wp-logo').val(attachment.id);
                    button.closest('.repeater-logo-wrapper').find('.wp-logo').before('<div><img src="' + attachment_thumbnail.url + '" width="150px" height="150px" /></div>');
                    button.closest('.repeater-logo-wrapper').find('.remove_image_button').show();
                    button.hide();

                }).open();
        });
    }, 

    removeImage: function(){
        jQuery(document).on('click', '.remove_image_button', function (event) {
            event.preventDefault();
            jQuery(this).closest('.repeater-logo-wrapper').find('.wp-logo').val('');
            jQuery(this).closest('.repeater-logo-wrapper').find('.upload_image_button').show();
            jQuery(this).hide();
            jQuery(this).closest('.repeater-logo-wrapper').find('div').remove();

        });
    }

};

jQuery(document).ready(function ($) {
   repeatable_field.init();
});