<section class="content container-fluid">
    <div class="row justify-content-end">
        <div class="d-flex col-md-3 justify-content-end">
            <button wire:click="toggleAddForm"
                class="btn btn-primary">{{ $showAddForm ? 'Close' : 'Add Notification' }}</button>
        </div>
    </div>
    <div class="row col-md-12 border border-2 rounded py-3 my-4 {{ $showAddForm ? 'd-block' : 'd-none' }}">
        <h4>Add new notification</h4>
        <form wire:submit="save">
            <div class="row">

                <div class="form-group col-md-4 mt-2">
                    <input type="text" name="title" wire:model.live="title" class="form-control" placeholder="Title">
                    @error('title') <span class="error">{{ $message }}</span> @enderror

                </div>
                <div class="form-group col-md-4 mt-2">
                    <select name="type" id="" wire:model.live="type" class="form-control">
                        <option value="">
                            <option value="">Select Type</option>
                            <option value="system">System</option>
                            <option value="marketing">Marketing</option>
                            <option value="invoices">Invoices</option>
                        </option>
                    </select>
                    @error('type') <span class="error">{{ $message }}</span> @enderror

                </div>
                <div class="form-group col-md-4 mt-2">
                    <input type="datetime-local" name="expiresAt" wire:model.live="expiresAt" class="form-control" placeholder="Expiry">
                    @error('expiresAt') <span class="error">{{ $message }}</span> @enderror

                </div>
                <div class="form-group col-md-4 mt-2">
                    <select name="selectedUser" class="form-control notif_users" wire:model="selectedUser">
                        <option value="all">All</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-12 mt-2">
                    <button class="btn btn-primary">Save</button>
                </div>
            </div>

        </form>
    </div>
    <div class="row col-md-12">
        <div class="row py-4">
            <div class="col-md-4">
                <select name="" id="" class="form-control" wire:model.live="filterType">
                    <option value="all">All</option>
                    <option value="system">System</option>
                    <option value="invoices">Invoices</option>
                    <option value="marketing">Marketing</option>
                </select>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" wire:model.live="filterSearch" placeholder="Search..">
            </div>
        </div>
        <table class="table">
            <thead>
                <th>S.No</th>
                <th>Title</th>
                <th>Type</th>
                <th>Expires At</th>
                <th>Created At</th>
                <th>Actions</th>
            </thead>
            <tbody>
                @foreach ($notifications as $key => $notification)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $notification->title }}</td>
                        <td>{{ $notification->type }}</td>
                        <td>{{ $notification->expires_at }}</td>
                        <td>{{ $notification->created_at }}</td>
                        <td>
                            <div>
                                <span wire:click="deleteNotification({{ $notification->id }})"
                                    class="pointer text-danger" title="Delete"><i class="fas fa-trash"></i></span>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $notifications->links() }}
    </div>
</section>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.notif_users').select2()
        });
    </script>
@endpush
