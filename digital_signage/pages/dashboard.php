<?php
require_once('../../app/env_loader.php');
$pokeUri = env('pokeUri');
$timeout = env('timeout');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
<!--    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">-->
    <link href="../css/tw.min.css" rel="stylesheet">
    <title>Highlights</title>
</head>
<body>
<section class="text-gray-600 body-font h-screen flex flex-col pt-8 box-border">
    <div class="flex-1 overflow-hidden mb-5">
        <img id="submissionImage" alt="One of the images that was uploaded" src="../img/placeholder.jpg"
             class="object-contain h-full w-full">
    </div>
    <div class="flex flex-col flex-none max-w-7xl pt-2 mx-auto text-center">
        <h1 id="submissionName" class="text-3xl Avenir font-semibold text-gray-900"></h1>
        <h2 id="submissionDescription" class="mb-8 text-1xl Avenir font-semibold text-gray-600 text-center">Description
            here</h2>
    </div>

    <div class="pr-2">
        <p class="text-right">
            Upload your own submission through the url <span id="uploadUrlLink" class="text-blue-500"> </span>
        </p>
        <p class="text-right text-xs text-gray-500 pb-2">
            Made by <a class="underline text-blue-500" target="_blank" href="https://github.com/hectickaluha">Stefano Verhoeve</a> - SJW - 2023
        </p>
    </div>
</section>


<!--    <section class="text-gray-600 body-font flex flex-col h-screen max-h-screen box-border py-8">-->
<!--        <div class="flex flex-col flex-auto justify-center items-center mb-5">-->
<!--            <img id="submissionImage" class="object-contain h-full w-auto" alt="One of the images that was uploaded" src="../img/placeholder.jpg">-->
<!--        </div>-->
<!--        <div class="flex flex-col flex-none max-w-7xl pt-2 mx-auto text-center">-->
<!--            <h1 id="submissionName" class="text-3xl Avenir font-semibold text-gray-900"></h1>-->
<!--            <h2 id="submissionDescription" class="mb-8 text-1xl Avenir font-semibold text-gray-600 text-center">Description here</h2>-->
<!--        </div>-->
<!--    </section>-->
<script>

    var submissionName = document.getElementById('submissionName');
    var submissionDescription = document.getElementById('submissionDescription');
    var submissionImage = document.getElementById('submissionImage');
    var uploadUrlLink = document.getElementById('uploadUrlLink');

    // Create a new WebSocket.
    var httpProtocol = '<?php echo env("httpProtocol") ?>';
    var domain = '<?php echo env("domain") ?>';
    var subFolder = '<?php echo env("subFolder") ?>';
    var uploadUrl = '<?= env('uploadUrl') ?>';
    var uploadFolder = '<?= env('uploadFolder') ?>';
    var socket = new WebSocket('ws://<?php echo env("domain") ?>:<?php echo env("wsPort") ?>');

    var timeout = <?php echo $timeout ?>;

    setPlaceholder();

    socket.onmessage = function (e) {
        let message = JSON.parse(e.data);
        if (message.foundNew) {
            submissionImage.src = httpProtocol + domain + subFolder + uploadFolder + '/' + message.data.filename;
            submissionDescription.innerText = message.data.description;
            submissionName.innerText = message.data.name;
        } else {
            setPlaceholder();
        }
    }

    function setPlaceholder() {
        submissionImage.src = httpProtocol + domain + subFolder + '/img/placeholder.jpg';
        submissionName.innerHTML = `Upload your own submission through the url <span class="text-blue-500">${uploadUrl} </span>`;
        submissionDescription.innerText = "Try it! It's free! :-)";
        uploadUrlLink.innerText = uploadUrl;


    }

    function transmitMessage(message) {
        socket.send(message);
    }

    function pokeServer() {
        var pokeUri = '<?php echo $pokeUri ?>';
        var data = new FormData();
        data.append('poke', 'poke');

        fetch(pokeUri, {
            method: 'post',
            body: data
        });
    }

    setInterval(pokeServer, timeout * 1000);
</script>

</body>
</html>