<div class="col-md-12 col-lg-4">
    <div class="card ">
        <div class="card-body row">
            <div class="col-2">
                {{ $slot }}
            </div>
            <div class="col">
                <h6 class="mb-1">{{ $title }}</h6>
                <span><b>{{ $count }}</b></span>
            </div>
        </div>
    </div>
</div>
