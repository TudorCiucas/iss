$(document).ready(function () {

});

var Header = {
    viewProfile: function (id) {
        $("#profile_user_id").val(id);
        $("#redirectProfile").submit();
    }
};

var Global = {
    setError: function (error) {
        $("#failText").html(error);
        this.toggleErrorDiv(true);
    },
    resetError: function () {
        $("#failText").html("");
        this.toggleErrorDiv(false);
    },
    toggleErrorDiv: function (toggle) {
        if (toggle) {
            $("#errorDiv").show();
        } else {
            $("#errorDiv").hide();
        }
    },
    getLevels: function () {
        $.ajax({
            type: "POST",
            url: "../../core/services/level.ajax.php",
            dataType: 'json',
            data: {
                op: 'getAll'
            },
            success: function(response) {
                if (response.status == 'ok') {
                    return response.data;
                }
            }
        });
    },
    initBrokers: function (element) {
        $.ajax({
            type: "POST",
            url: "../../core/services/broker.ajax.php",
            dataType: 'json',
            data: {
                op: 'getAll'
            },
            success: function(response) {
                if (response.status === 'ok') {
                    var _html = '';
                    _html = '<option value="">Toți brokeri</option>';
                    $.each(response.data, function (asig, item) {
                        _html += '<option value="' + item.key + '">' + item.value + '</option>';
                    });
                    $('#' + element).html(_html);
                    $('#' + element).selectpicker('refresh');
                }
            }
        });
    },
    initAgenti: function (element) {
        $.ajax({
            type: "POST",
            url: "../../core/services/agent.ajax.php",
            dataType: 'json',
            data: {
                op: 'getAgenti'
            },
            success: function(response) {
                if (response.status === 'ok') {
                    var _html = '';
                    _html = '<option value="">Toți agenții</option>';
                    $.each(response.data, function (asig, item) {
                        _html += '<option value="' + item.key + '">' + item.value + '</option>';
                    });
                    $('#' + element).html(_html);
                    $('#' + element).selectpicker('refresh');
                }
            }
        });
    },
    initAsiguratori: function (element) {
        $.ajax({
            type: "POST",
            url: "../../core/services/asigurator.ajax.php",
            dataType: 'json',
            data: {
                op: 'getAll'
            },
            success: function(response) {
                if (response.status === 'ok') {
                    var _html = '';
                    _html = '<option value="">Toți asiguratorii</option>';
                    $.each(response.data, function (asig, item) {
                        _html += '<option value="' + item.key + '">' + item.value + '</option>';
                    });
                    $('#' + element).html(_html);
                    $('#' + element).selectpicker('refresh');
                }
            }
        });
    },
    initTipAsigurari: function (element) {
        $.ajax({
            type: "POST",
            url: "../../core/services/asigurare.ajax.php",
            dataType: 'json',
            data: {
                op: 'getAll'
            },
            success: function(response) {
                if (response.status === 'ok') {
                    var _html = '';
                    _html = '<option value="">Toate tipurile</option>';
                    $.each(response.data, function (asig, item) {
                        _html += '<option value="' + item.key + '">' + item.value + '</option>';
                    });
                    $('#' + element).html(_html);
                    $('#' + element).selectpicker('refresh');
                }
            }
        });
    }
};
