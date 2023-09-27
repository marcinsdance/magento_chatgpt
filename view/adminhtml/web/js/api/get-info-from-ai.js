define([
    'jquery',
    'mage/url',
    'Magento_Ui/js/modal/alert',
    'mage/translate'
], function ($, url, alert) {
    'use strict';

    return function (name, field, type, keywordsExtra = null) {
        $('body').trigger('processStart');
        var updateUrl = url.build('/admin/expandingweb_openai/api/getresponse');
        var data = {
            name: name,
            field_index: field,
            type: type,
            keywords_extra: keywordsExtra
        };
        
        return $.post(updateUrl, data).always(function(json) {
            if (!json.answer) {
                var message = 'There was an error in the process please try again or check your API Key';
                message += ' in Stores -> Configuration -> Expanding Web -> API key. Thank you.';
                alert({
                    title: $.mage.__('Have Error'),
                    content: $.mage.__(message)
                });
            } else {
                if (!json.success) {
                    alert({
                        title: $.mage.__('Have Error'),
                        content: json.answer
                    });
                }
            }
            $('body').trigger('processStop');
        });
    };
});
