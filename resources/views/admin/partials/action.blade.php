<div class="d-inline-block flex">
    <button class="btn btn-success btn-sm edit-btn" data-id="{{ $user->id }}" data-usertype="{{ $user->usertype }}" data-jabatan="{{ $user->jabatan }}">
        <i class="fa fa-edit"></i>
    </button>
    <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $user->id }}">
        <i class="fa fa-trash"></i>
    </button>
</div>
