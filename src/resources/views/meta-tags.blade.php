@if($seo->values->isNotEmpty())
    @foreach($seo->values as $value)
        @if($value->content)
            @if($value->type == 'title')
                <title>{{ $value->content }}</title>
            @else
                <meta {{ $value->type }}="{{ $value->name }}" content="{{ $value->content }}">
            @endif
        @endif
    @endforeach
@endif