
$(function() {
    $("td[colspan=8]").find("table").hide();

    $("table").click(function(event) {
        event.stopPropagation();
        var $target = $(event.target);

        if ($target.closest("td").attr("colspan") > 1 ) {
            $target.closest("tr").prev().find("td:first").html("<b>+</b>");
        } else {
            $target.slideDown;
            $target.closest("tr").next().find("table").slideToggle();
        }
    });
});

