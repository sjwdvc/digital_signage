<?php
require_once('../env_loader.php');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <title>Highlights</title>
</head>
<body>
    <section class="bg-gray-200 text-gray-600 body-font flex flex-col h-screen box-border">
        <div class="max-w-7xl pt-2 mx-auto text-center">
            <h1 class="text-3xl Avenir font-semibold text-gray-900">Name here</h1>
            <h2 class="mb-8 text-1xl Avenir font-semibold text-gray-600 text-center">Description here</h2>
        </div>
        <div class="flex justify-center max-h-full flex-grow">
            <img class="max-h-full max-w-full object-contain mb-5" alt="Placeholder Image" src="https://via.placeholder.com/1050x750">
        </div>
    </section>
<script>
    // Create a new WebSocket.
    var socket = new WebSocket('ws://<?php echo env("domain") ?>:<?php echo env("wsPort") ?>');
    socket.onmessage = function (e) {
        alert(e.data);
    }

    function transmitMessage() {
        var description = document.getElementById('description');

        console.log(description.value);
        socket.send(description.value);
    }
</script>

</body>
</html>