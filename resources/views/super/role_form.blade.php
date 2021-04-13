<div class="modal-header">
    <h5 class="modal-title">Add {{$title}}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form action="{{route('super.role.store')}}" method="POST">
        @csrf
        <div class="form-row">
            <div class="col-md-12 form-group">
                <label for="name">
                    Role Name
                </label>
                <input id="name" name='name' value="{{@$data['name']}}" class="form-control" type="text"/>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-5 offset-7 pt-3 form-group">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </form>
</div>
