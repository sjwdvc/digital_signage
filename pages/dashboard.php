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
    <section class="text-gray-600 body-font flex flex-col h-screen box-border">
        <div class="flex justify-center max-h-full flex-grow">
            <img id="submissionImage" class="max-h-full max-w-full object-contain mb-5" alt="Placeholder Image" src="../public/img/placeholder.jpg">
        </div>
        <div class="max-w-7xl pt-2 mx-auto text-center">
            <h1 id="submissionName" class="text-3xl Avenir font-semibold text-gray-900"></h1>
            <h2 id="submissionDescription" class="mb-8 text-1xl Avenir font-semibold text-gray-600 text-center">Description here</h2>
        </div>
    </section>
<script>

    var submissionName = document.getElementById('submissionName');
    var submissionDescription = document.getElementById('submissionDescription');
    var submissionImage = document.getElementById('submissionImage');

    // Create a new WebSocket.
    var uploadUrl = '<?= env('uploadUrl') ?>';
    var uploadFolder = '<?= env('uploadFolder') ?>';
    var socket = new WebSocket('ws://<?php echo env("domain") ?>:<?php echo env("wsPort") ?>');

    submissionImage.src = '../public/img/placeholder.jpg';
    submissionName.innerHTML = `Upload your own submission through the url <span class="text-blue-500">${uploadUrl} </span>`;
    submissionDescription.innerText = "Try it! It's free! :-)";

    socket.onmessage = function (e) {
        console.log(e.data);
    }

    // function transmitMessage() {
    //     var description = document.getElementById('description');
    //
    //     console.log(description.value);
    //     socket.send(description.value);
    // }
</script>

</body>
</html>