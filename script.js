$(function () {
    //TODO:Code restructure

    //caches selected tab before the page reload and shows the tab on reload
    $('a[data-bs-toggle="tab"]').on('show.bs.tab', function (e) {
        localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('activeTab');
    if (activeTab) {
        $('#tableTab a[href="' + activeTab + '"]').tab('show');
    }

    //login magic
    $signUpButton = $('#signUpStudent, #signUpFaculty, button[name="back"]')
    $signUpButton.on('click', function (e) {
        //hides and shows div what do you expect?
        $($(this).data('hide')).hide();
        $($(this).data('show')).show();
    });

    //global search
    $('.search').on('input', function () {
        var value = $(this).val().toLowerCase();
        $table = $($(this).data('table').toString() + " tr");
        $table.filter(function () {
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
        var brandValue = $('#brandFilter').val();
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
            else if (brandValue == $(this).find('td[name="brandTd[0]"], td[name="brandTd[1]"]').data('brand')) {
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

    //form validation
    $('form').on('submit', function (e) {
        var validated = 0;
        var formname = "";
        switch ($(this).data('form')) {
            //student submit
            case 1:
                $name = $('input[name$="name[0]"], input[name$="doctor[0]"]');
                $tel = $('input[name="tel[0]"]');
                $finalName = $('input[name="name[0]"]');
                //generate random id for student
                var id = new Date().getFullYear().toString().substring(2);
                id += "-";
                id += Math.random().toString(9).substring(2, 8);
                $('input[name="id[0]"]').val(id);
                console.log('student form fired');
                break;
            //student update
            case 2:
                $name = $('input[name$="name[1]"], input[name$="doctor[1]"]');
                $tel = $('input[name="tel[1]"]');
                $finalName = $('input[name="name[1]"]');
                break;
            //faculty insert
            case 3:
                $name = $('input[name$="name[2]"], input[name$="doctor[2]"]');
                $tel = $('input[name="tel[2]"]');
                $finalName = $('input[name="name[2]"]');
                console.log('faculty form fired');
                break;
            //faculty update
            case 4:
                $name = $('input[name$="name[3]"], input[name$="doctor[3]"]');
                $tel = $('input[name="tel[3]"]');
                $finalName = $('input[name="name[3]"]');
                console.log('faculty update form fired');
                break;
            default:
                break;
        }
        //name validation check
        console.log($(this).data('name').toString());
        formname = $($(this).data('name')).map(function(){
            return $(this).val();
        }).get().join(' ');

        $finalName.val(formname);
        console.log(formname);

        validated++;

        //stop submit if < 5
        console.log(validated);
        if (validated < 5) {
            e.preventDefault();
        }

    });

    $('#login').on('submit', function (e) {
        e.preventDefault();
        var id = $('#idNo').val().toString();
        if (/^[0-9]{1,2}-[0-9]{8,8}$/.test(id)) {
            //redirect to student
            location.href = '';
        }
        else if (/^F[0-9]{1,1}-[0-9]{8,8}$/.test(id)) {
            //redirect to faculty
            location.href = '';
        }
        else if (/admin/.test(id)) {
            //redirect to admin
            if ($('#pwd').val().toString() == 'admin') {
                location.href = 'adminview.php';
            }
        }
        else {
            $('#idFeedback').text("fuck you").show().fadeOut(2000);
        }
    });

    //activate components on form
    $date = $('input[type="date"][name*="dose"], input[type="date"][name^="booster"]');
    $date.on('change', activateAndReq);

    function activateAndReq() {
        console.log($(this).val().toString());
        if ($(this).val().toString()) {
            $($(this).data('activate')).each(function () {
                $(this).removeAttr('disabled');
            });
            $req.attr('required', 'required');
        }
        else {
            $(this).data('required').each(function () {
                $(this).attr('disabled', 'disabled');
                $(this).val('');
                $(this).removeAttr('required', 'required');
            });
        }
    }
});