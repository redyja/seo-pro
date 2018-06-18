@extends('layout')
@section('content-class', 'publishing')

@section('content')

    <script>
        Statamic.Publish = {
            contentData: {!! json_encode($data) !!},
            fieldset: {!! json_encode($fieldset) !!},
            suggestions: {!! json_encode($suggestions) !!}
        };
    </script>

    <publish
        title="{{ $title }}"
        submit-url="{{ route('seopro.defaults.update') }}"
        :update-title-on-save="false"
        content-type="addon"
        :meta-fields="false"
    ></publish>

@stop
