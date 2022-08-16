<script>
    $(document).ready(function() {
        // sessionSelect2
        // termSelect2
        // categorySelect2
        // classSelect2
        // armSelect2
        // teacherSelect2
        // assign class to staff 

        // general dropdown 


        // assign class to staff 
        multiSelect2('.sessionSelect2', 'createArmTeacherModal', 'session', 'Select Session');
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


        // subject class arm subject teacher 
        $('#createArmSubjectTeacherBtn').click(function() {
            var route = "{{route('school.staff.subject')}}";
            submitFormAjax('createArmSubjectTeacherForm', 'createArmSubjectTeacherBtn', route);
        });
    })

    function FormMultiSelect2(idOrClass, route, plh) {
        var url = "{{route('load.available.dropdown')}}";
        $(idOrClass).select2({
            placeholder: plh,
            width: "100%",
            allowClear: true,
            ajax: {
                url: url + route,
                dataType: 'json',
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
    }

    function FormMultiSelect2Post(idOrClass, route, pid, plh) {
        var url = "{{route('load.available.dropdown')}}";
        var token = $("input[name='_token']").val();
        $(idOrClass).select2({
            placeholder: plh,
            // dropdownParent: $('#' + modal),
            width: "100%",
            allowClear: true,
            ajax: {
                url: url + route,
                dataType: 'json',
                data: {
                    pid: pid,
                    _token: token
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
        });
    }


    function multiSelect2(idOrClass, modal, route, plh) {
        var url = "{{route('load.available.dropdown')}}";
        $(idOrClass).select2({
            placeholder: plh,
            dropdownParent: $('#' + modal),
            width: "100%",
            allowClear: true,
            ajax: {
                url: url + route,
                dataType: 'json',
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
    }

    function multiSelect2Post(idOrClass, modal, route, pid, plh) {
        var url = "{{route('load.available.dropdown')}}";
        var token = $("input[name='_token']").val();
        $(idOrClass).select2({
            placeholder: plh,
            dropdownParent: $('#' + modal),
            width: "100%",
            allowClear: true,
            ajax: {
                url: url + route,
                dataType: 'json',
                data: {
                    pid: pid,
                    _token: token
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
        });
    }

    function successClearForm(formId, msg) {
        jQuery('.select2-offscreen').select2('val', '');
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
        setTimeout(function(){
            $('#quickFlash').hide();
        },time * 1000);
    }
</script>