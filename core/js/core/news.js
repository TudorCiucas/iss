var News = {
    limit: 10,
    initNewsList: function (rowsNumber) {
        News.limit = rowsNumber;
        $.ajax({
            type: "POST",
            url: baseUrlCMS + "module/dashboard/dashboard.ajax.php",
            dataType: 'json',
            data: {
                op: 'getNews',
                number: News.limit
            },
            success: function (response) {
                if (response.status = 'ok') {
                    var news = response.data;
                    var _html = '';
                    if (news.length > 0) {
                        $.each(news, function (key, item) {
                            _html += '<a href="javascript:void(0);" class="list-group-item">';
                            _html += '<span data-toggle="modal" onclick="News.viewNews(' + item.id + ')">' +
                            '<i class="fa ' + item.icon + '"></i>';
                            if (item.status == 2) {
                                _html += ' <b class="text-danger">' + item.title + '</b>';
                            } else if (item.status == 1) {
                                _html += ' <b class="text-warning">' + item.title + '</b>';
                            } else {
                                _html += item.title;
                            }
                            _html += '</span>';
                            _html += '<span class="pull-right actions-bar">' +
                            '<em class="text-muted small" data-toggle="modal" onclick="News.editNews(' + item.id + ')">Editează</em>' +
                            '<i class="fa fa-times text-danger" title="Șterge" data-toggle="modal" onclick="News.confirmDeleteNews(' + item.id + ')"></i>' +
                            '</span>';
                            _html += '<span class="pull-right time-bar">' +
                            '<em class="text-muted small">' + item.created_date + '</em>' +
                            '</span>' +
                            '</a>';
                        });
                        $("#btnEmptyNewsList").show();
                        $("#viewAllNews").show();
                    } else {
                        $("#btnEmptyNewsList").hide();
                        $("#viewAllNews").hide();
                        _html += '<p class="text-center no-announcement">Momentan nu este nici o alertă. </p>';
                    }

                    $("#newsList").html(_html);
                }
            }
        });

    },
    addNews: function () {
        Global.resetError();
        $.ajax({
            type: "POST",
            url: baseUrlCMS + "module/dashboard/dashboard.ajax.php",
            dataType: 'json',
            data: {
                op: 'addNews',
                formData: $('#addNewsForm').serialize()
            },
            success: function (response) {
                if (response.status == 'fail') {
                    Global.setError(response.message);
                } else {
                    $("#newsModal").modal('hide');
                    alert(response.message);
                    News.initNewsList(News.limit);
                }
            }
        });
    },
    editNews: function (id) {
        News.clearNewsModalFields();
        $("#newsModalTitle").html('Editează știre');
        News.fillNewsModal(id);
        $("#newsModal").modal('show');
    },
    fillNewsModal: function (id) {
        Global.resetError();
        $.ajax({
            type: "POST",
            url: baseUrlCMS + "module/dashboard/dashboard.ajax.php",
            dataType: 'json',
            data: {
                op: 'getNewsInfo',
                id: id
            },
            success: function (response) {
                if (response.status == 'fail') {
                    alert(response.message);
                } else {
                    var News = response.data;
                    $("#newsId").val(id);
                    $("#newsTitle").val(News.title);
                    $("#newsIcon").val(News.icon);
                    $("#newsIcon").selectpicker('refresh');
                    $("#newsMessage").val(News.message);
                    if (News.status == 1) {
                        $("#is_importat").prop('checked', true);
                    } else if (News.status == 2) {
                        $("#is_urgent").prop('checked', true);
                    }
                }
            }
        });
    },
    viewNews: function (id) {
        $.ajax({
            type: "POST",
            url: baseUrlCMS + "module/dashboard/dashboard.ajax.php",
            dataType: 'json',
            data: {
                op: 'getNewsInfo',
                id: id
            },
            success: function (response) {
                if (response.status == 'fail') {
                    alert(response.message);
                } else {
                    var News = response.data;
                    $("#lblNewsTitle").html(News.title);
                    $("#lblNewsMessage").html(News.message);
                    $("#lblNewsDate").html(News.created_date);
                    $("#viewNewsModal").modal('show');
                }
            }
        });
    },
    confirmDeleteNews: function (id) {
        $("#deletedNewsId").val(id);
        $("#deleteNewsModal").modal('show');
    },
    deleteNews: function () {
        var id = $("#deletedNewsId").val();
        $.ajax({
            type: "POST",
            url: baseUrlCMS + "module/dashboard/dashboard.ajax.php",
            dataType: 'json',
            data: {
                op: 'deleteNews',
                id: id
            },
            success: function (response) {
                if (response.status == 'fail') {
                    alert(response.message);
                } else {
                    $("#deleteNewsModal").modal('hide');
                    alert(response.message);
                    News.initNewsList(News.limit);
                }
            }
        });
    },
    emptyNewsList: function () {
        $.ajax({
            type: "POST",
            url: baseUrlCMS + "module/dashboard/dashboard.ajax.php",
            dataType: 'json',
            data: {
                op: 'emptyNewsList'
            },
            success: function (response) {
                if (response.status == 'fail') {
                    alert(response.message);
                } else {
                    $("#emptyNewsModal").modal('hide');
                    alert(response.message);
                    News.initNewsList(News.limit);
                }
            }
        });
    },
    clearNewsModalFields: function () {
        $("#newsModalTitle").html('Adaugă alertă');
        $("#newsId").val('');
        $("#newsTitle").val('');
        $("#newsIcon").val('fa-chevron-circle-right');
        $("#newsIcon").selectpicker('refresh');
        $("#newsMessage").val('');
        $("#is_importat").prop('checked', false);
        $("#is_urgent").prop('checked', false);
    }
};
