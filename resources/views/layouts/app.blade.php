<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blog App</title>

    <!-- Bootstrap -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}"  rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <style>
        .padding-off {
            padding: 0 !important;
        }
        .img-responsive {
            box-shadow: 0 0 0 2px #50c0e9;
        }
        .padding-left-off {
            padding-left: 0 !important;
        }
        .theme-clr {
            color: #50c0e9;
        }
        .text-red {
            color: #a94442;
        }
    </style>
    @yield('style')
</head>
<body>
<header>
    <div class="container">
        <div class="row">
            <nav class="navbar navbar-default" role="navigation">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <div class="navbar-brand">
                            <a href="{{ url('/') }}"><h1>Blog</h1></a>
                        </div>
                    </div>
                    <div class="menu">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" {!! (Request::is('/') ? 'class="active"' : '') !!}>
                                <a href="{{ url('/') }}">Home</a>
                            </li>
                            <li role="presentation" {!! (Request::is('blog') ? 'class="active"' : '') !!}>
                                <a href="{{ route('blog.list') }}">Blog</a>
                            </li>
                            <li role="presentation" {!! (Request::is('category') ? 'class="active"' : '') !!}>
                                <a href="{{ route('category.list') }}">Categories</a>
                            </li>
                            <li role="presentation" {!! (Request::is('country') ? 'class="active"' : '') !!}>
                                <a href="{{ route('country.list') }}">Countries</a>
                            </li>
                            <li role="presentation">
                                <a href="javascript:;">
                                    <div id="google_translate_element"></div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>

@yield('content')

<!--start footer-->
<footer>
    <div class="container">
        <div class="row">
            <hr>
        </div>
    </div>
</footer>
<!--end footer-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="{{ asset('assets/js/jquery.js') }}"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/wow.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/1.3.4/vue-resource.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.17.1/axios.js"></script>

@yield('script')
<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
    }
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

</body>
</html>