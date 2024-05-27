<div class="card-body">
    <div class="d-flex justify-content-between">
        <div class="">
            {{ $slot }}
        </div>
        <div class="">
            @if(isset($right))
                {{ $right}}
            @endif
        </div>
    </div>
        
</div>
