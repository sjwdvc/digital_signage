<?php
session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" rel="stylesheet">
    <title>Upload your code!</title>
</head>
<body>
<?php
if (empty($_SESSION['user']) || $_SESSION['user'] == null) {
    ?>
    <a href="app/authentication.php"
       class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Log in with your Da Vinci Account
    </a>

<?php } else { ?>
    <h1 class="text-6xl font-normal leading-normal mt-0 mb-2 text-blue-400">Showcase your work!</h1>
    <h2>Upload your code...</h2>

    <label class="w-64 flex flex-col items-center px-4 py-6 bg-white rounded-md shadow-md tracking-wide uppercase border border-blue cursor-pointer hover:bg-purple-600 hover:text-white text-purple-600 ease-linear transition-all duration-150">
        <i class="fas fa-cloud-upload-alt fa-3x"></i>
        <span class="mt-2 text-base leading-normal">Select a file</span>
        <input type="file" class="hidden"/>
    </label>

    <label for="description">Description</label><br>
    <textarea id="description" name="description" maxlength="140" rows="15" style="width:100%"></textarea><br>


    <button onclick="transmitMessage('codeBlock')">Upload</button>

<?php } ?>

<div>
    <div class="text-black">
        <section class="text-gray-600 body-font">
            <div class="max-w-7xl mx-auto flex px-5 py-24 md:flex-row flex-col items-center">
                <div class="lg:flex-grow md:w-1/2 md:ml-24 pt-6 flex flex-col md:items-start md:text-left mb-40 items-center text-center">
                    <h1 class="mb-5 sm:text-6xl text-5xl items-center Avenir xl:w-2/2 text-gray-900">
                        Showcase your work</h1>
                    <p class="mb-4 xl:w-3/4 text-gray-600 text-lg">Here you can upload a screenshot or image of your
                        work. Work in progress or a finished product!</p>
                    <div class="flex justify-center"><a
                                class="inline-flex items-center px-5 py-3 mt-2 font-medium text-white transition duration-500 ease-in-out transform bg-transparent border rounded-lg bg-gray-900"
                                href="pages/dashboard.php"><span class="justify-center">View other's work</span></a>
                    </div>
                </div>
                <div class="xl:mr-44 sm:mr-0 sm:mb-28 mb-0 lg:mb-0 mr-48 md:pl-10">
                    <img class="w-100 md:ml-1 ml-24" alt="monitor" src="public/img/monitor.png">
                </div>
            </div>
        </section>

    </div>
</div>


</body>
</html>