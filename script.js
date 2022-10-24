$(document).ready(function () {
    //caches selected tab before the page reload and shows the tab on reload
    $('a[data-bs-toggle="tab"]').on('show.bs.tab', function (e) {
        localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('activeTab');
    if (activeTab) {
        $('#tableTab a[href="' + activeTab + '"]').tab('show');
    }

    //global search
    $(".search").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("tbody tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});