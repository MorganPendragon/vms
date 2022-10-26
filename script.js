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
    $('.search').on('input', function () {
        var value = $(this).val().toLowerCase();
        $("tbody tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    //student filter
    $filter = $('#yearLevel, #brandFilter, #studentStatus')
    $filter.change(function () {
        filterStudent();
    })
    $('#studentContent tr').show();

    function filterStudent() {
        $('#studentContent tr').hide();
        var yearFlag = 0;
        var yearValue = $('#yearLevel').val();
        var brandFlag = 0;
        var brandValue = $('#brand').val();
        var statusFlag = 0;
        var statusValue = $('#studentStatus').val();

        //row traverse
        $('#studentTable tr').each(function () {
            //year Filter
            if (yearValue == 0) {
                yearFlag = 1;
            }
            else if (yearValue == $(this).find('#yearTd').data('yr')) {
                yearFlag = 1;
            }
            else {
                yearFlag = 0;
            }

            //brand filter
            if (brandValue == 0) {
                brandFlag = 1;
            }
            else if (brandValue == $(this).find('#brandTd').data('brand')) {
                brandFlag = 1;
            }
            else {
                brandFlag = 0;
            }

            //status Filter
            if (statusValue == 0) {
                statusFlag = 1;
            }
            else if (statusValue == $(this).find('#statusTd').data('status')) {
                statusFlag = 1;
            }
            else {
                statusFlag = 0;
            }

            if (yearFlag && brandFlag && statusFlag) {
                $(this).show();
            }
        })
    }

    $name = $('#fname, #mname, #lname');
    $('#studentForm').submit(function (e) {
        //generate random id for student

        var id = new Date().getFullYear().toString().substring(2);
        id += "-";
        id += Math.random().toString(9).substring(2, 8);
        $("#studentID").val(id);

        //TODO:Regex WIP
        $name.each(function () {
            $(this).on("input", function () {
                if (!(/[a-zA-Z]/.test($(this).val().toString()))) {
                    e.preventDefault();
                }
            });
        });
        $('studentForm').submit();

    });


    $('#login').submit(function (e) {
        e.preventDefault();
        var id = $('#idNo').val().toString();
        if (/-[0-9]{8,}/.test(id)) {
            $('#idFeedback').text("success").show().fadeOut(2000);
        }
        else if (/admin/.test(id)) {
            if ($('#pwd').val().toString() == 'admin') {
                location.href = 'adminview.php';
            }
        }
        else {
            $('#idFeedback').text("fuck you").show().fadeOut(2000);
        }
    });

    $('#firstStudentDose').on('change', function () {
        console.log($(this).val());
        if (!$(this).val().toString() == "") {
            $('#secondStudentDose').removeAttr('disabled');
            $('#brandStudent').removeAttr('disabled');
            $('#brandStudent').attr('required', 'required');
        }
        else {
            $('#secondStudentDose').attr('disabled', 'disabled');
            $('#brandStudent').attr('disabled', 'disabled');
        }
    });
});