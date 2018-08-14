


define([
    "jquery",
    "prototype",
    "mage/adminhtml/events"
], function(jQuery){

    aregionUpdater = Class.create();

    aregionUpdater.prototype = {
        initialize: function (countryEl, regionTextEl, regionSelectEl, regions, disableAction, clearRegionValueOnDisable)
        {
            this.isRegionRequired = true;
            this.countryEl = $(countryEl);
            this.regionTextEl = $(regionTextEl);
            this.regionSelectEl = $(regionSelectEl);
            this.config = regions['config'];
            delete regions.config;
            this.regions = regions;
            this.disableAction = (typeof disableAction=='undefined') ? 'hide' : disableAction;
            this.clearRegionValueOnDisable = (typeof clearRegionValueOnDisable == 'undefined') ? false : clearRegionValueOnDisable;

            if (this.regionSelectEl.options.length<=1) {
                this.update();
            }
            else {
                this.lastCountryId = this.countryEl.value;
            }

            this.countryEl.changeUpdater = this.update.bind(this);

            Event.observe(this.countryEl, 'change', this.update.bind(this));
        },

        _checkRegionRequired: function()
        {
            if (!this.isRegionRequired) {
                return;
            }

            var label, wildCard;
            var elements = [this.regionTextEl, this.regionSelectEl];
            var that = this;
            if (typeof this.config == 'undefined') {
                return;
            }
            var regionRequired = this.config.regions_required.indexOf(this.countryEl.value) >= 0;

            elements.each(function(currentElement) {
                if(!currentElement) {
                    return;
                }
                var form = currentElement.form,
                    validationInstance = form ? jQuery(form).data('validation') : null,
                    field = currentElement.up('.field') || new Element('div');

                if (validationInstance) {
                    validationInstance.clearError(currentElement);
                }
                label = $$('label[for="' + currentElement.id + '"]')[0];
                if (label) {
                    wildCard = label.down('em') || label.down('span.required');
                    var topElement = label.up('tr') || label.up('li');
                    if (!that.config.show_all_regions && topElement) {
                        if (regionRequired) {
                            topElement.show();
                        } else {
                            topElement.hide();
                        }
                    }
                }

                if (label && wildCard) {
                    if (!regionRequired) {
                        wildCard.hide();
                    } else {
                        wildCard.show();
                    }
                }

                //compute the need for the required fields
                if (!regionRequired || !currentElement.visible()) {
                    if (field.hasClassName('required')) {
                        field.removeClassName('required');
                    }
                    if (currentElement.hasClassName('required-entry')) {
                        currentElement.removeClassName('required-entry');
                    }
                    if ('select' == currentElement.tagName.toLowerCase() &&
                        currentElement.hasClassName('validate-select')
                    ) {
                        currentElement.removeClassName('validate-select');
                    }
                } else {
                    if (!field.hasClassName('required')) {
                        field.addClassName('required');
                    }
                    if (!currentElement.hasClassName('required-entry')) {
                        currentElement.addClassName('required-entry');
                    }
                    if ('select' == currentElement.tagName.toLowerCase() &&
                        !currentElement.hasClassName('validate-select')
                    ) {
                        currentElement.addClassName('validate-select');
                    }
                }
            });
        },

        disableRegionValidation: function()
        {
            this.isRegionRequired = false;
        },

        update: function()
        {
            if (this.regions[this.countryEl.value]) {

                if (this.lastCountryId!=this.countryEl.value) {
                    var i, option, region, def;

                    def = this.regionSelectEl.getAttribute('defaultValue');
                    if (this.regionTextEl) {
                        if (!def) {
                            def = this.regionTextEl.value.toLowerCase();
                        }
                        this.regionTextEl.value = '';
                    }

                    this.regionSelectEl.options.length = 1;
                    for (regionId in this.regions[this.countryEl.value]) {
                        region = this.regions[this.countryEl.value][regionId];

                        option = document.createElement('OPTION');
                        option.value = regionId;
                        option.text = region.name.stripTags();
                        option.title = region.name;

                        if (this.regionSelectEl.options.add) {
                            this.regionSelectEl.options.add(option);
                        } else {
                            this.regionSelectEl.appendChild(option);
                        }

                        if (regionId==def || region.name.toLowerCase()==def || region.code.toLowerCase()==def) {
                            this.regionSelectEl.value = regionId;
                        }
                    }
                }

                if (this.disableAction=='hide') {
                    if (this.regionTextEl) {
                        this.regionTextEl.style.display = 'none';
                        this.regionTextEl.style.disabled = true;
                    }
                    this.regionSelectEl.style.display = '';
                    this.regionSelectEl.disabled = false;
                } else if (this.disableAction=='disable') {
                    if (this.regionTextEl) {
                        this.regionTextEl.disabled = true;
                    }
                    this.regionSelectEl.disabled = false;
                }
                this.setMarkDisplay(this.regionSelectEl, true);

                this.lastCountryId = this.countryEl.value;
            } else {
                if (this.disableAction=='hide') {
                    if (this.regionTextEl) {
                        this.regionTextEl.style.display = '';
                        this.regionTextEl.style.disabled = false;
                    }
                    this.regionSelectEl.style.display = 'none';
                    this.regionSelectEl.disabled = true;
                } else if (this.disableAction=='disable') {
                    if (this.regionTextEl) {
                        this.regionTextEl.disabled = false;
                    }
                    this.regionSelectEl.disabled = true;
                    if (this.clearRegionValueOnDisable) {
                        this.regionSelectEl.value = '';
                    }
                } else if (this.disableAction=='nullify') {
                    this.regionSelectEl.options.length = 1;
                    this.regionSelectEl.value = '';
                    this.regionSelectEl.selectedIndex = 0;
                    this.lastCountryId = '';
                }
                this.setMarkDisplay(this.regionSelectEl, false);

//            // clone required stuff from select element and then remove it
//            this._regionSelectEl.className = this.regionSelectEl.className;
//            this._regionSelectEl.name      = this.regionSelectEl.name;
//            this._regionSelectEl.id        = this.regionSelectEl.id;
//            this._regionSelectEl.innerHTML = this.regionSelectEl.innerHTML;
//            Element.remove(this.regionSelectEl);
//            this.regionSelectEl = null;
            }
            varienGlobalEvents.fireEvent("address_country_changed", this.countryEl);
            if(typeof this.regionSelectEl.changeUpdater !== 'undefined'){
                this.regionSelectEl.changeUpdater();
            }
            this._checkRegionRequired();
        },

        setMarkDisplay: function(elem, display){
            if(elem.parentNode.parentNode){
                var marks = Element.select(elem.parentNode.parentNode, '.required');
                if(marks[0]){
                    display ? marks[0].show() : marks[0].hide();
                }
            }
        }
    };


    CityUpdater = Class.create();
    CityUpdater.prototype = {
        initialize: function (regionEl, cityTextEl, citySelectEl, cities, disableAction, clearRegionValueOnDisable)
        {
            this.isRegionRequired = true;
            this.regionEl = $(regionEl);
            this.cityTextEl = $(cityTextEl);
            this.citySelectEl = $(citySelectEl);
            this.config = cities['config'];
            delete cities.config;
            this.cities = cities;
            this.disableAction = (typeof disableAction=='undefined') ? 'hide' : disableAction;
            this.clearRegionValueOnDisable = (typeof clearRegionValueOnDisable == 'undefined') ? false : clearRegionValueOnDisable;

            if (this.citySelectEl.options.length<=1) {
                this.update();
            }
            else {
                this.lastRegionId = this.regionEl.value;
            }
            this.cityTextEl.hide();
            this.regionEl.changeUpdater = this.update.bind(this);
            this.cityTextEl.changeUpdater = this.update.bind(this);
            Event.observe(this.citySelectEl,'change',this.syncvalue.bind(this));
            Event.observe(this.regionEl, 'change', this.update.bind(this));
        },
        syncvalue:function(){
            this.cityTextEl.value = this.citySelectEl[this.citySelectEl.selectedIndex].text
        },
        _checkRegionRequired: function()
        {
            if (!this.isRegionRequired) {
                return;
            }

            var label, wildCard;
            var elements = [this.cityTextEl, this.citySelectEl];
            var that = this;
            if (typeof this.config == 'undefined') {
                return;
            }
            var regionRequired = this.config.regions_required.indexOf(this.regionEl.value) >= 0;

            elements.each(function(currentElement) {
                if(!currentElement) {
                    return;
                }
                var form = currentElement.form,
                    validationInstance = form ? jQuery(form).data('validation') : null,
                    field = currentElement.up('.field') || new Element('div');

                if (validationInstance) {
                    validationInstance.clearError(currentElement);
                }
                label = $$('label[for="' + currentElement.id + '"]')[0];
                if (label) {
                    wildCard = label.down('em') || label.down('span.required');
                    var topElement = label.up('tr') || label.up('li');
                    if (!that.config.show_all_regions && topElement) {
                        if (regionRequired) {
                            topElement.show();
                        } else {
                            topElement.hide();
                        }
                    }
                }

                if (label && wildCard) {
                    if (!regionRequired) {
                        wildCard.hide();
                    } else {
                        wildCard.show();
                    }
                }

                //compute the need for the required fields
                if (!regionRequired || !currentElement.visible()) {
                    if (field.hasClassName('required')) {
                        field.removeClassName('required');
                    }
                    if (currentElement.hasClassName('required-entry')) {
                        currentElement.removeClassName('required-entry');
                    }
                    if ('select' == currentElement.tagName.toLowerCase() &&
                        currentElement.hasClassName('validate-select')
                    ) {
                        currentElement.removeClassName('validate-select');
                    }
                } else {
                    if (!field.hasClassName('required')) {
                        field.addClassName('required');
                    }
                    if (!currentElement.hasClassName('required-entry')) {
                        currentElement.addClassName('required-entry');
                    }
                    if ('select' == currentElement.tagName.toLowerCase() &&
                        !currentElement.hasClassName('validate-select')
                    ) {
                        currentElement.addClassName('validate-select');
                    }
                }
            });
        },

        disableRegionValidation: function()
        {
            this.isRegionRequired = false;
        },

        update: function()
        {
            if (this.cities[this.regionEl.value]) {

                if (true) {
                    var i, option, region, def,defId,selectId;
                    selectId = this.citySelectEl.readAttribute('id');
                    def = this.citySelectEl.getAttribute('defaultValue');
                    if (this.cityTextEl) {
                        if (this.cityTextEl.value.toLowerCase()) {
                            def = this.cityTextEl.value.toLowerCase();
                        }
                        this.cityTextEl.value = '';
                    }

                    this.citySelectEl.options.length = 1;
                    for (cityId in this.cities[this.regionEl.value]) {
                        city = this.cities[this.regionEl.value][cityId];

                        option = document.createElement('OPTION');
                        option.value = cityId;
                        option.text = city;
                        option.title = city;

                        if (this.citySelectEl.options.add) {
                            this.citySelectEl.options.add(option);
                        } else {
                            this.citySelectEl.appendChild(option);
                        }

                        if (cityId==def || city ==  def || city.toLowerCase()==def) {
                            defId = cityId;
                            this.citySelectEl.value = cityId;
                            this.cityTextEl.value = city;
                        }
                    }
                    //this.citySelectEl.setValue.delay(1,"1285");
                    if($(selectId) !== null){
                        setTimeout(function(){
                            $(selectId).setValue(defId);
                        },1000);
                    }

                }


                if (this.disableAction=='hide') {
                    if (this.cityTextEl) {
                        this.cityTextEl.style.display = 'none';
                        this.cityTextEl.style.disabled = true;
                    }
                    this.citySelectEl.style.display = '';
                    this.citySelectEl.disabled = false;
                } else if (this.disableAction=='disable') {
                    if (this.cityTextEl) {
                        this.cityTextEl.disabled = true;
                    }
                    this.citySelectEl.disabled = false;
                }
                this.setMarkDisplay(this.citySelectEl, true);

                this.lastRegionId = this.regionEl.value;
            } else {
                // if (this.disableAction=='hide') {
                //     if (this.cityTextEl) {
                //         this.cityTextEl.style.display = '';
                //         this.cityTextEl.style.disabled = false;
                //     }
                //     this.citySelectEl.style.display = 'none';
                //     this.citySelectEl.disabled = true;
                // } else if (this.disableAction=='disable') {
                //     if (this.cityTextEl) {
                //         this.cityTextEl.disabled = false;
                //     }
                //     this.citySelectEl.disabled = true;
                //     if (this.clearRegionValueOnDisable) {
                //         this.citySelectEl.value = '';
                //     }
                // } else if (this.disableAction=='nullify') {
                //     this.citySelectEl.options.length = 1;
                //     this.citySelectEl.value = '';
                //     this.citySelectEl.selectedIndex = 0;
                //     this.lastRegionId = '';
                // }
                this.setMarkDisplay(this.citySelectEl, false);

//            // clone required stuff from select element and then remove it
//            this._regionSelectEl.className = this.regionSelectEl.className;
//            this._regionSelectEl.name      = this.regionSelectEl.name;
//            this._regionSelectEl.id        = this.regionSelectEl.id;
//            this._regionSelectEl.innerHTML = this.regionSelectEl.innerHTML;
//            Element.remove(this.regionSelectEl);
//            this.regionSelectEl = null;
            }
            if(typeof this.citySelectEl.changeUpdater !== 'undefined'){
                this.citySelectEl.changeUpdater();
            }
            this._checkRegionRequired();
        },

        setMarkDisplay: function(elem, display){
            if(elem.parentNode.parentNode){
                var marks = Element.select(elem.parentNode.parentNode, '.required');
                if(marks[0]){
                    display ? marks[0].show() : marks[0].hide();
                }
            }
        }
    };

    cityUpdater = CityUpdater;



    SubdistrictUpdater = Class.create();
    SubdistrictUpdater.prototype = {
        initialize: function (regionEl, cityTextEl, citySelectEl, cities, disableAction, clearRegionValueOnDisable)
        {
            this.isRegionRequired = true;
            this.regionEl = $(regionEl);
            this.cityTextEl = $(cityTextEl);
            this.citySelectEl = $(citySelectEl);
            this.config = cities['config'];
            delete cities.config;
            this.cities = cities;
            this.disableAction = (typeof disableAction=='undefined') ? 'hide' : disableAction;
            this.clearRegionValueOnDisable = (typeof clearRegionValueOnDisable == 'undefined') ? false : clearRegionValueOnDisable;

            if (this.citySelectEl.options.length<=1) {
                this.update();
            }
            else {
                this.lastRegionId = this.regionEl.value;
            }
            this.cityTextEl.hide();
            this.regionEl.changeUpdater = this.update.bind(this);
            this.cityTextEl.changeUpdater = this.updateValue.bind(this);
            Event.observe(this.citySelectEl,'change',this.syncvalue.bind(this));
            Event.observe(this.regionEl, 'change', this.update.bind(this));
        },
        syncvalue:function(){
            this.cityTextEl.value = this.citySelectEl[this.citySelectEl.selectedIndex].text
        },
        updateValue: function()
        {
            var textEl = this.cityTextEl,defId;
            var selectId = this.citySelectEl.readAttribute('id');
            $(this.citySelectEl).childElements().each(function(o,i){
                if($(o).innerHTML == textEl.value){
                    defId = $(o).value;
                    o.selected = true;
                }
            })
            setTimeout(function(){
                $(selectId).setValue(defId);
            },1000);
            this.citySelectEl.writeAttribute('defaultvalue',textEl.value);
        },
        _checkRegionRequired: function()
        {
            if (!this.isRegionRequired) {
                return;
            }

            var label, wildCard;
            var elements = [this.cityTextEl, this.citySelectEl];
            var that = this;
            if (typeof this.config == 'undefined') {
                return;
            }
            var regionRequired = this.config.regions_required.indexOf(this.regionEl.value) >= 0;

            elements.each(function(currentElement) {
                if(!currentElement) {
                    return;
                }
                var form = currentElement.form,
                    validationInstance = form ? jQuery(form).data('validation') : null,
                    field = currentElement.up('.field') || new Element('div');

                if (validationInstance) {
                    validationInstance.clearError(currentElement);
                }
                label = $$('label[for="' + currentElement.id + '"]')[0];
                if (label) {
                    wildCard = label.down('em') || label.down('span.required');
                    var topElement = label.up('tr') || label.up('li');
                    if (!that.config.show_all_regions && topElement) {
                        if (regionRequired) {
                            topElement.show();
                        } else {
                            topElement.hide();
                        }
                    }
                }

                if (label && wildCard) {
                    if (!regionRequired) {
                        wildCard.hide();
                    } else {
                        wildCard.show();
                    }
                }

                //compute the need for the required fields
                if (!regionRequired || !currentElement.visible()) {
                    if (field.hasClassName('required')) {
                        field.removeClassName('required');
                    }
                    if (currentElement.hasClassName('required-entry')) {
                        currentElement.removeClassName('required-entry');
                    }
                    if ('select' == currentElement.tagName.toLowerCase() &&
                        currentElement.hasClassName('validate-select')
                    ) {
                        currentElement.removeClassName('validate-select');
                    }
                } else {
                    if (!field.hasClassName('required')) {
                        field.addClassName('required');
                    }
                    if (!currentElement.hasClassName('required-entry')) {
                        currentElement.addClassName('required-entry');
                    }
                    if ('select' == currentElement.tagName.toLowerCase() &&
                        !currentElement.hasClassName('validate-select')
                    ) {
                        currentElement.addClassName('validate-select');
                    }
                }
            });
        },

        disableRegionValidation: function()
        {
            this.isRegionRequired = false;
        },
        update: function()
        {
            if (this.cities[this.regionEl.value]) {

                if (true) {
                    var i, option, region, def,defId,selectId;
                    selectId = this.citySelectEl.readAttribute('id');
                    def = this.citySelectEl.getAttribute('defaultValue');
                    if (this.cityTextEl) {
                        if (!def) {
                            def = this.cityTextEl.value.toLowerCase();
                        }
                        this.cityTextEl.value = '';
                    }

                    this.citySelectEl.options.length = 1;
                    for (cityId in this.cities[this.regionEl.value]) {
                        city = this.cities[this.regionEl.value][cityId];

                        option = document.createElement('OPTION');
                        option.value = cityId;
                        option.text = city;
                        option.title = city;

                        if (this.citySelectEl.options.add) {
                            this.citySelectEl.options.add(option);
                        } else {
                            this.citySelectEl.appendChild(option);
                        }

                        if (cityId==def || city ==  def || city.toLowerCase()==def) {
                            defId = cityId;
                            this.citySelectEl.value = cityId;
                            this.cityTextEl.value = city;
                        }
                    }
                    //this.citySelectEl.setValue.delay(1,"1285");
                    if($(selectId) !== null){
                        setTimeout(function(){
                            $(selectId).setValue(defId);
                        },1000);
                    }

                }

                if (this.disableAction=='hide') {
                    if (this.cityTextEl) {
                        this.cityTextEl.style.display = 'none';
                        this.cityTextEl.style.disabled = true;
                    }
                    this.citySelectEl.style.display = '';
                    this.citySelectEl.disabled = false;
                } else if (this.disableAction=='disable') {
                    if (this.cityTextEl) {
                        this.cityTextEl.disabled = true;
                    }
                    this.citySelectEl.disabled = false;
                }
                this.setMarkDisplay(this.citySelectEl, true);

                this.lastRegionId = this.regionEl.value;
            } else {
                // if (this.disableAction=='hide') {
                //     if (this.cityTextEl) {
                //         this.cityTextEl.style.display = '';
                //         this.cityTextEl.style.disabled = false;
                //     }
                //     this.citySelectEl.style.display = 'none';
                //     this.citySelectEl.disabled = true;
                // } else if (this.disableAction=='disable') {
                //     if (this.cityTextEl) {
                //         this.cityTextEl.disabled = false;
                //     }
                //     this.citySelectEl.disabled = true;
                //     if (this.clearRegionValueOnDisable) {
                //         this.citySelectEl.value = '';
                //     }
                // } else if (this.disableAction=='nullify') {
                //     this.citySelectEl.options.length = 1;
                //     this.citySelectEl.value = '';
                //     this.citySelectEl.selectedIndex = 0;
                //     this.lastRegionId = '';
                // }
                this.setMarkDisplay(this.citySelectEl, false);

//            // clone required stuff from select element and then remove it
//            this._regionSelectEl.className = this.regionSelectEl.className;
//            this._regionSelectEl.name      = this.regionSelectEl.name;
//            this._regionSelectEl.id        = this.regionSelectEl.id;
//            this._regionSelectEl.innerHTML = this.regionSelectEl.innerHTML;
//            Element.remove(this.regionSelectEl);
//            this.regionSelectEl = null;
            }
            if(typeof this.citySelectEl.changeUpdater !== 'undefined'){
                this.citySelectEl.changeUpdater();
            }
            this._checkRegionRequired();
        },

        setMarkDisplay: function(elem, display){
            if(elem.parentNode.parentNode){
                var marks = Element.select(elem.parentNode.parentNode, '.required');
                if(marks[0]){
                    display ? marks[0].show() : marks[0].hide();
                }
            }
        }
    };


    ZipcodeUpdater = Class.create();
    ZipcodeUpdater.prototype = {
        initialize: function (regionEl, cityTextEl, citySelectEl, cities, disableAction, clearRegionValueOnDisable)
        {
            this.isRegionRequired = true;
            this.regionEl = $(regionEl);
            this.cityTextEl = $(cityTextEl);
            this.citySelectEl = $(citySelectEl);
            this.config = cities['config'];
            delete cities.config;
            this.cities = cities;
            this.disableAction = (typeof disableAction=='undefined') ? 'hide' : disableAction;
            this.clearRegionValueOnDisable = (typeof clearRegionValueOnDisable == 'undefined') ? false : clearRegionValueOnDisable;

            if (this.citySelectEl.options.length<=1) {
                this.update();
            }
            else {
                this.lastRegionId = this.regionEl.value;
            }
            this.cityTextEl.hide();
            this.regionEl.changeUpdater = this.update.bind(this);
            this.cityTextEl.changeUpdater = this.updateValue.bind(this);
            Event.observe(this.citySelectEl,'change',this.syncvalue.bind(this));
            Event.observe(this.regionEl, 'change', this.update.bind(this));
        },
        syncvalue:function(){
            if(this.citySelectEl.value !== ""){
                this.cityTextEl.value = this.citySelectEl[this.citySelectEl.selectedIndex].text
            }
        },
        _checkRegionRequired: function()
        {
            if (!this.isRegionRequired) {
                return;
            }

            var label, wildCard;
            var elements = [this.cityTextEl, this.citySelectEl];
            var that = this;
            if (typeof this.config == 'undefined') {
                return;
            }
            var regionRequired = this.config.regions_required.indexOf(this.regionEl.value) >= 0;

            elements.each(function(currentElement) {
                if(!currentElement) {
                    return;
                }
                var form = currentElement.form,
                    validationInstance = form ? jQuery(form).data('validation') : null,
                    field = currentElement.up('.field') || new Element('div');

                if (validationInstance) {
                    validationInstance.clearError(currentElement);
                }
                label = $$('label[for="' + currentElement.id + '"]')[0];
                if (label) {
                    wildCard = label.down('em') || label.down('span.required');
                    var topElement = label.up('tr') || label.up('li');
                    if (!that.config.show_all_regions && topElement) {
                        if (regionRequired) {
                            topElement.show();
                        } else {
                            topElement.hide();
                        }
                    }
                }

                if (label && wildCard) {
                    if (!regionRequired) {
                        wildCard.hide();
                    } else {
                        wildCard.show();
                    }
                }

                //compute the need for the required fields
                if (!regionRequired || !currentElement.visible()) {
                    if (field.hasClassName('required')) {
                        field.removeClassName('required');
                    }
                    if (currentElement.hasClassName('required-entry')) {
                        currentElement.removeClassName('required-entry');
                    }
                    if ('select' == currentElement.tagName.toLowerCase() &&
                        currentElement.hasClassName('validate-select')
                    ) {
                        currentElement.removeClassName('validate-select');
                    }
                } else {
                    if (!field.hasClassName('required')) {
                        field.addClassName('required');
                    }
                    if (!currentElement.hasClassName('required-entry')) {
                        currentElement.addClassName('required-entry');
                    }
                    if ('select' == currentElement.tagName.toLowerCase() &&
                        !currentElement.hasClassName('validate-select')
                    ) {
                        currentElement.addClassName('validate-select');
                    }
                }
            });
        },

        disableRegionValidation: function()
        {
            this.isRegionRequired = false;
        },
        updateValue: function()
        {
            var textEl = this.cityTextEl,defId;
            var selectId = this.citySelectEl.readAttribute('id');
            zipcode = textEl.value;
            this.citySelectEl.options.length = 1;

            option = document.createElement('OPTION');
            option.value = zipcode;
            option.text = zipcode;
            option.title = zipcode;

            if (this.citySelectEl.options.add) {
                this.citySelectEl.options.add(option);
            } else {
                this.citySelectEl.appendChild(option);
            }
            this.citySelectEl.value = zipcode;
            //this.cityTextEl.value = zipcode;
            //this.citySelectEl.setValue.delay(1,"1285");
            setTimeout(function(){
                $(selectId).setValue(zipcode);
            },1000);
            this.citySelectEl.writeAttribute('defaultvalue',textEl.value);
        },
        update: function()
        {
            if (this.cities[this.regionEl.value]) {

                if (true) {
                    var i, option, region, def;

                    def = this.citySelectEl.getAttribute('defaultValue');
                    if (this.cityTextEl) {
                        if (!def) {
                            def = this.cityTextEl.value.toLowerCase();
                        }
                        this.cityTextEl.value = '';
                    }

                    this.citySelectEl.options.length = 1;
                    zipcode = this.cities[this.regionEl.value][0];
                   // for (cityId in this.cities[this.regionEl.value]) {


                        option = document.createElement('OPTION');
                        option.value = zipcode;
                        option.text = zipcode;
                        option.title = zipcode;

                        if (this.citySelectEl.options.add) {
                            this.citySelectEl.options.add(option);
                        } else {
                            this.citySelectEl.appendChild(option);
                        }

                        if (zipcode==def) {
                            this.citySelectEl.value = zipcode;
                            this.cityTextEl.value = zipcode;
                        }
                   // }
                }

                if (this.disableAction=='hide') {
                    if (this.cityTextEl) {
                        this.cityTextEl.style.display = 'none';
                        this.cityTextEl.style.disabled = true;
                    }
                    this.citySelectEl.style.display = '';
                    this.citySelectEl.disabled = false;
                } else if (this.disableAction=='disable') {
                    if (this.cityTextEl) {
                        this.cityTextEl.disabled = true;
                    }
                    this.citySelectEl.disabled = false;
                }
                this.setMarkDisplay(this.citySelectEl, true);

                this.lastRegionId = this.regionEl.value;
            } else {
                // if (this.disableAction=='hide') {
                //     if (this.cityTextEl) {
                //         this.cityTextEl.style.display = '';
                //         this.cityTextEl.style.disabled = false;
                //     }
                //     this.citySelectEl.style.display = 'none';
                //     this.citySelectEl.disabled = true;
                // } else if (this.disableAction=='disable') {
                //     if (this.cityTextEl) {
                //         this.cityTextEl.disabled = false;
                //     }
                //     this.citySelectEl.disabled = true;
                //     if (this.clearRegionValueOnDisable) {
                //         this.citySelectEl.value = '';
                //     }
                // } else if (this.disableAction=='nullify') {
                //     this.citySelectEl.options.length = 1;
                //     this.citySelectEl.value = '';
                //     this.citySelectEl.selectedIndex = 0;
                //     this.lastRegionId = '';
                // }
                this.setMarkDisplay(this.citySelectEl, false);

//            // clone required stuff from select element and then remove it
//            this._regionSelectEl.className = this.regionSelectEl.className;
//            this._regionSelectEl.name      = this.regionSelectEl.name;
//            this._regionSelectEl.id        = this.regionSelectEl.id;
//            this._regionSelectEl.innerHTML = this.regionSelectEl.innerHTML;
//            Element.remove(this.regionSelectEl);
//            this.regionSelectEl = null;
            }
            if(typeof this.citySelectEl.changeUpdater !== 'undefined'){
                this.citySelectEl.changeUpdater();
            }
            this.cityTextEl.removeClassName('required-entry');
        },

        setMarkDisplay: function(elem, display){
            if(elem.parentNode.parentNode){
                var marks = Element.select(elem.parentNode.parentNode, '.required');
                if(marks[0]){
                    display ? marks[0].show() : marks[0].hide();
                }
            }
        }
    };





})