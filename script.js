$(document).ready(function () {
    var yearFilter = '';
    var brandFilter ='';
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

    //year level filter
    $("#yearLevelFilter option").on("click", function () {
        var value;
        if ($(this).val() != yearFilter) {
            value = $(this).val();
            $("#studentContent tr").filter(function () {
                $(this).toggle($(this).text().indexOf(value) > -1)
            });
        }
        else
        {
            value = '';
            $("#studentContent tr").filter(function () {
                $(this).toggle($(this).text().indexOf(value) > -1)
            });
            $('#yearFilter').prop('selectedIndex',0);
        }
        yearFilter = $(this).val();
    });

    //generate random id for student
    $("#studentForm").submit(function () {
        var id = new Date().getFullYear().toString().substring(2);
        id += "-";
        id += Math.random().toString(9).substring(2, 8);
        $("#studentID").val(id);
    });
});