(function (root, CP_Customizer, $) {

    CP_Customizer.addModule(function (CP_Customizer) {

        var sectionPanel = CP_Customizer.panels.sectionPanel;
        var priority = 4;

        sectionPanel.registerArea('fullscreen_options', {
            priority: priority,
            areaTitle: root.CP_Customizer.translateCompanionString('Titles separator'),
            init: function ($container) {

                var showTitlesSeparator = CP_Customizer.createControl.checkbox(
                    this.getPrefixed('show-titles-separator'),
                    $container,
                    root.CP_Customizer.translateCompanionString('Show titles separator')
                );

                var titlesSeparatorColor = CP_Customizer.createControl.color(
                    this.getPrefixed('titles-separator-color'),
                    $container,
                    {
                        label: root.CP_Customizer.translateCompanionString('Titles separator color')
                    }
                );

                this.addToControlsList(showTitlesSeparator);
                this.addToControlsList(titlesSeparatorColor);
            },

            update: function (data) {

                var selector = '[data-id="' + data.section.attr('data-id') + '"] h2';
                var headings = CP_Customizer.preview.find(selector);

                var showTitlesSeparator = !headings.hasClass("no-after");
                var titlesSeparatorColor = headings.css("border-bottom-color");
                var showTitlesSeparatorControl = this.getControl('titles-separator-color');

                this.getControl('show-titles-separator').attachWithSetter(
                    showTitlesSeparator,
                    function (value) {
                        console.log(value);
                        if (value) {
                            CP_Customizer.preview.find(selector).removeClass('no-after');
                            showTitlesSeparatorControl.show();
                        } else {
                            CP_Customizer.preview.find(selector).addClass('no-after');
                            showTitlesSeparatorControl.hide();
                        }
                    }
                );

                showTitlesSeparatorControl.attachWithSetter(
                    titlesSeparatorColor,
                    function (value) {
                        if (value) {
                            CP_Customizer.preview.find(selector).css("border-bottom-color", value);
                        } else {
                            CP_Customizer.preview.find(selector).css("border-bottom-color", "");
                        }
                    }
                );

                this.getControl('show-titles-separator').set(true);
            }
        });

        CP_Customizer.hooks.addAction('before_section_remove', function ($section) {
            var sectionID = jQuery($section).attr('id');
            var node = CP_Customizer.preview.find('#side-navigation li[data-ssid="' + sectionID + '"]');
            node.remove();
        });

    });


})(window, CP_Customizer, jQuery);
