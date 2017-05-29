$(function () {
    Dashboard.initButtonEvents();
    News.initNewsList(10);
    // Dashboard.init();
});

var Dashboard = {
    initButtonEvents: function () {
        $("#btnPublishNews").click(function () {
            News.addNews();
        });
        $("#btnShowNewsModal").click(function () {
            News.clearNewsModalFields();
            $("#newsModal").modal('show');
        });
        $("#btnDeleteNews").click(function () {
            News.deleteNews();
        });
        $("#btnEmptyNewsList").click(function () {
            $("#emptyNewsModal").modal('show');
        });
        $("#btnDeleteAllNews").click(function () {
            News.emptyNewsList();
        })
    },
    init: function () {
        $.ajax({
            type: "POST",
            url: baseUrlCMS + "module/dashboard/dashboard.ajax.php",
            dataType: 'json',
            data: {
                op: 'get'
            },
            success: function(response) {
                if (response.status === 'fail') {
                   alert(response.message);
                } else {

                }
            }
        });
    }
};
