<div class="modal-header">
    <h5 class="modal-title">{{$i ? "Edit" : "Tambah"}} {{$title}}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form action="#" method="#">
    <div class="modal-body">
        <div class="form-row">
            <div class="col-md-6 form-group">
                <label for="name">
                    Nama Role
                    <input class="form-control" type="text"/>
                </label>
            </div>
            <div class="col-md-6 form-group">
                <label for="name">
                    Nama Role
                    <input class="form-control" type="text"/>
                </label>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
    </div>
</form>
