/**
 * Created by dathq on 28/11/2017.
 */
define([
    'underscore',
    'uiRegistry',
    'Magento_Ui/js/form/element/select'
], function (_, registry, Select) {
    'use strict';

    return Select.extend({

        /**
         * Filters 'initialOptions' property by 'field' and 'value' passed,
         * calls 'setOptions' passing the result to it
         *
         * @param {*} value
         * @param {String} field
         */

        filter: function (value, field) {
            var subdistrict = registry.get(this.parentName + '.' + 'subdistrict_id');
            if(typeof subdistrict !== 'undefined'){
                var option = subdistrict.indexedOptions[value];
                if(typeof option !== 'undefined'){
                    value = option.postcode;
                }
                if (subdistrict) {
                    this._super(value, field);
                }
            }

        }
    });


});
