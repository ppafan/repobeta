define([
    'jquery',
    'mage/utils/wrapper',
    'Magento_Checkout/js/model/quote'
], function ($, wrapper, quote) {
    'use strict';
    return function (setShippingInformationAction) {
        return wrapper.wrap(setShippingInformationAction, function (originalAction) {
            var shippingAddress = quote.shippingAddress();
            var billingAddress = quote.billingAddress();

            $.each([shippingAddress, billingAddress], function(index, quoteAddress) {
                if(quoteAddress != null){
                    if (quoteAddress['extension_attributes'] === undefined) {
                        quoteAddress['extension_attributes'] = {};
                    }

                    if (quoteAddress.customAttributes === undefined) {
                        quoteAddress.customAttributes = {};
                    }
                    
                    if(quoteAddress.cityId != undefined || quoteAddress.cityId === null){
                        quoteAddress['extension_attributes']['city_id'] = quoteAddress.cityId;
                        delete quoteAddress.cityId;
                    } else if(quoteAddress.customAttributes['city_id'] != undefined){
                        quoteAddress['extension_attributes']['city_id'] = quoteAddress.customAttributes['city_id']['value'];
                    }

                    if(quoteAddress.subdistrict != undefined || quoteAddress.subdistrict === null){
                        quoteAddress['extension_attributes']['subdistrict'] = quoteAddress.subdistrict;
                        delete quoteAddress.subdistrict;
                    } else if(quoteAddress.customAttributes['subdistrict'] != undefined){
                        quoteAddress['extension_attributes']['subdistrict'] = quoteAddress.customAttributes['subdistrict']['value'];
                    }

                    if(quoteAddress.subdistrictId != undefined || quoteAddress.subdistrictId === null){
                        quoteAddress['extension_attributes']['subdistrict_id'] = quoteAddress.subdistrictId;
                        delete quoteAddress.subdistrictId;
                    } else if(quoteAddress.customAttributes['subdistrict_id'] != undefined){
                        quoteAddress['extension_attributes']['subdistrict_id'] = quoteAddress.customAttributes['subdistrict_id']['value'];
                    }

                    if(quoteAddress.customerAddressId == undefined){
                        quoteAddress.customerAddressId = jQuery('.shipping-address-items .shipping-address-item.selected-item').attr('data-address');
                    }

                    if(quoteAddress.customerId == undefined){
                        quoteAddress.customerId = window.checkoutConfig.customerData.id;
                    }

                }
            });
            return originalAction();
        });
    };
});