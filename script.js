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
                $name = $('input[name="fname[0]"], input[name="mname[0]"], input[name="lname[0]"], input[name = "firstdoctor[0]"], input[name = "seconddoctor[0]"], input[name = "boosterdoctor[0]"]');
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
                $name = $('input[name="fname[1]"], input[name="mname[1]"], input[name="lname[1]"], input[name = "firstdoctor[1]"], input[name = "seconddoctor[1]"], input[name = "boosterdoctor[1]"]');
                $tel = $('input[name="tel[1]"]');
                $finalName = $('input[name="name[1]"]');
                break;
            //faculty insert
            case 3:
                $name = $('input[name="fname[2]"], input[name="mname[2]"], input[name="lname[2]"], input[name = "firstdoctor[2]"], input[name = "seconddoctor[2]"], input[name = "boosterdoctor[2]"]');
                $tel = $('input[name="tel[2]"]');
                $finalName = $('input[name="name[2]"]');
                console.log('faculty form fired');
                break;
            //faculty update
            case 4:
                $name = $('input[name="fname[3]"], input[name="mname[3]"], input[name="lname[3]"], input[name = "firstdoctor[3]"], input[name = "seconddoctor[3]"], input[name = "boosterdoctor[3]"]');
                $tel = $('input[name="tel[3]"]');
                $finalName = $('input[name="name[3]"]');
                console.log('faculty update form fired');
                break;
            default:
                break;
        }
        //name validation check
        $name.each(function () {
            if (/^$|[a-zA-Z ]$/.test($(this).val())) {
                validated++;
                if (validated < 4) {
                    if (validated % 2 == 0) {
                        formname += " " + $(this).val().toString() + " ";
                        console.log($(this).val().toString());
                    }
                    else {
                        formname += $(this).val().toString();
                        console.log($(this).val().toString());
                    }
                }
            }
            else {
                validated = 0;
                $(this).siblings('p').text('invalid').fadeOut(5000);
            }
        });

        $finalName.val(formname);
        console.log(formname);
        //tel validation
        if (!(/^$|^09[0-9]{9,9}$/.test($tel.val()))) {
            validated = 0;
            $tel.siblings('p').text('invalid').fadeOut(5000);
            console.log('invalid');
        }
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
    $date = $('input[name="firstdose[0]"], input[name="firstdose[1]"], input[name="firstdose[2]"], input[name="firstdose[3]"], input[name="seconddose[0]"], input[name="seconddose[1]"], input[name="seconddose[2]"], input[name="seconddose[3]"], input[name="booster[0]"], input[name="booster[1]"], input[name="booster[2]"], input[name="booster[3]"]');
    $date.on('change', activateAndReq);

    function activateAndReq() {
        $activate = $($(this).data('activate').toString());
        $req = $($(this).data('required').toString());
        if ($(this).val().toString()) {
            $activate.each(function () {
                $(this).removeAttr('disabled');
            });
            $req.attr('required', 'required');
        }
        else {
            $activate.each(function () {
                $(this).attr('disabled', 'disabled');
                $(this).removeAttr('required', 'required');
            });
        }
    }
});