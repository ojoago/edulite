<script>
    $(document).ready(function() {

        // assign class to staff 

        // general dropdown 
        // load passport in create parent modal  

        $('.passport').change(function() {
            previewImg(this, '#parentPassport');
        });

        // link student to parent 
        // load students 
        multiSelect2('#studentToParentstudentSelect2', 'linkStudentParentModal', 'student', 'Select student');
        // load students 
        multiSelect2('#studentToParentparentSelect2', 'linkStudentParentModal', 'parent', 'Select Parent/Guardian');

        // linkStudentParentForm
        // linkStudentParentBtn
        // subject class arm subject teacher 
        $('#linkStudentParentBtn').click(function() {
            var route = "{{route('link.student.parent')}}";
            submitFormAjax('linkStudentParentForm', 'linkStudentParentBtn', route);
        });
        // assign class to staff 
        multiSelect2('.sessionSelect2', 'createArmTeacherModal', 'session', 'Select Session');
        // load state on modal 
        multiSelect2('#parentStateSelect2', 'createParentOnStudentFormMadal', 'state', 'Select State');

        $('#parentStateSelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#parentLgaSelect2', 'createParentOnStudentFormMadal', 'state-lga', id, 'Select lga of origin');
        });

        multiSelect2('.termSelect2', 'createArmTeacherModal', 'term', 'Select Term');
        multiSelect2('.categorySelect2', 'createArmTeacherModal', 'category', 'Select Category');
        $('.categorySelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('.classSelect2', 'createArmTeacherModal', 'class', id, 'Select Class');
        });
        $('.classSelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('.armSelect2', 'createArmTeacherModal', 'class-arm', id, 'Select Class Arm');
        });
        multiSelect2('.teacherSelect2', 'createArmTeacherModal', 'school-teachers', 'Select Class Teacher');
        // assign class subject to staff
        multiSelect2('#sessionSelect2s', 'createArmSubjectTeacherModal', 'session', 'Select Session');
        multiSelect2('#termSelect2s', 'createArmSubjectTeacherModal', 'term', 'Select Term');
        multiSelect2('#categorySelect2s', 'createArmSubjectTeacherModal', 'category', 'Select Category');
        $('#categorySelect2s').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#classSelect2s', 'createArmSubjectTeacherModal', 'class', id, 'Select Class');
        });
        $('#classSelect2s').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#armSelect2s', 'createArmSubjectTeacherModal', 'class-arm', id, 'Select Class Arm');
        });
        $('#armSelect2s').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#subjectSelect2s', 'createArmSubjectTeacherModal', 'class-arm-subject', id, 'Select Class Subject');
        });
        multiSelect2('#teacherSelect2s', 'createArmSubjectTeacherModal', 'school-teachers', 'Select Class Teacher');
        // assign class to staff
        multiSelect2('.sessionSelect2s', 'assignArmToRepModal', 'session', 'Select Session');
        multiSelect2('.termSelect2s', 'assignArmToRepModal', 'term', 'Select Term');
        multiSelect2('.categorySelect2s', 'assignArmToRepModal', 'category', 'Select Category');
        $('.categorySelect2s').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('.classSelect2s', 'assignArmToRepModal', 'class', id, 'Select Class');
        });
        $('.classSelect2s').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('.armSelect2s', 'assignArmToRepModal', 'class-arm', id, 'Select Class Arm');
        });
        $('armSelect2s').on('change', function(e) {
            var id = $(this).val();
            multiSelect2('#studentSelect2s', 'assignArmToRepModal', 'class-arm-student', 'Select Class Student');
        });

        // createArmTeacherModal
        // 
        // 
        // subject class arm subject teacher 
        $('#createArmSubjectBtn').click(function() {
            var route = "{{route('school.staff.class')}}";
            submitFormAjax('createArmTeacherForm', 'createArmSubjectBtn', route);
        });
        // subject class arm subject teacher 
        $('#createArmSubjectTeacherBtn').click(function() {
            var route = "{{route('school.staff.subject')}}";
            submitFormAjax('createArmSubjectTeacherForm', 'createArmSubjectTeacherBtn', route);
        });
        // register parent 
        $('#createParentBtn').click(function() {
            var route = "{{route('school.register.parent')}}";
            submitFormAjax('createParentForm', 'createParentBtn', route);
        });

        // search staff 
        $('#searchExistingStaff').change(function() {
            var key = $(this).val().replace('/', '@__@')
            if (key != '') {
                let route = "{{url('find-existing-user')}}";
                $('.overlay').show();
                $.ajax({
                    url: route + '/' + key,
                    success: function(data) {
                        // console.log(data);
                        $('#staffDetails').html(data)
                        $('.overlay').hide();
                    }
                });
            } else {
                showTipMessage('Enter Staff details');
            }
        });
        // link student 
        $(document).on('click', '#linkUserToSchoolStaff', function() {
            let pid = $(this).attr('pid');
            let token = "{{csrf_token()}}"
            let role = $('#staffRole').val();
            $('.overlay').show();
            if (role != null) {
                $.ajax({
                    url: "{{route('link.existing.staff')}}",
                    data: {
                        pid: pid,
                        _token: token,
                        role: role
                    },
                    beforeSend: function() {
                        $('.overlay').show();
                        $(this).prop('disabled', true);
                    },
                    success: function(data) {
                        console.log(data);
                        $(this).prop('disabled', false);
                        var newData = '<h3 class="text-info">' + data + '</h3>';
                        $('#staffDetails').html(newData)
                        $('#searchExistingStaff').val('');
                        alert_toast('success', 'success');
                        $('.overlay').hide();
                    },
                    error: function(data) {
                        $(this).prop('disabled', false);
                        $('.overlay').hide();
                        alert_toast('Something Went Wrong', 'error');
                    }
                });
            } else {
                $('.overlay').hide();
                alert_toast('Select Role', 'warning');
            }

        });
        // search student 
        $('#searchExistingStudent').change(function() {
            var key = $(this).val().replace('/', '@__@')
            if (key != '') {
                let route = "{{url('find-existing-student')}}";
                $('.overlay').show();
                $.ajax({
                    url: route + '/' + key,
                    success: function(data) {
                        // console.log(data);
                        $('#studentDetails').html(data)
                        // load all class arm on modal 
                        multiSelect2('#allArmSelect2', 'addStudentModal', 'all-class-arm', 'Select Class');
                        $('.overlay').hide();
                    },
                    error: function(data) {
                        $(this).prop('disabled', false);
                        $('.overlay').hide();
                        alert_toast('Something Went Wrong', 'error');
                    }
                });
            } else {
                showTipMessage('Enter Student details');
            }
        });


        // link student 
        $(document).on('click', '#linkStudentToSchool', function() {
            let pid = $(this).attr('pid');
            let type = $('#stdType').val();
            let arm = $('#allArmSelect2').val();
            let token = "{{csrf_token()}}"
            if (arm != null) {
                $('.overlay').show();
                $.ajax({
                    url: "{{route('link.existing.student')}}",
                    data: {
                        pid: pid,
                        _token: token,
                        type: type,
                        arm: arm
                    },
                    beforeSend: function() {
                        $('.overlay').show();
                        $(this).prop('disabled', true);
                    },
                    success: function(data) {
                        console.log(data);
                        $(this).prop('disabled', false);
                        var newData = '<h4>' + data + '</h4>';
                        $('#studentDetails').html(newData)
                        $('#searchExistingStudent').val('');
                        alert_toast('success', 'success');
                        $('.overlay').hide();
                    },
                    error: function(data) {
                        $(this).prop('disabled', false);
                        $('.overlay').hide();
                        alert_toast('Something Went Wrong', 'error');
                    }
                });
            } else {
                alert_toast('Select Student new class', 'warning');
            }


        });
        // search parent 
        $('#searchExistingParent').change(function() {
            var key = $(this).val().replace('/', '@__@')
            if (key != '') {
                let route = "{{url('find-existing-parent')}}";
                $('.overlay').show();
                $.ajax({
                    url: route + '/' + key,
                    success: function(data) {
                        // console.log(data);
                        $('#parentDetails').html(data)
                        $('.overlay').hide();
                    },
                    error: function(data) {
                        $(this).prop('disabled', false);
                        $('.overlay').hide();
                        alert_toast('Something Went Wrong', 'error');
                    }
                });
            } else {
                showTipMessage('Enter parent details');
            }
        });

        // link student 
        $(document).on('click', '#linkUserToSchoolParent', function() {
            let pid = $(this).attr('pid');
            let token = "{{csrf_token()}}";
            alert(pid);
            $('.overlay').show();
            $.ajax({
                url: "{{route('link.existing.parent')}}",
                data: {
                    pid: pid,
                    _token: token,
                },
                beforeSend: function() {
                    $('.overlay').show();
                    $(this).prop('disabled', true);
                },
                success: function(data) {
                    console.log(data);
                    $(this).prop('disabled', false);
                    var newData = '<h4>' + data + '</h4>';
                    $('#parentDetails').html(newData)
                    $('#searchExistingParent').val('');
                    alert_toast('success', 'success');
                    $('.overlay').hide();
                },
                error: function(data) {
                    $(this).prop('disabled', false);
                    $('.overlay').hide();
                    alert_toast('Something Went Wrong', 'error');
                }
            });

        });
        // search parent 
        $('#searchExistingRider').change(function() {
            var key = $(this).val().replace('/', '@__@')
            if (key != '') {
                let route = "{{url('find-existing-rider')}}";
                $('.overlay').show();
                $.ajax({
                    url: route + '/' + key,
                    success: function(data) {
                        // console.log(data);
                        $('#riderDetails').html(data)
                        $('.overlay').hide();
                    },
                    error: function(data) {
                        $(this).prop('disabled', false);
                        $('.overlay').hide();
                        alert_toast('Something Went Wrong', 'error');
                    }
                });
            } else {
                showTipMessage('Enter Parent details');
            }
        });

        // link student 
        $(document).on('click', '#linkUserToSchoolRider', function() {
            let pid = $(this).attr('pid');
            let token = "{{csrf_token()}}";
            $('.overlay').show();
            $.ajax({
                url: "{{route('link.existing.rider')}}",
                data: {
                    pid: pid,
                    _token: token,
                },
                beforeSend: function() {
                    $('.overlay').show();
                    $(this).prop('disabled', true);
                },
                success: function(data) {
                    console.log(data);
                    $(this).prop('disabled', false);
                    var newData = '<h4>' + data + '</h4>';
                    $('#riderDetails').html(newData)
                    $('#searchExistingRider').val('');
                    alert_toast('success', 'success');
                    $('.overlay').hide();
                },
                error: function(data) {
                    $(this).prop('disabled', false);
                    $('.overlay').hide();
                    alert_toast('Something Went Wrong', 'error');
                }
            });

        });


    })

    function FormMultiSelect2(idOrClass, route, plh, pre = null) {
        let pid = null
        var url = "{{route('load.available.dropdown')}}";
        var token = $("input[name='_token']").val();
        $(idOrClass).addClass('select2');
        $(idOrClass).select2({
            placeholder: plh,
            width: "100%",
            allowClear: true,
            ajax: {
                url: url + route,
                dataType: 'json',
                type: "post",
                delay: 250,
                data: function(params) {
                    return {
                        pid: pid,
                        _token: token,
                        q: params.term,
                        page_limit: 10
                    }
                },
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        }).val(pre).trigger('change').trigger('focus');
    }


    // multiple select  default

    // var unselected = li.find('option:not(:selected)');
    // var selected = [];
    // for (var i = 0; i < unselected.length; i++) {
    //     selected[i] = {
    //         id: unselected[i].value,
    //         text: unselected[i].text
    //     };
    // }
    // li.select2('data', selected);


    function FormMultiSelect2Post(idOrClass, route, pid, plh, pre = null) {
        var url = "{{route('load.available.dropdown')}}";
        var token = $("input[name='_token']").val();
        $(idOrClass).addClass('select2');
        $(idOrClass).select2({
            placeholder: plh,
            // dropdownParent: $('#' + modal),
            width: "100%",
            allowClear: true,
            ajax: {
                url: url + route,
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        pid: pid,
                        _token: token,
                        q: params.term,
                        page_limit: 10
                    }
                },
                type: "POST",
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        }).val(pre).trigger('change').trigger('focus');
    }


    function multiSelect2(idOrClass, modal, route, plh, pre = null) {
        let pid = null;
        var token = $("input[name='_token']").val();
        var url = "{{route('load.available.dropdown')}}";
        $(idOrClass).addClass('select2');
        $(idOrClass).select2({
            placeholder: plh,
            dropdownParent: $('#' + modal),
            width: "100%",
            allowClear: true,
            ajax: {
                url: url + route,
                dataType: 'json',
                type: "post",
                delay: 250,
                data: function(params) {
                    return {
                        pid: pid,
                        _token: token,
                        q: params.term,
                        page_limit: 10
                    }
                },
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        }).val(pre).trigger('change').trigger('focus');
    }

    function multiSelect2Post(idOrClass, modal, route, pid, plh, pre = null) {
        var url = "{{route('load.available.dropdown')}}";
        var token = "{{csrf_token()}}";
        $(idOrClass).addClass('select2');
        $(idOrClass).select2({
            placeholder: plh,
            dropdownParent: $('#' + modal),
            width: "100%",
            allowClear: true,
            ajax: {
                url: url + route,
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        pid: pid,
                        _token: token,
                        q: params.term,
                        page_limit: 10
                    }
                },
                type: "POST",
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        }).val(pre).trigger('change').trigger('focus');
    }

    function successClearForm(formId, msg) {
        jQuery('.select2-offscreen').select2('val', '');
        $('.select2').val(null).trigger('change');
        alert_toast(msg, 'success');
        $('#' + formId)[0].reset();
    }

    function submitFormAjax(formId, btnId, route) {
        // create score seeting 
        // $('#createScoreSettingBtn').click(function(e) {
        // e.preventDefault()
        $('.overlay').show();
        $.ajax({
            url: route, //"{{route('create.school.score.settings')}}",
            type: "POST",
            data: new FormData($('#' + formId)[0]),
            dataType: "JSON",
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('#' + formId).find('p.text-danger').text('');
                $('#settingParams').find('p.text-danger').text('');
                $('#' + btnId).prop('disabled', true);
            },
            success: function(data) {
                console.log(data);
                $('#' + btnId).prop('disabled', false);
                $('.overlay').hide();
                if (data.status === 0) {
                    alert_toast('Fill in form correctly', 'warning');
                    $.each(data.error, function(prefix, val) {
                        $('.' + prefix + '_error').text(val[0]);
                    });
                } else if (data.status === 1) {
                    successClearForm(formId, data.message)
                    alert_toast(data.message, 'success');
                    $('#' + formId)[0].reset();

                } else {
                    alert_toast(data.message, 'warning');
                }
            },
            error: function(data) {
                $('#' + btnId).prop('disabled', false);
                $('.overlay').hide();
                alert_toast('Something Went Wrong', 'error');
            }
        });
        // });
    }

    function showTipMessage(data, time = 1) {
        $('#quickFlash').text(data);
        $('#quickFlash').show();
        setTimeout(function() {
            $('#quickFlash').hide();
        }, time * 1000);
    }

    function previewImg(input, baseId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('' + baseId).attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>