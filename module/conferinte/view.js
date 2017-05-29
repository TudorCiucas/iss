$(function() {
    ConferintaProfile._setId($('#confId').val());
    ConferintaProfile.initButtonEvents();
    ConferintaProfile.initDetails();
});

var ConferintaProfile = {
    _id: '',
    _setId: function (id) {
        this._id = id;
    },
    initButtonEvents: function () {
        $("#editConferinta").click(function () {
            ConferintaProfile.save();
            return false;
        });
        $("#cancelConferinta").click(function () {
            ConferintaProfile.redirectToList();
            return false;
        });
        $("#deleteConferinta").click(function () {
            ConferintaProfile.deleteConferinta();
            return false;
        });
        $("#confirmDeleteConferinta").click(function () {
            $("#deleteConferintaModal").modal('show');
            return false;
        });
    },
    redirectToList: function () {
        window.history.back();
    },
    initDetails: function () {
        $.ajax({
            type: "POST",
            url:  baseUrlCMS + "module/conferinte/view.ajax.php",
            dataType: 'json',
            data: {
                op: 'getDetails',
                id: ConferintaProfile._id
            },
            success: function (response) {
                if (response.status === 'ok') {
                    var Conf = response.data;
                    $('#nume').val(Conf.nume);
                    $('#data').val(Conf.data).selectpicker('refresh');
                    $('#deadline').val(Conf.deadline).selectpicker('refresh');
                    $('#acceptance_date').val(Conf.acceptance_date).selectpicker('refresh');
                    $('#ext_deadline').val(Conf.ext_deadline).selectpicker('refresh');
                    $('#ext_acceptance_date').val(Conf.ext_acceptance_date).selectpicker('refresh');
                    $('#topic').val(Conf.topic);
                    $('#fee').val(Conf.fee);
                    $('#obs').val(Conf.obs);
                }
            },
            error: function (request, status, error) {
                alert(request.responseText);
                alert(status);
                alert(error);
            }
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
                formData: $("#editConferintaForm").serialize()
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
    deleteConferinta: function (id) {
        
    }
};