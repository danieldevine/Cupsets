<!doctype html>
<html lang="en">
<x-head :title="$title"></x-head>
<body>
<x-titlebar :title="$title"></x-titlebar>
<main>
    <x-slot></x-slot>
</main>
<x-foot></x-foot>
</body>
</html>
