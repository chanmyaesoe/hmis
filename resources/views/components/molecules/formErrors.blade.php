@if ($errors->any())
    <div class="alert alert-danger">
        <strong>There are some errors, please correct them below.</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif