@extends('layouts.app')

@section('content')
        <!-- Responsive slider - START -->
@if (Session::has('success'))
    <div class="container" id="notification_div">
        <div class="row">
            <div class="col-md-4" style="float: none; margin: 0 auto;">
                <div class="alert alert-success text-center">
                    {{ Session::get('success') }}
                </div>
            </div>
        </div>
    </div>
@endif

<div class="container">
    <div class="row">
        This is Application Home Page.
    </div>
</div>

@endsection

@section('script')
    <script>

    </script>
@endsection