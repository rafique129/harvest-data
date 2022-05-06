<!doctype html>
<html>
<title>Harvest Data Naib</title>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  @livewireStyles
  @livewireScripts
  <script src="{{ asset('js/turbolinks.js') }}"></script>
  <script src="{{ asset('js/turbolinks-adapter.js') }}" data-turbolinks-eval="false" data-turbo-eval="false"></script>
</head>
<body class="bg-gray-50">
    {{$slot}}
</body>
<script src="{{ asset('js/app.js')}}"></script>
</html>
