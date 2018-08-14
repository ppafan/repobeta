var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/action/set-shipping-information': {
                'Acommerce_Address/js/checkout/set-shipping-information': true
            },
            'Magento_Checkout/js/action/set-billing-address': {
                'Acommerce_Address/js/checkout/set-billing-address': true
            }
        }
    }
};