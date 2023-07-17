@extends('layout.mainlayout')
@section('title','Psychomotor Form')
@section('content')

<section class="section d-flex flex-column align-items-center justify-content-center py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                <div class="card">
                    <div class="card-body">
                        <div class="pt-4 pb-2">
                            <p class="text-center small">Select Psychomotor Type</p>
                        </div>
                        <form class="row g-3 needs-validation" method="post">
                            @csrf
                            <div class="col-12">
                                <label for="category" class="form-label">Category</label>
                                <select type="text" name="category" class="form-control" id="formCategorySelect2" required>
                                </select>
                            </div>
                            <!-- <div class="col-12">
                                <label for="session" class="form-label">Session</label>
                                <select type="text" name="session" class="form-control" id="formSessionSelect2">
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="term" class="form-label">Term</label>
                                <select type="text" name="term" class="form-control" id="formTermSelect2">
                                </select>
                            </div> -->
                            <div class="col-12">
                                <label for="class" class="form-label">Class</label>
                                <select type="text" name="class" class="form-control" id="formClassSelect2">
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="arm" class="form-label">Class Arm</label>
                                <select type="text" name="arm" class="form-control" id="formArmSelect2">
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="arm" class="form-label">Psychomotor Type</label>
                                <select type="text" name="psychomotor_pid" class="form-control" id="psychomotorBaseSelect2">
                                </select>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100" type="submit">Continue</button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

</section>
<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>
<script>
    $(document).ready(function() {
        // FormMultiSelect2('#psychomotorBaseSelect2', 'psychomotors', 'Select Psychomotor');
        FormMultiSelect2('#formSessionSelect2', 'session', 'Select Session');
        FormMultiSelect2('#formTermSelect2', 'term', 'Select Term');
        FormMultiSelect2('#formCategorySelect2', 'category', 'Select Category');
        $('#formCategorySelect2').on('change', function(e) {
            var id = $(this).val();
            FormMultiSelect2Post('#formClassSelect2', 'class', id, 'Select Class');
            FormMultiSelect2Post('#psychomotorBaseSelect2', 'psychomotors', id, 'Select Psychomotor');
        });
        $('#formClassSelect2').on('change', function(e) {
            var id = $(this).val();
            FormMultiSelect2Post('#formArmSelect2', 'class-teacher-arm', id, 'Select Class Arm');
        });

    });
</script>
@endsection