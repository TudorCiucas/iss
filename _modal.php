<!-- Add news -->
<div class="modal fade" id="newsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="newsModalTitle">Adaugă alertă</h4>
            </div>
            <form id="addNewsForm" method="POST">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="alert alert-danger" id="errorDiv" style="display: none">
                            <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <i class="fa fa-exclamation-circle"></i><strong> Error list:</strong>

                            <div id="failText"></div>
                        </div>
                        <input type="hidden" name="newsId" id="newsId">
                        <div class="form-group">
                            <label>Titlu alertă</label>

                            <div class="row">
                                <div class="col-xs-2">
                                    <select class="selectpicker" data-width="55px" name="newsIcon" id="newsIcon">
                                        <option data-content='<i class="fa fa-chevron-circle-right"></i>'
                                                value="fa-chevron-circle-right"></option>
                                        <option data-content='<i class="fa fa-calendar"></i>'
                                                value="fa-calendar"></option>
                                        <option data-content='<i class="fa fa-check"></i>' value="fa-check"></option>
                                        <option data-content='<i class="fa fa-comments-o"></i>'
                                                value="fa-comments-o"></option>
                                        <option data-content='<i class="fa fa-envelope"></i>'
                                                value="fa-envelope"></option>
                                        <option data-content='<i class="fa fa-users"></i>' value="fa-users"></option>
                                        <option data-content='<i class="fa fa-exclamation-triangle"></i>'
                                                value="fa-exclamation-triangle"></option>
                                        <option data-content='<i class="fa fa-info-circle"></i>'
                                                value="fa-info-circle"></option>
                                        <option data-content='<i class="fa fa-bar-chart"></i>'
                                                value="fa-bar-chart"></option>
                                        <option data-content='<i class="fa fa-file"></i>' value="fa-file"></option>
                                        <option data-content='<i class="fa fa-inbox"></i>' value="fa-inbox"></option>
                                        <option data-content='<i class="fa fa-gift"></i>' value="fa-gift"></option>
                                        <option data-content='<i class="fa fa-globe"></i>' value="fa-globe"></option>
                                    </select>
                                </div>
                                <div class="col-xs-10">
                                    <input type="text" required name="newsTitle" id="newsTitle" class="form-control"/>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <label>Utilizator</label>
                            <select class="form-control selectpicker" name="user_id" id="user_id">
                                <?php
                                    $user = new User();
                                    $userData = $user->get(false,array(),array('field' => 'nume', 'dir' => 'asc'));
                                    foreach ($userData as $item) {
                                        echo "<option value='" . $item['id'] . "'>" . $item['nume'] . "</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="comment">Conținut</label>
                            <textarea class="form-control" placeholder="Maxim 1000 caractere" name="newsMessage"
                                      id="newsMessage" rows="5"></textarea>
                        </div>
                        <hr>
                        <div class="form-group">
                            <div class="checkbox">
                                <label><input type="checkbox" name="is_urgent" id="is_urgent" value="2">
                                    <span class="text-danger">Marchează alerta ca urgent</span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <label><input type="checkbox" name="is_important" id="is_important" value="1"><span
                                        class="text-warning">Marchează alerta ca important</span></label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Renunță</button>
                <button type="button" class="btn btn-success btn-sm" id="btnPublishNews">Publică</button>
            </div>
        </div>
    </div>
</div>

<!-- View news -->
<div class="modal fade" id="viewNewsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="lblNewsTitle"></h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <span id="lblNewsMessage"></span>
                    <hr>
                    <em>Publicat de către <b>Administrator</b> în data de <b id="lblNewsDate"></b>.</em>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Închide</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete news -->
<div class="modal fade" id="deleteNewsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Ești sigur că vrei să ștergi știrea?</h4>
            </div>
            <input type="hidden" id="deletedNewsId" name="deletedNewsId">
            <div class="modal-body">
                <div class="btn-group btn-group-justified">
                    <a href="javascript:void(0);" class="btn btn-default btn-sm" data-dismiss="modal">Renuță</a>
                    <a href="javascript:void(0);" class="btn btn-danger btn-sm" id="btnDeleteNews">Șterge</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete all news from list -->
<div class="modal fade" id="emptyNewsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Ești sigur că vrei să golesti lista cu știri?</h4>
            </div>
            <div class="modal-body">
                <div class="btn-group btn-group-justified">
                    <a href="javascript:void(0);" class="btn btn-default btn-sm" data-dismiss="modal">Renuță</a>
                    <a href="javascript:void(0);" class="btn btn-danger btn-sm" id="btnDeleteAllNews">Șterge</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- View notice -->
<div class="modal fade" id="viewPersonalNoteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="lblPersonalNoteTitle"></h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <span id="lblPersonalNoteContent"></span>
                    <hr>
                    <em>Creat în data de <b id="lblPersonalNoteDate"></b>.</em>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Închide</button>
            </div>
        </div>
    </div>
</div>

<!-- Add notice -->
<div class="modal fade" id="personalNoteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="personalNoteModalTitle">Adaugă notiță</h4>
            </div>
            <form id="addEditPersonalNoteForm" method="POST">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="alert alert-danger" id="personalNoteErrorDiv" style="display: none">
                            <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <i class="fa fa-exclamation-circle"></i><strong> Error list:</strong>

                            <div id="personalNoteFailText"></div>
                        </div>
                        <input type="hidden" name="personalNoteId" id="personalNoteId">
                        <div class="form-group">
                            <label>Titlu</label>

                            <div class="row">
                                <div class="col-xs-2">
                                    <select class="selectpicker no-border" data-width="55px" name="personalNoteIcon" id="personalNoteIcon">
                                        <option data-content='<i class="fa fa-circle-o"></i>' value=""></option>
                                        <option data-content='<i class="fa fa-circle-o text-primary"></i>' value="text-primary"></option>
                                        <option data-content='<i class="fa fa-circle-o text-info"></i>' value="text-info"></option>
                                        <option data-content='<i class="fa fa-circle-o text-success"></i>' value="text-success"></option>
                                        <option data-content='<i class="fa fa-circle-o text-warning"></i>' value="text-warning"></option>
                                        <option data-content='<i class="fa fa-circle-o text-danger"></i>' value="text-danger"></option>
                                    </select>
                                </div>
                                <div class="col-xs-10">
                                    <input type="text" required name="personalNoteTitle" id="personalNoteTitle" class="form-control"/>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="comment">Conținut</label>
                            <textarea class="form-control" placeholder="Maxim 1000 caractere" name="personalNoteContent"
                                      id="personalNoteContent" rows="5"></textarea>
                        </div>
                        <hr>
                        <div class="form-group">
                            <div class="checkbox">
                                <label><input type="checkbox" name="is_favourite" id="is_favourite">
                                    <span class="text-warning">Adaugă la favorite</span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <label><input type="checkbox" name="is_memento" id="is_memento">
                                    <span class="text-danger">Crează un memento</span>
                                </label>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label>Reamintește-mi în data de</label>
                            <input type="text" required name="personalNoteMemoDate" id="personalNoteMemoDate" class="form-control" disabled />
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Renunță</button>
                <button type="button" class="btn btn-success btn-sm" id="btnSavePersonalNote">Salvează</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete personal note -->
<div class="modal fade" id="deletePersonalNoteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Ești sigur că vrei să ștergi notița personală?</h4>
            </div>
            <input type="hidden" id="deletedPersonalNoteId" name="deletedPersonalNoteId">
            <div class="modal-body">
                <div class="btn-group btn-group-justified">
                    <a href="javascript:void(0);" class="btn btn-default btn-sm" data-dismiss="modal">Renuță</a>
                    <a href="javascript:void(0);" class="btn btn-danger btn-sm" id="btnDeletePersonalNote">Șterge</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Delete all personal notes from list -->
<div class="modal fade" id="emptyPersonalNotesModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Ești sigur că vrei să stergi toate notitele personale?</h4>
            </div>
            <div class="modal-body">
                <div class="btn-group btn-group-justified">
                    <a href="javascript:void(0);" class="btn btn-default btn-sm" data-dismiss="modal">Renuță</a>
                    <a href="javascript:void(0);" class="btn btn-danger btn-sm" id="btnDeleteAllPersonalNotes">Șterge</a>
                </div>
            </div>
        </div>
    </div>
</div>