$(function () {

    function $_GETValue() {
        var $_GET = {};

        document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {
            function decode(s) {
                return decodeURIComponent(s.split("+").join(" "));
            }

            $_GET[decode(arguments[1])] = decode(arguments[2]);
        });
        return $_GET;
    }

    //caches selected tab before the page reload and shows the tab on reload
    $('a[data-bs-toggle="tab"]').on('show.bs.tab', function (e) {
        localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('activeTab');
    if (activeTab) {
        $('#tableTab a[href="' + activeTab + '"]').tab('show');
    }

    //login magic
    $signUpButton = $('#signUpStudent, #signUpFaculty, button[name^="back"]')
    $signUpButton.on('click', hideAndShow);
    //manual activation of link on view
    $('#sidebar a').on('click', function () {
        hideAndShow.call(this);
        $(this).parent().find('a').addClass('active');
        $(this).parent().siblings('li').find('a').removeClass('active');
    });

    //activate input
    $('#edit').on('click', function () {
        var $_GET = $_GETValue();
        var activate = 8;
        if (/^[0-9]{1,2}-[0-9]{6,6}$/.test($_GET['id'])) {
            activate = 10;
        }
        $('input, select').each(function (index) {
            if (index < activate) {
                $(this).removeAttr('disabled');
            } else if ($(this).val()) {
                $(this).removeAttr('disabled');
            } else {
                $(this).removeAttr('disabled');
                return false;
            }
        });

        if ($('input[name="firstdose"]').val()) {
            $('select[name="vacbrand"]').removeAttr('disabled');
        }
        if ($('input[name="booster"]').val()) {
            $('select[name="boosterbrand"]').removeAttr('disabled');
        }
        hideAndShow.call(this);
    });

    $('#save').on('click', function () {
        $('#accountInfo').trigger('submit');
        $('input[type!="file"], select').prop('disabled', true);
        hideAndShow.call(this);
    });

    //cancel
    $('#cancel').on('click', function () {
        $('input[type!="file"], input[type!="password"], input[type="email"]:last, select').prop('disabled', true);
        hideAndShow.call(this);
    });

    function hideAndShow() {
        //hides and shows div what do you expect?
        $($(this).data('hide')).hide();
        $($(this).data('show')).show();
    }

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

    $('form[id!="login"][id!="upload"]').on('submit', function (e) {
        var validated = 1;
        var formData = [];
        //manual form data get and build but the upside is its ajax and data will be easier to insert in the table
        if (typeof ($(this).data('validation')) != "undefined") {
            //this could impact the response time but honestly idgaf
            var $_GET = $_GETValue();
            var id;

            if ($_GET['id']) {
                id = $_GET['id'];
            }
            if ($(this).parent().find('input[name^="id"]').length) {
                id = $(this).parent().find('input[name^="id"]').val();
            }
            $yearLevel = $($(this).parent().find('select[name^="yearLevel"]'));
            $status = $($(this).parent().find('input[name^="status"]'));
            $email = $($(this).parent().find('input[name^="email"]'));
            $tel = $($(this).parent().find('input[name^="tel"]'));

            switch ($(this).data('validation')) {
                /*     
                student and faculty id should look like this:
                student: XX - XXXXXX
                faculty: FX - XXXXXX
                */
                case 'student':
                    if (!(/^[0-9]{1,2}-[0-9]{6,6}$/.test(id))) {
                        validated = 0;
                        $(this).parent().find('input[name^="id"]').siblings('p').text('Invalid').fadeOut(5000);
                    }
                    break;
                case 'faculty':
                    if (!(/^F[0-9]{1,1}-[0-9]{6,6}$/.test(id))) {
                        validated = 0;
                        $(this).parent().find('input[name^="id"]').siblings('p').text('Invalid').fadeOut(5000);
                    }
                    break;
            }

            formData.push({ name: 'action', value: $(this).data('action') });
            switch ($(this).data('action')) {
                case 'submit':
                    formData.push({ name: 'id', value: id });
                    formData.push({ name: 'password', value: Math.random().toString(36).substring(2, 10) });
                    break;
                case 'update':
                    formData.push({ name: 'condition', value: $(this).data('condition') });
                    formData.push({ name: 'id', value: $(this).parent().find('input[name^="id"]').val() });
                    break;
            }

            formData.push({ name: 'table', value: $(this).data('validation') });
            //name check
            var name = $($(this).parent().find('input[type="text"][name*="name"]')).map(function (index) {
                if (/[a-zA-Z ]$/.test($(this).val().toString())) {
                    return $(this).val();
                }
                else {
                    validated = 0;
                    $(this).siblings('p').text('Invalid').fadeOut(5000);
                }
            }).get().join(':');
            formData.push({ name: 'name', value: name });

            if ($(this).parent().find('input[type="text"][name*="doctor"]').length) {
                //doctor name check
                $($(this).parent().find('input[type="text"][name*="doctor"]')).map(function () {
                    if (/^$|[a-zA-Z ]$/.test($(this).val().toString())) {
                        return $(this).val();
                    }
                    else {
                        validated = 0;
                        $(this).siblings('p').text('Invalid').fadeOut(5000);
                    }
                });
            }

            //status and Year Level check of student
            if ($(this).data('validation') == 'student') {
                if ($yearLevel.length) {
                    formData.push({ name: 'yearLevel', value: $yearLevel.val() });
                }
                formData.push({ name: 'status', value: 'Enrolled' });
                if ($status.length) {
                    formData.push({ name: 'status', value: $status.val() });
                }
            }

            //email
            formData.push({ name: 'email', value: '' });
            if ($email.length) {
                formData.pop();
                formData.push({ name: 'email', value: $email.val() });
            }
            //telephone
            formData.push({ name: 'tel', value: '' });
            if ($tel.length) {
                //tel validation
                if (!(/^09[0-9]{9,9}$/.test($tel.val()))) {
                    validated = 0;
                    $tel.siblings('p').text('invalid').fadeOut(5000);
                }
                formData.pop();
                formData.push({ name: 'tel', value: $tel.val() });
            }

            formData.push({ name: 'gender', value: $(this).parent().find('select[name^="gender"]').val() });
            formData.push({ name: 'birthday', value: $(this).parent().find('input[type="date"][name^="birthday"]').val() });
            formData.push({ name: 'address', value: $(this).parent().find('input[name^="address"]').val() });
            
            var key = ['firstdose', 'firstdoctor', 'seconddose', 'seconddoctor', 'vacbrand', 'booster', 'boosterdoctor', 'boosterbrand'];
            //tf is this shit? could honestly make this shit shorter but who cares
            var selector = ['input[type="date"][name^="firstdose"]', 'input[type="text"][name^="firstdoctor"]', 'input[type="date"][name^="seconddose"]', 'input[type="text"][name^="seconddoctor"]', 'select[name^="vacbrand"]', 'input[type="date"][name^="booster"]', 'input[type="text"][name^="boosterdoctor"]', 'select[name^="boosterbrand"]']
            for (i = 0; i < 8; i++) {
                $find = $(this).parent().find(selector[i]);
                formData.push({ name: key[i], value: '' });
                if ($find.length) {
                    if ($find.val()) {
                        formData.pop();
                        formData.push({ name: key[i], value: $find.val() });
                    }
                }
            }

            console.log(formData);
            if (validated == 1) {
                $.post('conn.php', formData).done(function (response) {
                    console.log(response);
                }).fail(function (response) {
                    console.log(response);

                });
            }
            e.preventDefault();
        }
        else if ($(this).data('action') == 'changePass') {
            formData.push({ name: 'action', value: $(this).data('action') });
            $id = $(this).parent().find('input[name="id"]');
            $pass = $(this).parent().find('input[name="password"]');
            $confirmPass = $(this).parent().find('input[name="confirmPassword"]');
            formData.push({ name: 'id', value: $id.val() });
            formData.push({ name: 'password', value: $confirmPass.val() });
            if (!(/^[0-9]{1,2}-[0-9]{6,6}$|^F[0-9]{1,1}-[0-9]{6,6}$/.test($id.val()))) {
                console.log($id.val())
                $id.siblings('p:first').text('Invalid ID');
                validated = 0;
            }
            else {
                $.post('conn.php', { id: $id.val(), check: 'id' }).done(function (response) {
                    $id.siblings('p:first').text(response);
                });
            }

            console.log($pass.val());
            console.log($confirmPass.val());
            if ($pass.val() != $confirmPass.val()) {
                validated = 0;
                $confirmPass.siblings('p:last').text('Password does not match');
            }

            if (validated != 0) {
                $.post('conn.php', formData).done(function (response) {
                    console.log(response);
                });
            }
            e.preventDefault();
        }
        else {
            formData = $(this).serializeArray();
            formData.push({ name: 'action', value: $(this).data('action') });
            if ($(this).data('action') == 'report') {
                var table = 5;
                $(this).parent().find('select').each(function () {
                    if ($(this).val() == '') {
                        table--;
                    }
                });
                formData.push({ name: 'table', value: '' });
                console.log('table:' + table);
                if (table != 0) {
                    formData.pop();
                    formData.push({ name: 'table', value: 'needed' });
                }

                formData.push({ name: 'student', value: '' });
                if ($(this).parent().find('select[name="yearLevel"]').val() != '' ||
                    $(this).parent().find('select[name="vacbrand[0]"]').val() != '' ||
                    $(this).parent().find('select[name="boosterbrand[0]"]').val() != '') {
                    formData.pop();
                    formData.push({ name: 'student', value: 'table' });
                }
                formData.push({ name: 'faculty', value: '' });
                if ($(this).parent().find('select[name="vacbrand[1]"]').val() != '' ||
                    $(this).parent().find('select[name="boosterbrand[1]"]').val() != '') {
                    formData.pop();
                    formData.push({ name: 'faculty', value: 'table' });
                }
            }
            if (!($(this).parent().find('input[type="hidden"][name="table"]')).length && $(this).data('action') != 'report') {
                formData.push({ name: 'table', value: $(this).data('table') });
            }
            console.log(formData);
            $.post('conn.php', formData);
            e.preventDefault();
        }
    });

    //login ajax
    $('form[id="login"]').on('submit', function (e) {

        $feedback = $($(this).parent().find('div[name="loginFeedback"]'));
        var id = $('input[name="id[0]"]').val();
        var password = $('input[name="password[0]"]').val();
        if (/^[0-9]{1,2}-[0-9]{6,6}$|^F[0-9]{1,1}-[0-9]{6,6}$/.test(id)) {
            //handles the redirecting and feedback
            $feedback.load('conn.php', {
                type: '1',
                id: id,
                password: password
            });
        }
        else if (/admin/.test(id)) {
            //redirect to admin
            if ($('input[name^="password"]').val() == 'admin') {
                location.href = 'adminview.php';
            }
        }
        else {
            $feedback.text('Please enter a valid ID');
        }
        e.preventDefault();
    });

    //image upload AJAX
    $('form[id="upload"]').on('submit', function (e) {
        $fileInput = $('input[name="vaccinationCard"]');
        var $_GET = $_GETValue();
        var id = $_GET['id'];
        var url = 'conn.php?id=' + id;
        var fd = new FormData();
        fd.append('vaccinationCard', $('input[name="vaccinationCard"]').prop('files')[0]);
        $.ajax({
            url: url,
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: fd,
            type: 'post',
            success: function (response) {
                $fileInput.siblings('p').text(response);
            }
        });
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