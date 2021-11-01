<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Upload your code!</title>
</head>
<body>


<script>
    // Create a new WebSocket.
    var socket  = new WebSocket('ws://'. <?php env('domain') ?>.':' . <?php env('wsPort') ?>);
    socket.onmessage = function(e) {
        alert( e.data );
    }

</script>


</body>
</html>