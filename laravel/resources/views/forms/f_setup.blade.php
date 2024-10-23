@extends('layouts.app_setup')
@section('content')
@endsection
@section('script')
    <div class="container">
        <div class="row pt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pt-2 pb-0">
                        <h3> <i class="fa fa-th-list" aria-hidden="true"></i> {{ $form_tittle }}</h3>
                    </div>
                    <form action="{{ $route }}" method="{{ $method }}" enctype="multipart/form-data">
                        <div class="card-body pt-1">
                            @csrf
                            @foreach ($form_content as $field)
                                <div class="form-group">
                                    @if (
                                        $field['type'] !== 'hidden')
                                    <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                                    @endif
                                    @if (
                                        $field['type'] === 'text' ||
                                            $field['type'] === 'password' ||
                                            $field['type'] === 'email' ||
                                            $field['type'] === 'search' ||
                                            $field['type'] === 'tel' ||
                                            $field['type'] === 'url' ||
                                            $field['type'] === 'number' ||
                                            $field['type'] === 'range' ||
                                            $field['type'] === 'date' ||
                                            $field['type'] === 'datetime-local' ||
                                            $field['type'] === 'month' ||
                                            $field['type'] === 'week' ||
                                            $field['type'] === 'time')
                                        <input type="{{ $field['type'] }}" id="{{ $field['name'] }}"
                                            name="{{ $field['name'] }}" class="form-control" value="{{ $field['value'] }}"
                                            required>
                                    @elseif ($field['type'] === 'textarea')
                                        <textarea id="{{ $field['name'] }}" name="{{ $field['name'] }}" class="form-control" rows="3" required>{{ $field['value'] }}</textarea>
                                    @elseif ($field['type'] === 'checkbox')
                                        @foreach ($field['options'] as $option)
                                            <div class="form-check">
                                                <input type="checkbox" id="{{ $field['name'] }}_{{ $loop->index }}"
                                                    name="{{ $field['name'] }}[]" class="form-check-input"
                                                    value="{{ $option['value'] }}"
                                                    {{ $option['checked'] ? 'checked' : '' }} required>
                                                <label class="form-check-label"
                                                    for="{{ $field['name'] }}_{{ $loop->index }}">{{ $option['label'] }}</label>
                                            </div>
                                        @endforeach
                                    @elseif ($field['type'] === 'radio')
                                        @foreach ($field['options'] as $option)
                                            <div class="form-check">
                                                <input type="radio" id="{{ $field['name'] }}_{{ $loop->index }}"
                                                    name="{{ $field['name'] }}" class="form-check-input"
                                                    value="{{ $option['value'] }}"
                                                    {{ $option['value'] === $field['value'] ? 'checked' : '' }} required>
                                                <label class="form-check-label"
                                                    for="{{ $field['name'] }}_{{ $loop->index }}">{{ $option['label'] }}</label>
                                            </div>
                                        @endforeach
                                    @elseif ($field['type'] === 'select')
                                        <select id="{{ $field['name'] }}" name="{{ $field['name'] }}" class="form-control"
                                            required>
                                            <option value="" disabled>Select {{ $field['label'] }}</option>
                                            @foreach ($field['options'] as $option)
                                                <option value="{{ $option['value'] }}"
                                                    {{ $option['value'] === $field['value'] ? 'selected' : '' }}>
                                                    {{ $option['label'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @elseif ($field['type'] === 'file')
                                        <input type="file" id="{{ $field['name'] }}" name="{{ $field['name'] }}"
                                            class="form-control-file">
                                    @elseif ($field['type'] === 'submit' || $field['type'] === 'reset' || $field['type'] === 'button')
                                        <button type="{{ $field['type'] }}"
                                            class="btn btn-primary">{{ $field['label'] }}</button>
                                    @elseif ($field['type'] === 'color')
                                        <input type="color" id="{{ $field['name'] }}" name="{{ $field['name'] }}"
                                            class="form-control" required>
                                    @elseif ($field['type'] === 'hidden')
                                        <input type="hidden" id="{{ $field['name'] }}" name="{{ $field['name'] }}"
                                            value="{{ $field['value'] }}">
                                    @elseif ($field['type'] === 'image')
                                        <input style="height: 50px;" type="image" src="{{ $field['value'] }}"
                                            alt="{{ $field['label'] }}" class="img-fluid" >
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <div class="card-footer text-right">
                            <a href="{{ url()->previous() }}" class="btn btn-warning" style="width: 100px">Go Back</a>
                            <button type="submit" class="btn btn-primary" style="width: 100px">{{ $button_text }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
