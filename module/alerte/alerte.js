$(function () {
    NewsView.initButtonEvents();
    News.initNewsList(1000);
});

var NewsView = {
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
    }
};