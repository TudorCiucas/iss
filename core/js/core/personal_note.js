$(function () {
    PersonalNote.initButtonEvents();
    PersonalNote.selectChanges();
    PersonalNote.load();
});


var PersonalNote = {
    limit: 10,
    initButtonEvents: function () {
        $("#btnSavePersonalNote").click(function () {
            PersonalNote.add();
        });
        $("#btnShowPersonalNoteModal").click(function () {
            PersonalNote.cleanModalFields();
            $("#personalNoteModal").modal('show');
        });
        $("#btnEmptyPersonalNoteList").click(function () {
           $("#emptyPersonalNotesModal").modal('show');
        });
        $("#btnDeleteAllPersonalNotes").click(function () {
            PersonalNote.empty();
        });
        $("#btnDeletePersonalNote").click(function () {
            PersonalNote.delete();
        });
    },
    selectChanges: function () {
        $("#is_favourite").change(function () {
            if(document.getElementById("is_favourite").checked) {
                document.getElementById("is_memento").checked = false;
                document.getElementById("personalNoteMemoDate").disabled = true;
            }
        });
        $("#is_memento").change(function () {
            if(document.getElementById("is_memento").checked) {
                document.getElementById("is_favourite").checked = false;
                document.getElementById("personalNoteMemoDate").disabled = false;
            }
        });
    },
    load: function () {
        $.ajax({
            type: "POST",
            url: baseUrlCMS + "module/notite/notite.ajax.php",
            dataType: 'json',
            data: {
                op: 'getPersonalNotes',
                number: PersonalNote.limit
            },
            success: function (response) {
                if (response.status = 'ok') {
                    // Notite tab
                    $("#generalNotesTab").html(PersonalNote.buildTabContent(response.generalNotes));
                    // Favorite tab
                    $("#favouriteNotesTab").html(PersonalNote.buildTabContent(response.favouriteNotes));
                    // Memento tab
                    $("#memoNotesTab").html(PersonalNote.buildTabContent(response.memoNotes));
                }
            }
        });
    },
    buildTabContent: function (data) {
        var _html = '';
        _html += '<div class="list-group announcements-list">';
        var nrMemento = 0;
        if (data.length > 0) {
            $.each(data, function (key, item) {
                _html += '<a href="javascript:void(0);" class="list-group-item">';
                _html += '<span data-toggle="modal" onclick="PersonalNote.view(' + item.id + ')">' +
                '<i class="fa fa-circle-o ' + item.icon + '"></i>';
                if (item.is_favourite == 1) {
                    _html += ' <i class="fa fa-star text-fav"></i>';
                }
                _html += item.title;
                _html += '</span>';
                _html += '<span class="pull-right actions-bar">' +
                '<em class="text-muted small" data-toggle="modal" onclick="PersonalNote.edit(' + item.id + ')">Editează</em>' +
                '<i class="fa fa-times text-danger" title="Șterge" data-toggle="modal" onclick="PersonalNote.confirmDelete(' + item.id + ')"></i>';
                if (item.is_memento == 1) {
                    _html += '<span class="pull-right time-bar">' +
                    '<em class="text-muted small">' + item.created_date + '</em>' +
                    '</span>';

                    nrMemento++;
                }
                _html += '</a>';
            });
        } else {
            _html += '<p class="text-center no-announcement">Momentan nu aveți nici o notiță personală. </p>';
        }
        _html += '</div>';

        $("#nrMemento").html(nrMemento);

        return _html;
    },
    view: function (id) {
        $.ajax({
            type: "POST",
            url: baseUrlCMS + "module/notite/notite.ajax.php",
            dataType: 'json',
            data: {
                op: 'getPersonalNoteInfo',
                id: id
            },
            success: function (response) {
                if (response.status == 'fail') {
                    alert(response.message);
                } else {
                    var PersonalNoteItem = response.data;
                    $("#lblPersonalNoteTitle").html(PersonalNoteItem.title);
                    $("#lblPersonalNoteContent").html(PersonalNoteItem.content);
                    $("#lblPersonalNoteDate").html(PersonalNoteItem.created_date);
                    $("#viewPersonalNoteModal").modal('show');
                }
            }
        });
    },
    add: function () {
        PersonalNote.resetError();
        $.ajax({
            type: "POST",
            url: baseUrlCMS + "module/notite/notite.ajax.php",
            dataType: 'json',
            data: {
                op: 'addPersonalNote',
                formData: $('#addEditPersonalNoteForm').serialize()
            },
            success: function (response) {
                if (response.status == 'fail') {
                    PersonalNote.setError(response.message);
                } else {
                    $("#personalNoteModal").modal('hide');
                    alert(response.message);
                    PersonalNote.load(PersonalNote.limit);
                }
            }
        });
    },
    edit: function (id) {
        PersonalNote.cleanModalFields();
        $("#personalNoteModalTitle").html('Editează notiță');
        PersonalNote.fillModal(id);
        $('#personalNoteModal').modal('show');
    },
    fillModal: function (id) {
        PersonalNote.resetError();
        $.ajax({
            type: "POST",
            url: baseUrlCMS + "module/notite/notite.ajax.php",
            dataType: 'json',
            data: {
                op: 'getPersonalNoteInfo',
                id: id
            },
            success: function (response) {
                if (response.status == 'fail') {
                    PersonalNote.setError(response.message)
                } else {
                    var PersonalNoteItem = response.data;
                    $("#personalNoteId").val(id);
                    $("#personalNoteTitle").val(PersonalNoteItem.title);
                    $("#personalNoteIcon").val(PersonalNoteItem.icon);
                    $("#personalNoteIcon").selectpicker('refresh');
                    $("#personalNoteContent").val(PersonalNoteItem.content);
                    if (PersonalNoteItem.is_favourite == 1) {
                        $("#is_favourite").prop('checked', true);
                    }
                    if (PersonalNoteItem.is_memento == 1) {
                        $("#is_memento").prop('checked', true);
                        $("#personalNoteMemoDate").val(PersonalNoteItem.memo_date);
                    }
                }
            }
        });
    },
    confirmDelete: function (id) {
        $("#deletedPersonalNoteId").val(id);
        $("#deletePersonalNoteModal").modal('show');
    },
    delete: function () {
        var id = $("#deletedPersonalNoteId").val();
        $.ajax({
            type: "POST",
            url: baseUrlCMS + "module/notite/notite.ajax.php",
            dataType: 'json',
            data: {
                op: 'deletePersonalNote',
                id: id
            },
            success: function (response) {
                if (response.status == 'fail') {
                    alert(response.message);
                } else {
                    $("#deletePersonalNoteModal").modal('hide');
                    alert(response.message);
                    PersonalNote.load(PersonalNote.limit);
                }
            }
        });
    },
    empty: function () {
        $.ajax({
            type: "POST",
            url: baseUrlCMS + "module/notite/notite.ajax.php",
            dataType: 'json',
            data: {
                op: 'emptyPersonalNotes'
            },
            success: function (response) {
                if (response.status == 'fail') {
                    alert(response.message);
                } else {
                    $("#emptyPersonalNotesModal").modal('hide');
                    alert(response.message);
                    PersonalNote.load(PersonalNote.limit);
                }
            }
        });
    },
    cleanModalFields: function () {
        $("#personalNoteModalTitle").html('Adaugă notiță');
        $("#personalNoteId").val('');
        $("#personalNoteTitle").val('');
        $("#personalNoteIcon").val('');
        $("#personalNoteIcon").selectpicker('refresh');
        $("#personalNoteContent").val('');
        $("#is_favourite").prop('checked', false);
        $("#is_memento").prop('checked', false);
        $("#personalNoteMemoDate").val('');
    },
    setError: function (error) {
        $("#personalNoteFailText").html(error);
        this.toggleErrorDiv(true);
    },
    resetError: function () {
        $("#personalNoteFailText").html("");
        this.toggleErrorDiv(false);
    },
    toggleErrorDiv: function (toggle) {
        if (toggle) {
            $("#personalNoteErrorDiv").show();
        } else {
            $("#personalNoteErrorDiv").hide();
        }
    }
};
