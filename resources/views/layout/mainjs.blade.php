<script>
    function multiSelect2(id, modal, route, plh) {
        $('#' + id).select2({
            placeholder: plh,
            dropdownParent: $('#' + modal),
            width: "100%",
            allowClear: true,
            ajax: {
                url: route,
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

    function multiSelect2Post(id, modal, route, pid, plh) {
        var token = $("input[name='_token']").val();
        $('#' + id).select2({
            placeholder: plh,
            dropdownParent: $('#' + modal),
            width: "100%",
            allowClear: true,
            ajax: {
                url: route,
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
</script>