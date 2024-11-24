@if (Session::get('success', false))
    <?php $data = Session::get('success'); ?>
    <div class="alert customize-alert alert-dismissible border-success text-dark fade show remove-close-icon">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="d-flex flex-column">
            <span>{{ $data }}</span>
        </div>
    </div>
@endif
@if (isset($errors) && count($errors) > 0)
    <div class="alert customize-alert alert-dismissible border-danger text-danger fade show remove-close-icon">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="d-flex flex-column">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </div>
    </div>
@endif
