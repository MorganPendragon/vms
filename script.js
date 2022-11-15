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
    $('form[id!="login"]').on('submit', function (e) {
        if (typeof ($(this).data('validation')) != 'undefined') {
            var validated = 1;

            $id = $($(this).parent().find('input[type="text"][name^="id"]'))
            switch ($(this).data('validation')) {
                //student id validation
                case 1:
                    /*
                        student id should look like this:
                        XX-XXXXXX
                    */
                    if (!(/^[0-9]{1,2}-[0-9]{6,6}$/.test($id.val()))) {
                        validated = 0;
                        $(this).siblings('p').text('Invalid').fadeOut(5000);
                    }
                    break;
                //faculty id validation
                case 2:
                    /* 
                        faculty id should look like this:
                        FX-XXXXXX
                    */
                    if (!(/^F[0-9]{1,1}-[0-9]{6,6}$/.test($id.val()))) {
                        validated = 0;
                        $(this).siblings('p').text('Invalid').fadeOut(5000);
                    }
                    break;
            }

            //name check
            var name = $($(this).parent().find('input[type="text"][name*="name"]')).map(function (index) {
                if (/[a-zA-Z ]$/.test($(this).val().toString())) {
                    validated++;
                    return $(this).val();
                }
                else {
                    validated = 0;
                    $(this).siblings('p').text('Invalid').fadeOut(5000);
                }
            }).get().join(' ');
            $(this).parent().find('input[type="hidden"][name^="name"]').val(name);

            //doctor name check
            $($(this).parent().find('input[type="text"][name*="doctor"]')).map(function () {
                if (/^$|[a-zA-Z ]$/.test($(this).val().toString())) {
                    validated++;
                    return $(this).val();
                }
                else {
                    validated = 0;
                    $(this).siblings('p').text('Invalid').fadeOut(5000);
                }
            });

            //telephone number validation
            $tel = $($(this).parent().find('input[type="text"][name^="tel"]'));
            if (!(/^09[0-9]{9,9}$/.test($tel.val()))) {
                validated = 0;
                $tel.siblings('p').text('invalid').fadeOut(5000);
            }
            validated++;

            console.log(validated);
            console.log(name);

            //prevents form submission if one element is not validated
            if (validated < 8) {
                e.preventDefault();
            }
        }
    });

    $('#login').on('submit', function (e) {

        $feedback = $($(this).parent().find('div[name="loginFeedback"]'));
        var id = $('input[name="id[0]"]').val().toString();
        var password = $('input[name="password[0]"]').val().toString();
        if (/^[0-9]{1,2}-[0-9]{6,6}$/.test(id)) {
            //redirect to student
            $feedback.load('conn.php',{
                type: '1',
                id: id,
                password: password
            });
        }
        else if (/^F[0-9]{1,1}-[0-9]{6,6}$/.test(id)) {
            //redirect to faculty

        }
        else if (/admin/.test(id)) {
            //redirect to admin
            if ($('#pwd').val().toString() == 'admin') {
                location.href = 'adminview.php';
            }
        }
        else {
            $feedback.text("fuck you").show().fadeOut(2000);
        }
        return false;
    });

    //activate components on form
    $date = $('input[type="date"][name^="firstdose"], input[type="date"][name^="seconddose"],input[type="date"][name^="booster"]');
    $date.on('change', activateAndReq);

    function activateAndReq() {
        $activate = $($(this).data('activate'));
        $req = $($(this).data('required'));
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