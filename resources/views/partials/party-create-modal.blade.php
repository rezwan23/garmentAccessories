<div class="modal create-party-modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Party</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="create-party" action="{!! route('accounts.parties.store') !!}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="party_name">Name</label>
                        <input type="text" class="form-control" id="party_name" name="name" placeholder="Enter name">
                    </div>
                    <div class="form-group">
                        <label for="party_phone">Phone Number</label>
                        <input type="text" class="form-control" id="party_phone" name="phone" placeholder="Enter phone number">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>