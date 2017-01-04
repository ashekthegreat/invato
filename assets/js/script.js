;(function ($) {
    if(typeof String.prototype.trim !== 'function') {
        String.prototype.trim = function() {
            return this.replace(/^\s+|\s+$/g, '');
        }
    }

    $(function () {

        $(".button-collapse").sideNav();
    });

    $(document).ready(function() {
        $('#textarea2').characterCounter();
    });
}(jQuery));
