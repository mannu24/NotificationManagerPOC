<section class="content container-fluid">
    <div class="row justify-content-end">
        <div class="d-flex col-md-3 justify-content-end">
            <button wire:click="toggleAddForm" class="btn btn-primary">{{ $showAddForm ? 'Close' : 'Add User' }}</button>
        </div>
    </div>
    <div class="row col-md-12 border border-2 rounded py-3 my-4 {{ $showAddForm ? 'd-block' : 'd-none' }}">
        <h4>{{ $editId ? 'Edit user' : 'Add new user' }}</h4>
        <form wire:submit="save">
            <div class="row">
                <div class="form-group col-md-4 mt-2">
                    <input type="text" name="name" wire:model.live="name" class="form-control" placeholder="Name">
                    @error('name') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group col-md-4 mt-2">
                    <input type="text" name="email" wire:model.live="email" class="form-control" placeholder="Email">
                    @error('email') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group col-md-4 mt-2">
                    <input type="text" name="mobile" wire:model.live="mobile" class="form-control" placeholder="Mobile">
                    @error('mobile') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group col-md-4 mt-3">
                    <label for="showNotification">Show Notifications ?</label>
                    <label class="switch" id="showNotification">
                        <input type="checkbox" {{ $showNotification ? 'checked' : '' }} value="on"
                            wire:click="toggleShowNotification">
                        <span class="slider round"></span>
                    </label>
                </div>
                <div class="form-group col-md-12 mt-3">
                    <button type="submit" class="btn btn-primary">{{ $editId ? 'Update' : 'Save' }}</button>
                </div>
            </div>

        </form>
    </div>
    <div class="row col-md-12">
        <div class="row py-4">
            <div class="col-md-4">
                <input type="text" class="form-control" wire:model.live="filterSearch" wire:modal.live="filterSearch" placeholder="Search..">
            </div>
        </div>
        <table class="table">
            <thead>
                <th>S.No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Unread Notifications</th>
                <th>Actions</th>
            </thead>
            <tbody>
                @foreach ($users as $key => $user)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td><a href="/user/{{$user->id}}" target="_blank">{{ $user->name }}</a></td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->mobile }}</td>
                        <td>{{ $user->unread_notifications }}</td>
                        <td>
                            <div class="d-flex justify-content-between">
                                <span wire:click="editUser({{ $user->id }})" class="pointer text-dark"
                                    title="Edit"><i class="fas fa-pencil"></i></span>
                                <span wire:click="deleteUser({{ $user->id }})" class="pointer text-danger"
                                    title="Delete"><i class="fas fa-trash"></i></span>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
        @php
            // dd($users);
        @endphp
    </div>
</section>
