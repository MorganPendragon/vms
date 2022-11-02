$(function () {
    //TODO:Code restructure

    //caches selected tab before the page reload and shows the tab on reload
    $('a[data-bs-toggle="tab"]').on('show.bs.tab', function (e) {
        localStorage.setItem('activeTab', $(e.target).attr('href'));
        console.log($(e.target).attr('href'));
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

    //form validation
    $('form').on('submit', function (e) {
        var validated = 0;
        var name = "";
        console.log($(this).data('form'));
        switch ($(this).data('form')) {
            //student submit
            case 1:
                $name = $('input[name="fname[0]"], input[name="mname[0]"], input[name="lname[0]"], input[type="text"][name="firstdoctor[0]"]');
                $tel = $('input[name="tel[0]"]');
                //generate random id for student
                var id = new Date().getFullYear().toString().substring(2);
                id += "-";
                id += Math.random().toString(9).substring(2, 8);
                $("#studentID").val(id);
                console.log('student form fired');
                break;
            //student update
            case 2:
                $name = $('input[name="upFirstName[0]"], input[name="upMiddleName[0]"], input[name="upLastName[0]"], input[type="text"][name="upDoctorName[0]"]');
                $tel = $('input[name="upTel[0]"]');
                console.log('student update form fired');
                break;
            //faculty insert
            case 3:
                break;
            //faculty update
            case 4:
                break;
            default:
                break;
        }

        //name validation check
        $name.each(function () {
            if (/^$|[a-zA-Z ]+$/.test($(this).val())) {
                validated++;
                if (validated < 4) {
                    if (validated % 2 == 0) {
                        name += " " + $(this).val().toString() + " ";
                        console.log('valid');
                    }
                    else {
                        name += $(this).val().toString();
                        console.log('valid');
                    }
                }
            }
            else {
                validated = 0;
                $(this).siblings('p').text('invalid').fadeOut(5000);
            }
        });

        $('input[name="name[0]"]').val(name);
        console.log(name);
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
        if (/-[0-9]{8,}/.test(id)) {
            window.location = ''
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

    //activate components on form
    $date = $('input[name="firstDose[0]"], input[name="upFirstDose[0]"], input[name="firstdose[1]"]');
    $date.on('change', function () {
        console.log($(this).val());
        switch ($(this).data('activate')) {
            case 1:
                $activate = $('input[name="seconddose[0]"], select[name="brand[0]"], input[name="doctorName[0]"]');
                $brand = $('slect[name="brand[0]"]');
                $doctorName = $('input[name="doctorName[0]"]');
                console.log('student submit firsdose date activated');
                break;
            case 2:
                $activate = $('input[name="upSecondDose[0]"], select[name="upBrand[0]"], input[name="upDoctorName[0]"]');
                $brand = $('select[name="upBrand[0]"]');
                $doctorName = $('input[name="upDoctorName[0]"]');
                console.log('student update firsdose date activated');
                break;
            case 3:
                break;
            case 4:
                break;
            default:
                break;
        }
        if (!$(this).val().toString() == "") {
            $activate.each(function () {
                $(this).removeAttr('disabled');
            });
            $brand.attr('required', 'required');
            $doctorName.attr('required', 'required');
        }
        else {
            $activate.each(function () {
                $(this).attr('disabled', 'disabled');
            });
        }
    });
});