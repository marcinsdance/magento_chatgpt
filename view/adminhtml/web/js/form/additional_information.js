define([
    'jquery',
    'uiRegistry',
    'Magento_Ui/js/form/element/abstract'
], function ($, registry, abstract) {
    'use strict';
    return abstract.extend({
        fieldTarget: null,

        renderWithKeywordsExtra: function (fieldTarget) {
            if (!this.fieldTarget) {
                this.fieldTarget = fieldTarget;
            }
            var targetName = this.parentName+'.'+this.fieldTarget,
                actionName = 'renderDescription',
                target;
            if (!registry.has(targetName)) {
                this.getFromTemplate(targetName);
            }
            target = registry.async(targetName);
            if (target && typeof target === 'function' && actionName) {
                target.apply(target, [actionName, this.value()]);
            }
        }
    });
});
