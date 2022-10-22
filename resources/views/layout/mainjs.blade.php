<script>
    $(document).ready(function() {

        // switch from table to card 
        if ($(window).width() < 760) {
            let tableId = $('.table').attr('id');
            if ($(".table").hasClass("card-able")) {
                $(".colHeader").remove();
            } else {
                var labels = [];
                $(".table thead th").each(function() {
                    labels.push($(this).text());
                });
                $(".table tbody tr").each(function() {
                    $(this)
                        .find("td")
                        .each(function(column) {
                            $("<span class='colHeader'>" + labels[column] + ":</span>").prependTo(
                                $(this)
                            );
                        });
                });
            }
            $(".table").toggleClass("card-able");
            $('tfoot').hide();
        }
        // assign class to staff 

        // general dropdown 
        // load passport in create parent modal  

        $('.passport').change(function() {
            previewImg(this, '#parentPassport');
        });
        $('#accessSelect2').select2({
            placeholder: 'plh',
            dropdownParent: $('.accessModal'),
            width: "100%",
            allowClear: true,
        });
        // update images from modal 
        // $(document).on('change', '.previewImg',function() {
        //     let id = $(this).attr('id');
        //     alert(id)
        //     previewImg(this, '#' + id);
        // });

        // update images  from modal 
        $(document).on('click', '.updateStaffImage', function() {
            let id = $(this).attr('id');
            var route = "{{route('update.staff.image')}}";
            submitFormAjax('form' + id, 'id', route);
        });
        // update staff role  
        $(document).on('click', '.updateStaffRole', function() {
            let id = $(this).attr('id');
            var route = "{{route('update.staff.role')}}";
            submitFormAjax('roleform' + id, 'id', route);
        });
        // update status account status
        $(document).on('click', '.toggleStaffStatus', function() {
            let pid = $(this).attr('pid');
            var url = "update-staff-status/" + pid;
            $('.overlay').show();
            $.ajax({
                url: url, //"{{route('create.school.score.settings')}}",
                success: function(data) {
                    console.log(data);
                    $('.overlay').hide();
                    if (data == 'staff Account updated') {
                        alert_toast(data, 'success');
                    } else {
                        alert_toast(data, 'error');
                    }
                },
                error: function() {
                    $('.overlay').hide();
                    alert_toast('Something Went Wrong', 'error');
                }
            });
        });
        // update staff role 
        $(document).on('change', '#roleSelect2', function() {
            let role = $(this).val();
            if (role == 200) {
                Swal.fire({
                    icon: 'info',
                    title: 'Super Admin',
                    text: 'Super Admin Role is the only person that can edit school details like name, logo etc & and they can only be one super admin',
                    footer: '<b class="text-danger">So whoever you choose overrides, the existing 1<b>'
                })
            } else if (role == 205) {
                Swal.fire({
                    icon: 'info',
                    title: 'School Admin',
                    text: 'School Admin Role is the person that control the activities of other staff/users of the school',
                    footer: '<b class="text-danger">Like creating accounts and setting standard<b>'
                })
            }
        });

        // update student status 
        $(document).on('click', '.toggleStudentStatus', function() {
            let pid = $(this).attr('pid');
            var url = "update-student-status/" + pid;
            $('.overlay').show();
            $.ajax({
                url: url, //"{{route('create.school.score.settings')}}",
                success: function(data) {
                    console.log(data);
                    $('.overlay').hide();
                    if (data == 'Student Account Updated') {
                        alert_toast(data, 'success');
                    } else {
                        alert_toast(data, 'error');
                    }
                },
                error: function() {
                    $('.overlay').hide();
                    alert_toast('Something Went Wrong', 'error');
                }
            });
        });
        // update password 
        $('#updatePwdBtn').click(function() {
            var route = "{{route('update.password')}}";
            submitFormAjax('updatePwdForm', 'updatePwdBtn', route);
        });



        // link portal to hostel 
        multiSelect2('#ahtpSessionSelect2', 'assignHostelToPortalModal', 'session', 'Select Session');
        multiSelect2('#ahtpTermSelect2', 'assignHostelToPortalModal', 'term', 'Select Term');
        multiSelect2('#ahtpPortalSelect2', 'assignHostelToPortalModal', 'portals', 'Select Portals');
        multiSelect2('#ahtpHostelSelect2', 'assignHostelToPortalModal', 'hostels', 'Select Hostels');
        // assign student portal 
        multiSelect2('#ahtsStudentSelect2', 'assignHostelToStudentModal', 'boarding-student', 'Select Student');
        multiSelect2('#ahtsHostelSelect2', 'assignHostelToStudentModal', 'hostels', 'Select Hostels');

        $('#assignHostelToPortalBtn').click(function() {
            var route = "{{route('assign.hostel.to.portal')}}";
            submitFormAjax('assignHostelToPortalForm', 'assignHostelToPortalBtn', route);
        });

        // assign student hostel 
        $('#assignHostelToStudentBtn').click(function() {
            var route = "{{route('assign.hostel.to.student')}}";
            submitFormAjax('assignHostelToStudentForm', 'assignHostelToStudentBtn', route);
        });

        // link stunden from parent dynamic 
        multiSelect2('#lmToParentstudentSelect2', 'linkMyWardsModal', 'student', 'Select student');
        $(document).on('click', '.linkMyWards', function() {
            let pid = $(this).attr('pid')
            $('#linkMyWardsPid').val(pid);
            $('#linkMyWardsModal').modal('show');
        })
        // link student to parent 
        $('#linkStudentParentDynamicBtn').click(function() {
            var route = "{{route('link.student.parent')}}";
            submitFormAjax('linkStudentParentDynamicForm', 'linkStudentParentDynamicBtn', route);
        });
        // from student side 
        // link parent from student dynamic 
        multiSelect2('#lpToParentparentSelect2', 'linkMyParentModal', 'parent', 'Select Parent');
        $(document).on('click', '.linkMyParent', function() {
            let pid = $(this).attr('pid')
            $('#lpStudentpid').val(pid);
            $('#linkMyParentModal').modal('show');
        })

        $('#linkParentDynamicBtn').click(function() {
            var route = "{{route('link.student.parent')}}";
            submitFormAjax('linkParentDynamicForm', 'linkParentDynamicBtn', route);
        });

        // load students 
        multiSelect2('#studentToParentstudentSelect2', 'linkStudentParentModal', 'student', 'Select student');
        // load students 
        multiSelect2('#studentToParentparentSelect2', 'linkStudentParentModal', 'parent', 'Select Parent/Guardian');

        // linkStudentParentForm
        // linkStudentParentBtn
        $('#linkStudentParentBtn').click(function() {
            var route = "{{route('link.student.parent')}}";
            submitFormAjax('linkStudentParentForm', 'linkStudentParentBtn', route);
        });

        // assign class to staff 
        multiSelect2('.sessionSelect2', 'assignClassArmTeacherModal', 'session', 'Select Session');
        // load state on modal 
        multiSelect2('#parentStateSelect2', 'createParentOnStudentFormMadal', 'state', 'Select State');

        $('#parentStateSelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#parentLgaSelect2', 'createParentOnStudentFormMadal', 'state-lga', id, 'Select lga of origin');
        });

        multiSelect2('.termSelect2', 'assignClassArmTeacherModal', 'term', 'Select Term');
        multiSelect2('.categorySelect2', 'assignClassArmTeacherModal', 'category', 'Select Category');
        $('.categorySelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('.classSelect2', 'assignClassArmTeacherModal', 'class', id, 'Select Class');
        });
        $('.classSelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('.armSelect2', 'assignClassArmTeacherModal', 'class-arm', id, 'Select Class Arm');
        });
        multiSelect2('.teacherSelect2', 'assignClassArmTeacherModal', 'school-teachers', 'Select Class Teacher');
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
        // choose class rep  
        multiSelect2('#ccarSessionSelect2', 'assignArmToRepModal', 'session', 'Select Session');
        multiSelect2('#ccarTermSelect2', 'assignArmToRepModal', 'term', 'Select Term');
        multiSelect2('#ccarCategorySelect2', 'assignArmToRepModal', 'category', 'Select Category');
        $('#ccarCategorySelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#ccarClassSelect2', 'assignArmToRepModal', 'class', id, 'Select Class');
        });
        $('#ccarClassSelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#ccarArmSelect2', 'assignArmToRepModal', 'class-arm', id, 'Select Class Arm');
        });
        $('#ccarArmSelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#ccarStudentSelect2', 'assignArmToRepModal', 'class-arm-student', id, 'Select Class Student');
        });

        // link rider to student  
        multiSelect2('#lstcrStudentSelect2', 'linkStudentToRiderModal', 'student', 'Select Student');
        multiSelect2('#lstcrRiderSelect2', 'linkStudentToRiderModal', 'rider', 'Select Care/Rider');
        //link rider to student
        $('#linkStudentToRiderBtn').click(function() {
            var route = "{{route('link.student.to.rider')}}";
            submitFormAjax('linkStudentToRiderForm', 'linkStudentToRiderBtn', route);
        });
        // assignClassArmTeacherModal
        //  class arm rep 
        $('#assignArmToRepBtn').click(function() {
            var route = "{{route('assign.class.arm.rep')}}";
            submitFormAjax('assignArmToRepForm', 'assignArmToRepBtn', route);
        });
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


        // load user account details  
        $('#updateAccount').click(function() {
            $.ajax({
                url: "{{route('load.user.detail')}}",
                dataType: "json",
                beforeSend: function() {
                    $('.overlay').show();
                },
                success: function(data) {
                    console.log(data);
                    $('.overlay').hide();
                    if (data) {
                        $('#updateAccountFirstname').val(data.firstname);
                        $('#updateAccountLastname').val(data.lastname);
                        $('#updateAccountOthername').val(data.othername);
                        $('#updateAccountDOB').val(data.dob);
                        $('#updateAccountGender').val(data.gender).trigger('change');
                        $('#updateAccountReligion').val(data.religion).trigger('change');
                        $('#updateAccountAddress').val(data.address);
                        $('#updateAccountAbout').val(data.about);
                    }
                },
                error: function() {
                    $('.overlay').hide();
                }
            });
            $('#updateAccountModal').modal('show');
        })
        $('#updateAccountBtn').click(function() {
            var route = "{{route('update.user.detail')}}";
            submitFormAjax('updateAccountForm', 'updateAccountBtn', route);
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
        if (pid != null) {
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
        if (pid != null) {
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
        return new Promise((resolve, reject) => {

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
                        $.each(data.error, function(prefix, val) {
                            let prfx = prefix.replace(".", "");
                            $('.' + prfx + '_error').text(val[0]);
                        });
                        resolve(null)
                    } else if (data.status === 1) {
                        successClearForm(formId, data.message)
                        alert_toast(data.message, 'success');
                        $('#' + formId)[0].reset();
                        if (data.code) {
                            resolve(data.code)
                        } else {
                            resolve(data.message)
                        }
                    } else {
                        alert_toast(data.message, 'error');
                        resolve(data.message)
                    }
                },
                error: function(data) {
                    $('#' + btnId).prop('disabled', false);
                    $('.overlay').hide();
                    alert_toast('Something Went Wrong', 'error');
                    reject(true);
                }
            });
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
                $(baseId).attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>