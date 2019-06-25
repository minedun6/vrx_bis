var initComponents = function () {
    var t = function () {
        jQuery().datepicker && $(".date-picker").datepicker({
            rtl: App.isRTL(),
            orientation: "left",
            language: 'fr',
            autoclose: !0
        })
    };
    var a = function () {
        jQuery().select2 && $(".select2").select2({
            placeholder: $(this).data('placeholder'),
            theme: "bootstrap",
            width: null
        })
    };
    var o = function () {
        jQuery().daterangepicker && $("#filter_played_at").daterangepicker({
                ranges: {
                    'Aujourd\'hui': [moment(), moment()],
                    'Hier': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    '7 Derniers Jours': [moment().subtract(6, 'days'), moment()],
                    '30 Derniers Jours': [moment().subtract(29, 'days'), moment()],
                    'Ce Mois': [moment().startOf('month'), moment().endOf('month')],
                    'Dernier Mois': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                opens: "right",
                locale: {
                    customRangeLabel: 'Définir Interval'
                }
            },
            function (start, end) {
                $('#filter_played_at span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }
        );
        if (jQuery().daterangepicker) {
            $('#filter_played_at span').html(moment().subtract(29, 'days').format('LL') + ' - ' + moment().format('LL'));
        }
    };
    return {
        init: function () {
            t(), a(), o()
        }
    }
}();

jQuery(document).ready(function () {
    initComponents.init()
});