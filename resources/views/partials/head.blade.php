<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? config('app.name') }}</title>

<link rel="icon" href="/image/swooshico.png" sizes="any">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
<script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<!-- Script untuk download PNG -->



<style>
    [x-cloak] {
        display: none !important;
    }
</style>
@filamentStyles
@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
