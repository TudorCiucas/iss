$(function() {
    Depuneri.clearFields();
    Depuneri.initTable();
    Depuneri.initButtonEvents();
});

var Depuneri = {
    initButtonEvents: function () {
        $("#addDepunere").click(function () {
            Depuneri.save();
            return false;
        });
        $("#add_depuneri_link").click(function () {
            Depuneri.clearFields();
        });
        $("#cancelDepunere").click(function () {
            Depuneri.clearFields();
            return false;
        });
        $("#btnAssignReviewers").click(function () {
            Depuneri.assignReviewers();
        });
        $("#btnEvaluate").click(function () {
            Depuneri.evaluate();
        });
    },
    save: function () {
        Global.resetError();
        $.ajax({
            type: "POST",
            url: baseUrlCMS + "module/depuneri/depuneri.ajax.php",
            dataType: 'json',
            data: {
                op: 'add',
                formData: $("#depuneriForm").serialize()
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
        var action = $('#act').val();
        $.ajax({
            type: "POST",
            url: baseUrlCMS + "module/depuneri/depuneri.ajax.php",
            dataType: 'json',
            data: {
                op: 'getDepuneri',
                act: action
            },
            success: function(response) {
                if (response.status == 'ok') {
                    var _html = '<table class="table table-striped table-bordered table-hover" id="depuneri">';
                    _html += '<thead> <tr> <th>Titlu</th> <th>Conferinta</th> <th>Autor</th><th>Evaluatori</th> <th>Abstract</th> <th>Keywords</th><th>Document</th><th>Data depunerii</th><th>Operatiuni</th></tr> </thead>';
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
                $('#depuneriTable').html(_html);
                $('#depuneri').dataTable({
                    responsive: true
                });
            }
        });
    },
    approve: function (id) {
        Depuneri.approveReject(id, 1);
    },
    reject: function (id) {
        Depuneri.approveReject(id, 0);
    },
    approveReject: function (id, isApproved) {
        $.ajax({
            type: "POST",
            url: baseUrlCMS + "module/depuneri/depuneri.ajax.php",
            dataType: 'json',
            data: {
                op: 'approveReject',
                propunere_id: id,
                isApproved: isApproved
            },
            success: function(response) {
                if (response.status == 'fail') {
                    alert(response.message);
                } else {
                    alert(response.message);
                    Depuneri.initTable();
                }
            }
        });
    },
    openAssignReviewersModal: function (id) {
        $.ajax({
            type: "POST",
            url: baseUrlCMS + "module/depuneri/depuneri.ajax.php",
            dataType: 'json',
            data: {
                op: 'getAvailableReviewers',
                propunere_id: id
            },
            success: function(response) {
                if (response.status === 'fail') {
                    alert(response.message);
                } else {
                    $("#depunere_id").val(id);
                    if (response.data) {
                        var _html = '<option value="">Alege</option>';
                        $.each(response.data, function (key, item) {
                            console.log(item.id);
                            console.log(item.nume);
                            _html += '<option value="' + item.id + '" >' + item.nume + '</option>';
                        });

                        $('#reviewer').html(_html).selectpicker('refresh');
                        $("#assignToModal").modal('show');
                    }
                }
            }
        });
    },
    openEvaluateModal: function (id) {
        $("#propunere_id").val(id);
        $("#evaluateModal").modal('show');
    },
    assignReviewers: function () {
        Global.resetError();
        $.ajax({
            type: "POST",
            url: baseUrlCMS + "module/depuneri/depuneri.ajax.php",
            dataType: 'json',
            data: {
                op: 'assignReviewers',
                formData: $("#assignToForm").serialize()
            },
            success: function(response) {
                if (response.status === 'fail') {
                    Global.setError(response.message);
                } else {
                    Global.resetError();
                    alert(response.message);
                    Depuneri.initTable();
                }
            }
        });
    },
    evaluate: function () {
        Global.resetError();
        $.ajax({
            type: "POST",
            url: baseUrlCMS + "module/depuneri/depuneri.ajax.php",
            dataType: 'json',
            data: {
                op: 'evaluate',
                formData: $("#evaluateForm").serialize()
            },
            success: function(response) {
                if (response.status === 'fail') {
                    Global.setError(response.message);
                } else {
                    Global.resetError();
                    alert(response.message);
                    location.reload();
                }
            }
        });
    },
    openViewEvaluateModal: function (id) {
        $.ajax({
            type: "POST",
            url: baseUrlCMS + "module/depuneri/depuneri.ajax.php",
            dataType: 'json',
            data: {
                op: 'getReview',
                review_id: id
            },
            success: function(response) {
                if (response.status === 'fail') {
                    alert(response.message);
                } else {
                    var review = response.data;
                    $('.propunere_id').val(review.id);
                    $('.calificativ').html(review.calificativ);
                    $('.obs').html(review.obs);
                    $('.created_date').html(review.created_date);

                    $('#viewReviewModal').modal('show');
                }
            }
        });
    },
    clearFields: function () {
        $('#nume').val('');
    }
};