containerId = 'slider1_container';



slideshow_transition_controller_starter("slider1_container");
$('#stTransition').val(code);
$('#sButtonPlay').click();

slideshow_transition_controller_starter = function (containerId) {
    var options = {
        $ArrowNavigatorOptions: {
            $Class: $JssorArrowNavigator$,
            $ChanceToShow: 2
        }
    };
    var jssor_slider1 = new $JssorSlider$(containerId, options);
};
