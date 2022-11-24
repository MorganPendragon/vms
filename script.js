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
    $signUpButton = $('#signUpStudent, #signUpFaculty, button[name^="back"]')
    $signUpButton.on('click', hideAndShow);
    //manual activation of link on view
    $('#sidebar a').on('click', function () {
        hideAndShow.call(this);
        $(this).parent().find('a').addClass('active');
        $(this).parent().siblings('li').find('a').removeClass('active');
    });

    $('#edit').on('click', function () {
        $('input, select').each(function (index) {
            $('#save, #cancel').show();
            if (index < 10) {
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

    $('#cancel').on('click', function () {
        $('#save, #cancel').hide();
        $('input[type!="file"], select').each(function () {
            $(this).attr('disabled', 'disabled');
        });
        hideAndShow.call(this);
    });

    //brand populate select
    if ($('select[name*="brand"], select[id*="brand"]').length) {
        $.ajax({
            url: 'conn.php',
            type: "POST",
            dataType: 'json',
            data: ({
                tableName: 'vacbrand',
                column: 'brand'
            }),
            success: function (data) {
                var option = '';
                console.log(data);
                $.each(data, function (index, value) {
                    option += '<option value="' + value.brand + '">' + value.brand + '</option>';
                });
                $('select[name*="brand"]').append(option);
            }
        });
    }

    function hideAndShow() {
        //hides and shows div what do you expect?
        $($(this).data('hide')).hide();
        console.log('hide:' + $(this).data('hide'));
        $($(this).data('show')).show();
        console.log('show:' + $(this).data('show'));
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
            $id = $($(this).parent().find('input[name^="id"]'));
            $yearLevel = $($(this).parent().find('select[name^="yearLevel"]'));
            $status = $($(this).parent().find('input[name^="status"]'));
            $fullName = $($(this).parent().find('input[name="fullName"]'));
            $email = $($(this).parent().find('input[name^="email"]'));
            $tel = $($(this).parent().find('input[name^="tel"]'));

            switch ($(this).data('validation')) {
                /*     
                student and faculty id should look like this:
                student: XX - XXXXXX
                faculty: FX - XXXXXX
                */
                case 'student':
                    if (!(/^[0-9]{1,2}-[0-9]{6,6}$/.test($id.val()))) {
                        validated = 0;
                        $id.siblings('p').text('Invalid').fadeOut(5000);
                    }
                    break;
                case 'faculty':
                    if (!(/^F[0-9]{1,1}-[0-9]{6,6}$/.test($id.val()))) {
                        validated = 0;
                        $id.siblings('p').text('Invalid').fadeOut(5000);
                    }
                    break;
            }

            switch ($(this).data('action')) {
                case 'submit':
                    formData.push({ name: 'action', value: 'submit' });
                    formData.push({ name: 'id', value: $id.val() });
                    formData.push({ name: 'password', value: Math.random().toString(36).substring(2, 10) });
                    break;
                case 'update':
                    break;
                case 'delete':
                    break;
            }

            formData.push({ name: 'table', value: $(this).data('validation') });
            //name check
            if ($fullName.length) {

            }
            else {

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
            }

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
                    $('#feedbackMessage').text('Inserted Successfully');
                    $('#feedbackModal').modal('show');
                }).fail(function (response) {
                    $('#feedbackMessage').text('Unsuccessfully Insert in the Database');
                    $('#feedbackModal').modal('show');

                });
            }
            e.preventDefault();
        }
    });

    //form validation
    /*     $('form[id!="login"][id!="upload"]').on('submit', function (e) {
            if (typeof ($(this).data('validation')) != 'undefined') {
                var validated = 1;
                $password = $($(this).parent().find('input[type="hidden"][name^="password"]'));
                $id = $($(this).parent().find('input[type="text"][name^="id"]'))
                if($password.length)
                {
                    $password.val(Math.random().toString(36).substring(2, 10));
                }
                    student and faculty id should look like this:
                    student:XX-XXXXXX
                    faculty:FX-XXXXXX
                switch($(this).data('validation'))
                {
                    case 1:
                        if (!(/^[0-9]{1,2}-[0-9]{6,6}$/.test($id.val()))) {
                            validated = 0;
                            $id.siblings('p').text('Invalid').fadeOut(5000);
                        }
                        break;
                    case 2:
                        if (!(/^F[0-9]{1,1}-[0-9]{6,6}$/.test($id.val()))) {
                            validated = 0;
                            $id.siblings('p').text('Invalid').fadeOut(5000);
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
                }).get().join(':');
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
        }); */

    //login ajax
    $('form[id="login"]').on('submit', function (e) {

        $feedback = $($(this).parent().find('div[name="loginFeedback"]'));
        var id = $('input[name="id[0]"]').val().toString();
        var password = $('input[name="password[0]"]').val().toString();
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
            if ($('input[name^="password"]').val().toString() == 'admin') {
                location.href = 'adminview.php';
            }
        }
        else {
            $feedback.text('Please enter a valid ID');
        }
        return false;
    });

    //image upload AJAX
    $('form[id="upload"]').on('submit', function (e) {
        $fileInput = $('input[name="vaccinationCard"]');
        var $_GET = {};

        document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {
            function decode(s) {
                return decodeURIComponent(s.split("+").join(" "));
            }

            $_GET[decode(arguments[1])] = decode(arguments[2]);
        });
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