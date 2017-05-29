$(function() {
    Profile._setId($('#personalId').val());
    Profile.initButtonEvents();
    Profile.initDetails();
});

var Profile = {
    _id: '',
    _setId: function (id) {
        this._id = id;
    },
    initButtonEvents: function () {
        $("#editPersonal").click(function () {
            Profile.save();
            return false;
        });
        $("#cancelPersonal").click(function () {
            Profile.redirectToList();
            return false;
        });
        $("#deletePersonal").click(function () {
            Profile.deletePersonal();
            return false;
        });
        $("#confirmDeletePersonal").click(function () {
            $("#deletePersonalModal").modal('show');
            return false;
        });
        $("#saveUserCommission").click(function () {
            Profile.savePersonalCommission(0);
            return false;
        });
        $("#updateUserCommission").click(function () {
            Profile.savePersonalCommission(1);
            return false;
        });
        $("#btnChangeLevel").click(function () {
            $('#changeLevelModal').modal('show');
            return false;
        });
        $("#btnSaveLevelChanges").click(function () {
            Profile.changeLevel();
            return false;
        });

    },
    redirectToList: function () {
        window.history.back();
    },
    initDetails: function () {
        $.ajax({
            type: "POST",
            url:  baseUrlCMS + "module/personal/profil.ajax.php",
            dataType: 'json',
            data: {
                op: 'getDetails',
                id: Profile._id
            },
            success: function (response) {
                if (response.status === 'ok') {
                    var User = response.data;
                    $('#nume').val(User.nume);
                    $('#rank').val(User.rank).selectpicker('refresh');
                    $('#email').val(User.email);
                    $('#afiliere').val(User.afiliere);
                    $('#webpage').val(User.webpage);
                    $('#password').val(User.password);
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
            url: baseUrlCMS + "module/pesonal/personal.ajax.php",
            dataType: 'json',
            data: {
                op: 'add',
                formData: $("#editPersonalForm").serialize()
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
    deletePersonal: function (id) {
        
    },
    resetUserDialogError: function () {
        $("#failUserText").html('');
        Profile.toggleUserDialogDiv(false);
    },
    setUserDialogError: function (error) {
        $("#failUserText").html(error);
        Profile.toggleUserDialogDiv(true);
    },
    toggleUserDialogDiv: function (toggle) {
        if (toggle) {
            $("#errorUserDiv").show();
        } else {
            $("#errorUserDiv").hide();
        }
    }
};