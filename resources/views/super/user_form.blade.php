<div class="modal-header">
    <h5 class="modal-title">Add {{$title}}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form action="{{route('super.user.store')}}" method="POST">
        @csrf
        <div class="form-row">
            <div class="col-md-12 form-group">
                <label for="name">
                    Name
                </label>
                <input id="name" name='name' value="{{@$data['name']}}" class="form-control" type="text"/>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-6 form-group">
                <label for="username">
                    Username
                </label>
                <input id="username" name='username' value="{{@$data['username']}}" class="form-control" type="text"/>
            </div>
            <div class="col-md-6 form-group">
                <label for="password">
                    Password
                </label>
                <input id="password" name='password' value="{{$data['password']}}" class="form-control" type="password"/>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-12 form-group">
                <label for="role">
                    Role
                </label>
                <select id="role" name="role_id" class="form-control">
                    @foreach($listRole as $role)
                        <option value="{{@$role->id}}">{{@$role->name}}</option>
                    @endforeach
                </select>
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
