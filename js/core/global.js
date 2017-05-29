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
    }
};
