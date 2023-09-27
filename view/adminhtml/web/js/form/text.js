define([
    'jquery',
    'Magento_Ui/js/form/element/abstract',
    'ExpandingWeb_OpenAi/js/api/get-info-from-ai'
], function ($, abstract, Openai) {
    'use strict';
    return abstract.extend({
        currentForm: null,

        currentValue: {},

        valueFieldName: null,

        formType: null,

        fieldSelector: null,
        
        renderDescription: function () {
            var self = this;
            self.checkForm();
            if (self.valueFieldName) {
                if (!self.currentValue[self.value()]) {
                    self.currentValue[self.value()] = self.fieldSelector.val();
                }
                Openai(self.valueFieldName, self.index, self.formType).done(function(json) {
                    if (json.answer && json.success) {
                        self.fieldSelector.val(json.answer).change();
                    }
                });
            }
        },

        checkForm: function () {
            if (!this.currentForm) {
                this.currentForm = this.ns;
            }
            if (this.currentForm == 'product_form') {
                if (!this.valueFieldName) {
                    this.valueFieldName = $('input[name="product[name]"]').val();
                }
                if (!this.formType) {
                    this.formType = 'product';
                }
                this.fieldSelector = $('[name="product['+this.value()+']"]');
            }
            if (this.currentForm == 'category_form') {
                if (!this.valueFieldName) {
                    this.valueFieldName = $('input[name="name"]').val();
                }
                if (!this.formType) {
                    this.formType = 'category';
                }
                this.fieldSelector = $('[name="'+this.value()+'"]');
            }
            if (this.currentForm == 'cms_page_form') {
                if (!this.valueFieldName) {
                    this.valueFieldName = $('input[name="title"]').val();
                }
                if (!this.formType) {
                    this.formType = 'page';
                }
                this.fieldSelector = $('[name="'+this.value()+'"]');
            }
        },

        resetValue: function () {
            if (this.currentValue[this.value()]) {
                this.fieldSelector.val(this.currentValue[this.value()]).change();
            } else {
                this.fieldSelector.val('').change();
            }
        }
    });
});
