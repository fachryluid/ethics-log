<form action="{{ $action ?? '#' }}" method="{{ $method && $method == 'GET' ? 'GET' : 'POST' }}" enctype="{{ $enctype ?? '' }}" class="form form-horizontal">
  @csrf
  @method($method ?? 'POST')
  <div class="form-body">
    <div class="row">
      {{ $slot }}
      <div class="col-md-4"></div>
      <div class="col-md-8">
        <button type="submit" class="btn btn-primary w-100 mt-2">{{ $submitText ?? 'Submit' }}</button>
      </div>
    </div>
  </div>
</form>