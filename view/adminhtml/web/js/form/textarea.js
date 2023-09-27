define([
    'jquery',
    'Magento_Ui/js/form/element/textarea',
    'ExpandingWeb_OpenAi/js/api/get-info-from-ai'
], function ($, textarea, Openai) {
    'use strict';
    return textarea.extend({
        currentForm: null,

        valueFieldName: null,

        formType: null,
        
        renderDescription: function (keywordsExtra = null) {
            var self = this;
            self.checkForm();
            Openai(self.valueFieldName, self.index, self.formType, keywordsExtra).done(function(json) {
                if (json.answer && json.success) {
                    self.value(json.answer);
                }
            });
        },

        checkForm: function () {
            if (!this.currentForm) {
                this.currentForm = this.ns;
            }
            if (this.currentForm == 'product_form') {
                this.valueFieldName = $('input[name="product[name]"]').val();
                this.formType = 'product';
            }
            if (this.currentForm == 'category_form') {
                this.valueFieldName = $('input[name="name"]').val();
                this.formType = 'category';
            }
        }
    });
});
