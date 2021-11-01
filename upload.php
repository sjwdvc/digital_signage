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
<h1>Showcase your work!</h1>
<h2>Upload your code...</h2>

<label for="name">name</label><br>
<input type="text" id="name" style="width:100%"/><br>

<label>How do you want to submit your work?</label><br>
<div style="display:inline-block">
    <input type="radio" onclick="clickRadio('code')" id="codeRadio" name="submissionType" value="code">
    <label for="codeRadio">Code (text)</label>
</div>
<div style="display:inline-block">
    <input type="radio" onclick="clickRadio('image')" id="imageRadio" name="submissionType" value="image">
    <label for="imageRadio">Image</label>
</div>
<br>
<div id="typeContainer"></div>

<label for="description">Description</label><br>
<textarea id="description" name="description" rows="15" style="width:100%"></textarea><br>

<button onclick="transmitMessage('codeBlock')">Upload</button>

<script>
    // Create a new WebSocket.

    function transmitMessage() {
        var name = document.getElementById('name');
        var code = document.getElementById('code');
        var description = document.getElementById('description');

        console.log( name.value );
        socket.send( name.value );
    }


</script>

<script>
    var container = document.getElementById('typeContainer');

    function clickRadio(enableType){
        container.innerHTML = '';
        if(enableType === 'code'){
            container.innerHTML = `
                <label style="margin-top:15px" for="code">Code</label><br>
                <textarea id="code" name="code" rows="15" style="width:100%"></textarea><br>`;
        }
        else{
            container.innerHTML=`
                <input type="file" name="image" id="image"/><br>
                <button onclick="transmitMessage('imageUpload')">Upload</button>`;
        }

    }
</script>


</body>
</html>