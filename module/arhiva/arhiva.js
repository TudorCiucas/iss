$(function() {
    Arhiva.clearFields();
    Arhiva.initTable();
    Arhiva.initButtonEvents();
});

var Arhiva = {
    initButtonEvents: function () {
        $("#addCerere").click(function () {
           Arhiva.uploadDocument(); 
        });
    },
    clearFields: function () {
        
    },
    initTable: function () {
        $.ajax({
            type: "POST",
            url: baseUrlCMS + "module/arhiva/arhiva.ajax.php",
            dataType: 'json',
            data: {
                op: 'get'
            },
            success: function(response) {
                if (response.status == 'ok') {
                    var _html = '<table class="table table-striped table-bordered table-hover" id="arhiva">';
                    _html += '<thead> <tr> <th>Denumire docoument</th> <th>Nume angajat</th> <th>Data</th> <th>Vizualizare</th></tr> </thead>';
                    _html += '<tbody>';
                    $.each(response.data, function (key, item) {
                        _html += '<tr class="odd gradeX">';
                        $.each(item, function (k, value) {
                            _html += '<td>' + value + '</td>'
                        });
                        _html += '</tr>';
                    });
                    _html += '</tbody>';
                    _html += '</table>';
                }
                $('#arhivaTable').html(_html);
                $('#arhiva').dataTable({
                    responsive: true
                });
            }
        });
    },
    uploadDocument: function () {
        Global.resetError();
        var file_data = $('#file_upload').prop('files')[0];
        var form_data = new FormData();
        form_data.append('op', 'upload');
        form_data.append('file', file_data);
        form_data.append('formData', $('#attachForm').serialize());
        $.ajax({
            url: baseUrlCMS + 'upload-manager.php', // point to server-side PHP script
            dataType: 'text', // what to expect back from the PHP script
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (response) {
                if (response.status === 'fail') {
                    Global.setError(response.message);
                } else {
                    Global.resetError();
                    alert(response.message);
                    Arhiva.initTable();
                }
            }
        });
    }
};