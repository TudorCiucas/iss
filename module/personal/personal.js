$(function() {
    Personal.clearFields();
    Personal.initTable();
    Personal.initButtonEvents();
});

var Personal = {
    initButtonEvents: function () {
        $("#addPersonal").click(function () {
            Personal.save();
            return false;
        });
        $("#add_personal_link").click(function () {
            Personal.clearFields();
        });
        $("#cancelPersonal").click(function () {
            Personal.clearFields();
            return false;
        });
        $('#rank').change(function () {
            Personal.showHideTip();
        });
        $("#aTip").change(function () {
           Personal.showHideSalar();
        });
    },
    showHideTip: function () {
        if ($('#rank').val() === '1') {
            $('.tip-personal').show();
        } else {
            $('.tip-personal').hide();
        }
    },
    save: function () {
        Global.resetError();
        $.ajax({
            type: "POST",
            url: baseUrlCMS + "module/personal/personal.ajax.php",
            dataType: 'json',
            data: {
                op: 'add',
                formData: $("#personalForm").serialize()
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
            url: baseUrlCMS + "module/personal/personal.ajax.php",
            dataType: 'json',
            data: {
                op: 'getUsers'
            },
            success: function(response) {
                if (response.status == 'ok') {
                    var _html = '<table class="table table-striped table-bordered table-hover" id="personal">';
                    _html += '<thead> <tr> <th>Nume</th> <th>Rol</th> <th>Afiliere</th> <th>E-mail</th> <th>Webpage</th> </tr> </thead>';
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
                $('#personalTable').html(_html);
                $('#personal').dataTable({
                    responsive: true
                });
            }
        });
    },
    assingChair: function (id) {
        $.ajax({
            type: "POST",
            url: baseUrlCMS + "module/personal/personal.ajax.php",
            dataType: 'json',
            data: {
                op: 'assignChair',
                user_id: id,
                conf_id: $('#conf_id').val()
            },
            success: function(response) {
                if (response.status == 'fail') {
                    alert(response.message);
                } else {
                    alert(response.message);
                    location.reload();
                }
            }
        });
    },
    assingCoChair: function (id) {
        $.ajax({
            type: "POST",
            url: baseUrlCMS + "module/personal/personal.ajax.php",
            dataType: 'json',
            data: {
                op: 'assignCoChair',
                user_id: id,
                conf_id: $('#conf_id').val()
            },
            success: function(response) {
                if (response.status == 'fail') {
                    alert(response.message);
                } else {
                    alert(response.message);
                    location.reload();
                }
            }
        });
    },
    viewProfile: function (id) {
        $("#redirect_user_id").val(id);
        $("#redirect").submit();
    },
    clearFields: function () {
        $('#nume').val('');
        $('#rank').val('');
        $('#rank').selectpicker('refresh');
        $('#email').val('');
        $('#telefon').val('');
        $('#password').val('');
        $('#observatii').val('');
    }
};