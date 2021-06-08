define([
    'jquery',
    'mage/translate',
    'Magento_Ui/js/modal/modal',
    'underscore',
    'mage/validation',
    'jquery/ui'
], function($, $t, modal, _) {

    $.widget('azra.priceRequest',{
        options: {
            priceRequestModalId: '',
            modalButtonId: '',
            messageContainer: '',
            successClass: 'success',
            errorClass: 'error'
        },

        _create: function () {
            this.initializeModal();
            this.bindModalClick();
            this.bindSubmit();
        },

        initializeModal: function(){
            let options = {
                type: 'popup',
                responsive: true,
                innerScroll: true,
                title: $.mage.__('Price Request Form'),
                buttons: []
            };
            console.log('initializeModal', options, this.options.priceRequestModalId, $(this.options.priceRequestModalId));
            var popup = modal(options, $(this.options.priceRequestModalId));
        },

        bindModalClick: function() {
            var self = this;
            $(this.options.modalButtonId).click(function(event) {
                event.preventDefault();
                $(self.options.priceRequestModalId).modal('openModal');
            });
        },

        bindSubmit: function() {
            var self = this;
            var form = this.element;
            var url = form.attr('action');
            form.submit(function(e) {
                $('body').trigger('processStart');
                if(self.isFormValid()){
                    e.preventDefault();
                    let data = form.serialize();
                    if (data) {
                        $.ajax({
                            url: url,
                            dataType: 'json',
                            type: 'POST',
                            data: data,
                            success: function (response){
                                self.processResponse(response);
                            },
                            error: function (response) {
                                self.processResponse(response);
                            }
                        });
                    }
                } else {
                    $('body').trigger('processStop');
                }
            });
        },

        isFormValid: function () {
            return this.element.validation() && this.element.validation('isValid');
        },

        processResponse: function(response) {
            console.log(response);
            let cssClass = this.options.errorClass,
                message = $t("Something went wrong,please try again later!");

            if (_.isObject(response) &&
                _.has(response,"success") &&
                _.has(response,"message") &&
                response.success == true) {

                cssClass = this.options.successClass;
                message = response.message;
            }

            if (_.isObject(response) &&
                _.has(response,"error") &&
                _.has(response,"message") &&
                response.error == true) {

                cssClass = this.options.errorClass;
                message = response.message;
            }

            let paragraph = $("<p></p>",{class: "message"});
            paragraph.addClass(cssClass);
            paragraph.html(message);
            $(this.options.messageContainer).html(paragraph);
            $(this.options.modalButtonId).hide();
            this.element.hide();
            $('body').trigger('processStop');
        }
    });

    return $.azra.priceRequest;
});
