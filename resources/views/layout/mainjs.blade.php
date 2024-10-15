<script>
    $(document).ready(function() {

        var idleTime = 0;
        var maxIdleTime = 30 * 60; // 30 minutes in seconds
        // Increment the idle time counter every second.
        var idleInterval = setInterval(timerIncrement, 1000);
        // Reset the idle timer on mouse movement, keypress, or click.
        $(this).mousemove(resetTimer);
        $(this).keypress(resetTimer);
        $(this).click(resetTimer);

        function timerIncrement() {
            idleTime++;
            if (idleTime >= maxIdleTime) {
                    window.location.href = "{{route('logout')}}"; // Redirect to logout page
            }
        }

        function resetTimer() {
            idleTime = 0; // Reset idle time to zero
        }
       

        // prevent typing on input type date
        $("input[type=date]").on('keydown', function() {
            return false;
        })




        $('.attachSelect2').addClass('select2')
        // switch from table to card 
        if ($(window).width() < 760) {
            let tableId = $('.cardTable').attr('id');
            if ($(".cardTable").hasClass("card-able")) {
                $(".colHeader").remove();
            } else {
                var labels = [];
                $(".cardTable thead th").each(function() {
                    labels.push($(this).text());
                });
                $(".cardTable tbody tr").each(function() {
                    $(this)
                        .find("td")
                        .each(function(column) {
                            $("<span class='colHeader'>" + labels[column] + ":</span>").prependTo(
                                $(this)
                            );
                        });
                });
            }
            $(".cardTable").removeClass('table-striped');
            $(".cardTable").toggleClass("card-able");
            $('tfoot').hide();
        }
        // assign class to staff 


        // accept payment start here 
        // compute total fee ticked 
        $(document).on('change', '.invoicePidStatus', function() {
            let total = 0;
            $('.invoicePidStatus').each(function(i, obj) {
                if (obj.checked == true) {
                    total += Number($(this).val());
                }
                if (total > 0) {
                    $('#acceptPaymentBtn').prop('disabled', false);
                } else {
                    $('#acceptPaymentBtn').prop('disabled', true);
                }
                $('#totalAmountSelected').text(total.toFixed(2));
            });
        })

        $('#acceptPaymentBtn').click(async function() {
            data = await submitFormAjax('processStudentInvoiceForm', 'acceptPaymentBtn', "{{route('process.student.invoice')}}");
            if (data.status === 1) {
                let url = "{{URL::to('payment-receipt')}}?invoice=" + data.invoice_number;
                location.href = url;
            }
        });
        // accept payment end here 
        // reset user password from school 
        $(document).on('click', '.resetPassword', function() {
            let pid = $(this).attr('pid');
            let id = $(this).attr('id');
            $('.overlay').show();
            $.ajax({
                url: "{{route('reset.user.password')}}",
                data: {
                    pid: pid,
                    _token: "{{csrf_token()}}",
                    id: id
                },
                type: "post",
                success: function(data) {
                    $('.overlay').hide();
                    if (data.status === 1) {
                        alert_toast(data.message);
                    } else {
                        alert_toast(data.message);
                    }
                },
                error: function() {
                    $('.overlay').hide();
                    alert_toast('Something Went Wrong', 'error');
                }
            });
        });
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
        // update staff role  
        $(document).on('click', '.updateStaffAccess', function() {
            let id = $(this).attr('id');
            var route = "{{route('school.staff.access')}}";
            submitFormAjax('accessForm' + id, 'id', route);
        });

        // switch role 
        $('.switchRole').click(function() {
            let role = $(this).attr('id')
            let url = "{{URL::to('switch-role')}}/" + role;
            $('.overlay').show();
            $.ajax({
                url: url,
                success: function(data) {
                    $('.overlay').hide();
                    alert_toast('Role Switched... rediecting');
                    let url = "{{URL::to('school-dashboard')}}";
                    location.href = url;
                },
                error: function() {
                    $('.overlay').hide();
                    alert_toast('Something Went Wrong', 'error');
                }
            });
        })
        // update status account status
        $(document).on('click', '.toggleStaffStatus', function() {
            let pid = $(this).attr('pid');
            var url = "update-staff-status/" + pid;
            $('.overlay').show();
            $.ajax({
                url: url, //"{{route('create.school.score.settings')}}",
                success: function(data) {
                    // console.log(data);
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
        // assigning portal to hostel is default to active term and session 
        // multiSelect2('#ahtpSessionSelect2', 'assignHostelToPortalModal', 'session', 'Select Session');
        // multiSelect2('#ahtpTermSelect2', 'assignHostelToPortalModal', 'term', 'Select Term');
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
        // student award 
        multiSelect2('#studentAwardSelect2', 'awardStudentModal', 'award', 'Select Award');
        $(document).on('click', '.awardStudentModal', function() {
            let pid = $(this).attr('pid')
            $('#awardstudentPid').val(pid);
            $('#awardStudentModal').modal('show');
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

        // 

        // find sudent by reg  

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
        $('#assignClassArmToTeacherBtn').click(function() {
            var route = "{{route('assign.staff.class')}}";
            submitFormAjax('assignClassArmToTeacherForm', 'assignClassArmToTeacherBtn', route);
        });
        // subject class arm subject teacher 
        $('#assignArmSubjectTeacherBtn').click(function() {
            var route = "{{route('school.staff.subject')}}";
            submitFormAjax('assignArmSubjectTeacherForm', 'assignArmSubjectTeacherBtn', route);
        });
        // register parent 
        $('#createParentBtn').click(function() {
            var route = "{{route('register.parent')}}";
            submitFormAjax('createParentForm', 'createParentBtn', route);
        });

        // search staff 
        $('#searchExistingStaff').change(function() {
            var key = $(this).val().replace('/', '@__@') // here i replaced / to @__@ because is a get request and / means params
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
            var key = $(this).val().replace('/', '@__@') // here i replaced / to @__@ because is a get request and / means params
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
            var key = $(this).val();
            if (key != '') {
                let route = "{{url('find-existing-parent')}}";
                $('.overlay').show();
                $.ajax({
                    url: route + '?key=' + key,
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
                    // console.log(data);
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

        // hire me process 
        // load user account details  
        $('#hireMeConfig').click(function() {
            $.ajax({
                url: "{{route('load.hire.config')}}",
                dataType: "json",
                beforeSend: function() {
                    $('.overlay').show();
                },
                success: function(data) {
                    // console.log(data);
                    $('.overlay').hide();
                    if (data) {
                        $('#hireAbleAbout').val(data.about);
                        $('#qualification').val(data.qualification);
                        $('#course').val(data.course);
                        $('#years').val(data.years);
                        if (data.status !== null) {
                            $("[name=status]").val(data.status);
                        }
                        $('#hireMeLgaSelect2').val(data.lga).trigger('change');
                        $('#hireMeStateSelect2').val(data.state).trigger('change');
                        $('#areaSubjectSelect2').val(data.subjects).trigger('change');
                    }
                },
                error: function() {
                    $('.overlay').hide();
                }
            });
            $('#hireMeModal').modal('show');
        })
        // hire me modal 
        multiSelect2('#hireMeStateSelect2', 'hireMeModal', 'state', 'Select State');
        $('#hireMeStateSelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#hireMeLgaSelect2', 'hireMeModal', 'state-lga', id, 'Select LGA');
            multiSelect2Post('#areaSubjectSelect2', 'hireMeModal', 'all-state-subjects', id, 'Select Subject');
        });

        $('#hireMeBtn').click(function() {
            var route = "{{route('hire.me.config')}}";
            submitFormAjax('hireMeForm', 'hireMeBtn', route);
        })

        // hire me stop here 

        $('#loadNotifications').click(function() {
            loadMyNotification();
        })
        <?php if (getSchoolPid()) : ?>
            countMyNotification();
        <?php endif ?>



        // setup page code start here

        // stage 2 create term 
        $('#createTermBtn').click(async function() {
            let s = await submitFormAjax('createTermForm', 'createTermBtn', "{{route('create.term')}}");
            if (s.status === 1) {
                $('#setupStepForm').show(500)
            }
        });
        
        // session dropdown active term
        multiSelect2('#setTermSessionSelect2', 'setActiveTermModal', 'session', 'Select Session');
        // term dropdown for active term 
        multiSelect2('#setTermSelect2', 'setActiveTermModal', 'term', 'Select Term');

        // term dropdown 
        // set active session 
        $('#setActiveTermBtn').click(async function() {
            let s = await submitFormAjax('setActiveTermForm', 'setActiveTermBtn', "{{route('school.term.active')}}");
            if (s.status === 1) {
                $('#setupStepForm').show(500)
                $('#setActiveTermModal').modal('close')
            }
        });

        // stage 3 create sessions 
        $('#createSessionBtn').click(async function() {
            let s = await submitFormAjax('createSessionForm', 'createSessionBtn', "{{route('create.session')}}");
            if (s.status === 1) {
                $('#setupStepForm').show(500)
            }
        });

        // active session 
        multiSelect2('#sessionSelect2', 'setActiveSessionModal', 'session', 'Select Session');

        // set active session 
        $('#setActiveSessionBtn').click(async function() {
            let s = await submitFormAjax('setActiveSessionForm', 'setActiveSessionBtn', "{{route('school.session.active')}}");
            if (s.status === 1) {
                $('#setupStepForm').show(500)
            }
        });
        // active session end here 
        // create school category
        // load head teacher 
        multiSelect2('#staffSelect2', 'createClassCategoryModal', 'school-category-head', 'Select Category Head');

        $('#createClassCategoryBtn').click(async function() {
            let s = await submitFormAjax('createClassCategoryForm', 'createClassCategoryBtn', "{{route('create.school.category')}}");
            if (s.status === 1) {
                $('#setupStepForm').show(500)
            }
        });
        // create category end here 

        // create class start here
        multiSelect2('#classCategorySelect2', 'createClassModal', 'category', 'Select Category');

        // create school class 
        $('#addMoreClass').click(function() {
            $('#addMoreClassRow').append(
                `
                 <div class="row addedRow">
                        <div class="col-md-7">
                            <input type="text" name="class[]" placeholder="class e.g JSS 1" class="form-control form-control-sm" required>
                            <p class="text-danger class_error"></p>
                        </div>
                        <div class="col-md-5">
                            <div class="input-group mb-3">
                                <select name="class_number[]" id="classNumberSelect" class="form-control form-control-sm">
                                <option disabled selected>Select Class Number</option>
                                @foreach(CLASS_NUMBER as $key=> $nm)
                                        <option value="{{$key}}"> {{$nm}}</option>
                                    @endforeach
                            </select>
                            <i class="bi bi-x-circle-fill text-danger pointer m-2 removeRowBtn"></i>
                            </div>
                            <p class="text-danger class_number_error"></p>
                        </div>
                    </div>
                `
            );
            // init select2 again 
        });
        $("#classNumberSelect2").select2({
            tags: true,
            dropdownParent: $('#createClassModal'),
            width: "100%",
        });
        $(document).on('click', '.addedRow .removeRowBtn', function() {
            $(this).parent().parent().parent().remove();
        });


        $('#createClassBtn').click(async function() {
            let s = await submitFormAjax('createClassForm', 'createClassBtn', "{{route('create.school.class')}}");
            if (s.status === 1) {
                $('#setupStepForm').show(500)
            }
        });
        // create class end here

        // creata class arm start here

        var psp = 2;
        $('#addMArm').click(function() {
            psp++;
            $('#addMoreArmRow').append(
                `
                 <div class="row addedRow">
                        <div class="col-md-6">
                        <label for="number">Class Arm Name</label>
                            <div class ="input-group">
                            <input type="text" name="arm[]" placeholder="class arm" class="form-control form-control-sm" required>
                            <i class="bi bi-x-circle-fill text-white m-2 removeRowBtn"></i>
                            </div>
                            <p class="text-danger arm_error"></p>
                        </div>
                        <div class="col-md-6">
                        <label for="number">Class Arm Serial Number</label>
                            <div class="input-group mb-3">
                                <select name="arm_number[]" id="classNumberSelect2" class="form-control form-control-sm">
                                    <option disabled selected>Arm serial number</option>
                                    @foreach(CLASS_NUMBER as $key=> $nm)
                                    <option value="{{$key}}">{{$nm}}</option>
                                    @endforeach
                                </select>
                                <i class="bi bi-x-circle-fill text-danger m-2 removeRowccaBtn pointer"></i>
                            </div>
                            <p class="text-danger arm_number_error"></p>
                        </div>
                    </div>
                `
            );
            // init select2 again 
        });

        $(document).on('click', '.addedRow .removeRowccaBtn', function() {
            $(this).parent().parent().parent().remove();
        });
        multiSelect2('.ccaCategorySelect2', 'createClassArmModal', 'category', 'Select Category');
        $('#ccaCategorySelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#ccaClassSelect2', 'createClassArmModal', 'class', id, 'Select Class');
        });
        $('#createClassArmBtn').click(async function() {
            let s = await submitFormAjax('createClassArmForm', 'createClassArmBtn', "{{route('create.class.arm')}}");
            if (s.status === 1) {
                $('#setupStepForm').show(500)
            }
        });

        // creata class arm end here 

        // step 9 create subject type 

        $(document).on('click', '.createSubjectTypeBtn', function() {
            let form = $(this).attr('id');
            $('.overlay').show();
            $.ajax({
                url: "{{route('create.subject.type')}}",
                type: "POST",
                data: new FormData($('#' + form)[0]),
                dataType: "JSON",
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('.createSubjectTypeForm').find('p.text-danger').text('');
                    $('.createSubjectTypeBtn').prop('disabled', true);
                },
                success: function(data) {
                    console.log(data);
                    $('.createSubjectTypeBtn').prop('disabled', false);
                    $('.overlay').hide();
                    if (data.status === 0) {
                        alert_toast('Fill in form correctly', 'warning');
                        $.each(data.error, function(prefix, val) {
                            $('.' + prefix + '_error').text(val[0]);
                        });
                    } else if (data.status === 1) {
                        $('#setupStepForm').show(500)
                        alert_toast(data.message, 'success');
                        $('#' + form)[0].reset();
                    } else {
                        alert_toast(data.message, 'error');
                    }
                },
                error: function(data) {
                    // console.log(data);
                    $('.createSubjectTypeBtn').prop('disabled', false);
                    $('.overlay').hide();
                    alert_toast('Something Went Wrong', 'error');
                }
            });
        });

        // step 10 subject 
        multiSelect2('#createSubjectSubjectTypeSelect2', 'createSubjectModal', 'subject-type', 'Select Subject Type');
        multiSelect2('#dupSubjectTypeSelect2', 'dupSubjectTypeModal', 'subject-type', 'Select Subject Type');
        multiSelect2('#dupSubjectCategorySelect2', 'dupSubjectTypeModal', 'category', 'Select Category');
        multiSelect2('#createSubjectCategorySelect2', 'createSubjectModal', 'category', 'Select Category');
        FormMultiSelect2('#categorySubjectSelect2', 'category', 'Select Category');
        multiSelect2('#subjectTeacherSelect2', 'createClassSubjectToTeacherModal', 'school-teachers', 'Select Subject Teacher');
        // create subject 
        $('#createSubjectBtn').click(async function() {
            let s = await submitFormAjax('createSchoolCategortSubjectForm', 'createSubjectBtn', "{{route('create.subject')}}");
            if (s.status === 1) {
                $('#setupStepForm').show(500)
            }
        });

        $('#addMoreSubject').click(function(){
            $('#moreSubject').append(`
                <div class="form-group">
                        <div class="input-group">
                            <input type="text" name="subject[]" id="subject" class="form-control form-control-sm" placeholder="subject name" required>
                            <i class="bi bi-x-circle-fill text-danger removeSubject pointer "></i>
                        </div>
                        <p class="text-danger subject_error"></p>
                    </div>
            `);
        })
        
        $(document).on('click', '.removeSubject', function() {
            $(this).parent().parent().remove();
        });
        $('#addMoreTitle').click(function(){
            $('#moreTitle').append(`
                <div >
                        <div class="float-end">
                            <i class="bi bi-x-circle-fill text-danger pointer removeTitleRow "></i>
                        </div>
                            <label for="" class="text-danger">*</label>
                            <input type="text" name="title[]" class="form-control form-control-sm" autocomplete="off" placeholder="Assessment title">
                        <p class="text-danger title_error"></p>
                        <input type="text" name="description[]" class="form-control form-control-sm" autocomplete="off" placeholder="Assessment Description">

                        <p class="text-danger description_error"></p>
                    </div>
            `);
        })
        
        $(document).on('click', '.removeTitleRow', function() {
            $(this).parent().parent().remove();
        });
        // create subject 
        $('#createDupSubjectBtn').click(async function() {
            let s = await submitFormAjax('createDupSubjectForm', 'createDupSubjectBtn', "{{route('dup.subject.type.subject')}}");
            if (s.status === 1) {
                $('#setupStepForm').show(500)
            }
        });



        // create class arm subjects 
        multiSelect2('#casfCategorySelect2', 'createArmSubjectModal', 'category', 'Select Category');
        multiSelect2('#casfSessionSelect2', 'createArmSubjectModal', 'session', 'Select Category');
        $('#casfCategorySelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#casfClassSelect2', 'createArmSubjectModal', 'class', id, 'Select Class');
        });
        $('#casfCategorySelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#casfSubjectSelect2', 'createArmSubjectModal', 'category-subject', id, 'Select Subject');
        });
        $('#casfClassSelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#casfArmSelect2', 'createArmSubjectModal', 'class-arm', id, 'Select Class Arm');
        });

        $('#createClassArmSubjectBtn').click(async function() {
            let s = await submitFormAjax('createClassArmSubjectForm', 'createArmSubjectBtn', "{{route('create.school.class.arm.subject')}}");
            if (s.status === 1) {
                $('#setupStepForm').show(500)
            }
        });

        // create assessment type 
        $('#createAssessmentBtn').click(async function(e) {
            e.preventDefault()
            let s = await submitFormAjax('createAssessmentForm', 'createAssessmentBtn', "{{route('school.assessment.title')}}");
            if (s.status === 1) {
                $('#setupStepForm').show(500)
            }
        });


        // score setting 
        // title dropdown 
        var pid = 0;
        titleDropDown(pid)

        function titleDropDown(id) {
            var id = '#titleSelect' + id;
            multiSelect2(id, 'createScoreSettingModal', 'title', 'Select Title');
        }
        // add more title 
        $('#addMore').click(function() {
            pid++
            $('#settingParams').append(
                `
                 <div class="row addedRow">
                            <div class="col-md-5">
                                <select type="text" name="title_pid[]" id="titleSelect${pid}" style="width:100%;" class="titleSelect2 form-control form-control-sm">
                                </select>
                                <p class="text-danger title_pid${pid}_error"></p>
                            </div>
                            <div class="col-md-7">
                                <div class="input-group mb-3">
                                    <input type="number" step=".0" min="1" max="100" class="form-control form-control-sm" name="score[]" placeholder="obtainable score">
                                    {{--<span class="input-group-text">Mid-Term?</span>
                                    <input class="custom-check m-1" value="2" name="mid[]" type="checkbox" id="gridCheck2"> --}}
                                    <i class="bi bi-x-circle-fill text-danger removeRowBtn pointer mx-2"></i>
                                </div>
                                <p class="text-danger score${pid}_error"></p>
                            </div>
                        </div>`
            );
            // init select2 again 
            titleDropDown(pid);
        });

        $(document).on('click', '.addedRow .removeRowBtn', function() {
            $(this).parent().parent().parent().remove();
        });

        // validate signup form on keyup and submit



        // create score seeting 
        // multiSelect2('#cssSessionSelect2', 'createScoreSettingModal', 'session', 'Select Session');
        // multiSelect2('#cssTermSelect2', 'createScoreSettingModal', 'term', 'Select Term');
        multiSelect2('#cssCategorySelect2', 'createScoreSettingModal', 'category', 'Select Category');
        $('#cssCategorySelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#cssClassSelect2', 'createScoreSettingModal', 'class', id, 'Select Class');
        });
        $('#createScoreSettingBtn').click(async function(e) {
            let route = "{{route('create.school.score.settings')}}";
            e.preventDefault()
            let s = await submitFormAjax('createScoreSettingForm', 'createScoreSettingBtn', route);
            if (s.status === 1) {
                $('#setupStepForm').show(500)
            }
        });
        // setup page code end here 
    })

    // global functions 
    function numberFormat(number, point = 2) {
        return number.toFixed(point).replace(/\d(?=(\d{3})+\.)/g, '$&,')
    }

    function loadStudentInvoiceById(pid) {
        return new Promise((resolve, reject) => {
            $('.overlay').show();
            $.ajax({
                url: "{{route('load.student.invoice.by.pid')}}",
                type: "post",
                data: {
                    pid: pid,
                    _token: "{{csrf_token()}}"
                },
                success: function(data) {
                    $('#studentUnPaidInvoices').html(data)
                    $('#paymentBtn').show();
                    $('#acceptPaymentBtn').show().prop('disabled', true);
                    $('.overlay').hide();
                    resolve(true)
                },
                error: function() {
                    $('.overlay').hide();
                    reject(true)
                }
            })
        });
    }

    <?php if (getSchoolPid()) : ?>

        function countMyNotification() {
            // load.my.notification.tip
            $.ajax({
                url: "{{route('count.my.notification.tip')}}",
                success: function(data) {
                    // console.log(data);
                    $('#badge-number').text(data);
                }
            });
        }
    <?php endif ?>

    function loadMyNotification() {
        $.ajax({
            url: "{{route('load.my.notification.tip')}}",
            success: function(data) {
                $('#notifications').html(data);
            }
        });
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

    function FormMultiSelect2(idOrClass, route, plh, pre = null,table=null) {
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
            },
             initSelection: function (pre, callback) {
                alert(pre)
                // var id = $(element).val();
                // if (id !== "") {
                // $.ajax("ajax.php/get_where", {
                //     data: {programid: id},
                //     dataType: "json"
                // }).done(function (data) {
                //     $.each(data, function (i, value) {
                //     callback({"text": value.text, "id": value.id});
                //     });
                //     ;
                // });
                // }
            },
            dropdownCssClass: "bigdrop",
            escapeMarkup: function (m) { return m; }
        })//.val(pre).trigger('change').trigger('focus');
        if (pre != null) {
            $(idOrClass).val(pre).trigger('change')
        }
    }


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
            })//.val(pre).trigger('change').trigger('focus');
            if (pre != null) {
                $(idOrClass).val(pre).trigger('change')
            }

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
        })//.val(pre).trigger('change').trigger('focus');
        if (pre != null) {
            $(idOrClass).val(pre).trigger('change')
        }    
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
            })//.val(pre).trigger('change').trigger('focus');

            if (pre != null) {
                $(idOrClass).val(pre).trigger('change')
            }            
        }
    }


    
    $(function() {
        let width = $(window).innerWidth() / 1.5;
        $('.iframe-video').css({
            width: width + 'px',
            height: $(window).innerHeight() + 'px'
        });

        $(window).resize(function() {
            let width = $(window).innerWidth();
            if(width > 1100){
                width = width / 1.5;
            }else{
                width = width - 100;
            }
            // let height = $(window).innerHeight();
            $('.iframe-video').css({
                width: width + 'px',
                height: $(window).innerHeight() + 'px'
            });
        });
    });

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
                url: route, //"url,
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
                            resolve(data)
                        } else {
                            resolve(data)
                        }
                    } else {
                        alert_toast(data.message, 'error');
                        resolve(data)
                    }
                },
                error: function(data) {
                    $('#' + btnId).prop('disabled', false);
                    $('.overlay').hide();
                    console.log(data);
                    alert_toast('Something Went Wrong', 'error');
                    // location.reload()
                    reject(true);
                }
            });
        });
        // });
    }

    function postDataAjax(data,route,method='post'){
        $.ajax({
            url: route,
            type: method,
            data: data,
            dataType: "JSON",
            beforeSend: function() {
                $('.overlay').show();
            },
            success: function(data) {
                $('.overlay').hide();
                if (data.status === 1) {
                    alert_toast(data.message, 'success');
                } else {
                    alert_toast(data.message, 'error');
                }
            },
            error: function(data) {
                $('.overlay').hide();
                location.reload()
                alert_toast('Something Went Wrong', 'error');
            }
        });
    }

    function loadDataAjax(route, params, method = 'post') {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: route,
                type: method,
                data: params,
                beforeSend: function() {
                    $('.overlay').show();
                },
                success: function(data) {
                    $('.overlay').hide();
                    resolve(data);
                },
                error: function() {
                    $('.overlay').hide();
                    alert_toast('Something Went Wrong', 'error');
                    location.reload()
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

    function isset(accessor) {
        try {
            // Note we're seeing if the returned value of our function is not
            // undefined or null
            return accessor() !== undefined && accessor() !== null
        } catch (e) {
            // And we're able to catch the Error it would normally throw for
            // referencing a property of undefined
            return false
        }
    }
</script>