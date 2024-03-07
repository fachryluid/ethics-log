@foreach ($options as $option)
	@if ($value == $option->value)
		<span class="badge {{ 'text-bg-' . $option->type }}">{{ $option->text ?? $value }}</span>
	@endif
@endforeach
