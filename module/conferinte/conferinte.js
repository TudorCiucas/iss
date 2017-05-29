$(function() {
    Conferinte.clearFields();
    Conferinte.initTable();
    Conferinte.initButtonEvents();
});

var Conferinte = {
    initButtonEvents: function () {
        $("#addConferinta").click(function () {
            Conferinte.save();
            return false;
        });
        $("#add_conferinte_link").click(function () {
            Conferinte.clearFields();
        });
        $("#cancelConferinta").click(function () {
            Conferinte.clearFields();
            return false;
        });
    },
    save: function () {
        Global.resetError();
        $.ajax({
            type: "POST",
            url: baseUrlCMS + "module/conferinte/conferinte.ajax.php",
            dataType: 'json',
            data: {
                op: 'add',
                formData: $("#conferinteForm").serialize()
            },
            success: function(response) {
                if (response.status == 'fail') {
                    Global.setError(response.message);
                } else {
                    Global.resetError();
                    alert(response.message);
                    location.reload();
                }
            }
        });
    },
    initTable: function () {
        $.ajax({
            type: "POST",
            url: baseUrlCMS + "module/conferinte/conferinte.ajax.php",
            dataType: 'json',
            data: {
                op: 'getConf'
            },
            success: function(response) {
                if (response.status == 'ok') {
                    var _html = '<table class="table table-striped table-bordered table-hover" id="conferinte">';
                    _html += '<thead> <tr> <th>Nume</th> <th>Data</th> <th>Deadline</th> <th>Acceptance date</th> <th>Ext. deadline</th><th>Ext. accept. date</th><th>Topic</th><th>Taxa</th><th>Detalii/Obs</th> </tr> </thead>';
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
                $('#conferinteTable').html(_html);
                $('#conferinte').dataTable({
                    responsive: true
                });
            }
        });
    },
    clearFields: function () {
        $('#nume').val('');
        $('#rank').val('');
        $('#rank').selectpicker('refresh');
        $('#email').val('');
        $('#afiliere').val('');
        $('#webpage').val('');
        $('#password').val('');
    }
};