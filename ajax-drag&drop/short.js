/* Drag & drop widgets*/
$(document).ready(function($) {
            $('#loading-animation').hide();
            var itemList = $('div.bp-widget');
            itemList.sortable({
                update: function(event, ui) {
                    $('#loading-animation').show();
                    var itemList = $('div.bp-widget');
                    var $order = [];
                    jQuery('.pn-experience', itemList).each(function(i, self) {
                        $order[i] = jQuery(this).data('id');
                    })
                    $.ajax({
                        url: wasabih.ajaxurl,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            action: 'item_sort',
                            order: JSON.stringify($order)
                        },
                        success: function(response) {
                            $('#loading-animation').hide();
                            return;
                        },
                        error: function(xhr, textStatus, e) {
                            $('#loading-animation').hide();
                            return;
                        }
                    });

                }
            });