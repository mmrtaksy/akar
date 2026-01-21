<li class="dd-item" data-id="{{ $item->id }}">
    <div class="dd-handle dd3-handle" style="height: 30px;"></div>
    <div class="dd3-content">
        <a href="{{ route('servicesUpdateGet', ['id' => $item->id, 'lang' => 1, 'model_id' => $modelId]) }}">{{ $item->title }}</a>
    </div>

    @if ($item->childrenadmin && $item->childrenadmin->isNotEmpty())
        <ol class="dd-list">
            @foreach ($item->childrenadmin as $child)
                @include('xadmin.pages.services.partials.nestable-item', ['item' => $child])
            @endforeach
        </ol>
    @endif
</li>
