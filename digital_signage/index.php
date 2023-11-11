<?php
require_once('../app/env_loader.php');
session_start();
$fetchUrl = env('fetchUri');
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!--    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">-->
    <link href="css/tw.min.css" rel="stylesheet">
    <!--    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>-->
    <script src="script/sa.min.js"></script>
    <title>Upload your code!</title>
</head>
<body>
<?php
if(empty($tenantId)){
    $names = ['Pieter Jan', 'Klaas Vaak', 'Alexandro Verrebrug', 'Sinclair Ewo', 'Alessandra Visser'];
    $randomKey = array_rand($names);

    $_SESSION['user'] = str_replace(' ', '', $names[$randomKey]).'@mydavinci.nl';
    $_SESSION['name'] = $names[$randomKey];
    $_SESSION['login'] = true;
}

if (empty($_SESSION['user']) || $_SESSION['user'] == null) {
    ?>
    <section class="flex items-center h-screen justify-center flex-col">
        <h1 class="mb-5 text-6xl items-center Avenir xl:w-2/2 text-gray-900">First things first...</h1>
        <a href="<?= env('httpProtocol') . env('domain') . env('subFolder') . env('pagesFolder') ?>/authentication.php"
           class="inline-block p-4 bg-purple-600 text-white rounded-md shadow-md tracking-wide uppercase border border-blue cursor-pointer hover:bg-white hover:text-purple-600 ease-linear transition-all duration-150">
            Log in with your Da Vinci Account
        </a>
    </section>
<?php } else { ?>
<?php
if ($_SESSION['login']){
$_SESSION['login'] = null;
?>
    <script>
        Swal.fire({
            icon: 'success',
            title: "You are logged in!",
        })
    </script>
<?php } ?>
    <section class="min-h-screen flex flex-col justify-center">
        <div class="flex-1 h-full text-black text-gray-600 body-font flex flex-col items-center justify-center mx-auto md:flex-row p-6 lg:w-5/6 xl:w-3/4">
            <div class="px-4 flex flex-col md:items-start w-full sm:w-4/5 md:text-left mb-4">
                <h1 class="mb-5 sm:text-6xl text-5xl Avenir xl:w-2/2 text-gray-900">
                    Showcase your work</h1>
                <p class="mb-4 xl:w-3/4 text-gray-600 text-lg">Here you can upload a screenshot or image of your
                    work. Work in progress or a finished product!</p>
                <p class="mb-4 xl:w-3/4 text-gray-600 text-lg">Upload an image and optionally add a
                    description.</p>

                <label class="mb-2 text-left text-gray-500 w-full xl:self-start md:self-center"
                       for="description">Description</label>
                <textarea
                        class="form-textarea resize-none p-1 mb-4 border w-full xl:self-start md:self-center"
                        id="description" placeholder="Type your description here..." name="description"
                        maxlength="140" rows="3"></textarea>
                <span class="text-sm text-red-500 font-bold" id="errorDescription"></span>

                <div class="flex w-full justify-end">
                            <span class="mr-2 inline-flex items-center px-5 py-3 mt-2 font-medium text-white transition duration-150 ease-in-out transform bg-transparent border rounded-lg bg-gray-900 hover:bg-gray-700 cursor-pointer"
                                  onclick="upload()">
                                <span class="justify-center">Send it to the screen!</span>
                            </span>
                    <a class="inline-flex items-center px-5 py-3 mt-2 font-medium text-white transition duration-150 ease-in-out transform bg-transparent border rounded-lg bg-gray-900 hover:bg-gray-700 cursor-pointer"
                       href="pages/authentication.php">
                        <span class="justify-center">Log in again</span>
                    </a>
                </div>
            </div>


            <div class="p-10 pb-28 md:ml-5 bg-contain bg-no-repeat"
                 style="background-image:url('img/monitor.png');">
                <label class="w-64 flex flex-col items-center px-4 py-6 bg-white rounded-md shadow-md tracking-wide uppercase border border-blue cursor-pointer hover:bg-purple-600 hover:text-white text-purple-600 ease-linear transition-all duration-150">
                    <!--                            <i class="fas fa-cloud-upload-alt fa-3x"></i>-->
                    <svg class="h-12 fill-current" xmlns="http://www.w3.org/2000/svg" height="1em"
                         viewBox="0 0 640 512">
                        <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path d="M144 480C64.5 480 0 415.5 0 336c0-62.8 40.2-116.2 96.2-135.9c-.1-2.7-.2-5.4-.2-8.1c0-88.4 71.6-160 160-160c59.3 0 111 32.2 138.7 80.2C409.9 102 428.3 96 448 96c53 0 96 43 96 96c0 12.2-2.3 23.8-6.4 34.6C596 238.4 640 290.1 640 352c0 70.7-57.3 128-128 128H144zm79-217c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l39-39V392c0 13.3 10.7 24 24 24s24-10.7 24-24V257.9l39 39c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-80-80c-9.4-9.4-24.6-9.4-33.9 0l-80 80z"/>
                    </svg>
                    <span class="mt-2 text-base leading-normal">Select an image</span>
                    <input id="file" type="file" class="hidden" accept=".png,.jpg,.jpeg,.gif"/>
                </label>
                <p class="w-64 truncate overflow-hidden" id="fileInfo"></p>
                <span class="text-sm text-red-500 font-bold" id="errorFile"></span>
            </div>
        </div>
        <p class="text-right text-xs text-gray-500 pr-2 pb-2">
            Made by <a class="underline text-blue-500" target="_blank" href="https://github.com/hectickaluha">Stefano Verhoeve</a> - SJW - 2023
        </p>
    </section>

    <script>
        document.getElementById('file').addEventListener('change', changeFileInfo, true)
        document.getElementById('description').addEventListener('change', emptyDescriptionError, true)


        // This function takes the values from the form, sends them to the server, and displays possible messages from the server
        function upload() {
            var file = document.getElementById('file').files[0];
            if (file) {
                if (file.size < 500000) {
                    // This variable is defined at the top of the page
                    // This variable is the url for the Post request
                    var fetchUri = '<?php echo $fetchUrl ?>';
                    var data = new FormData();
                    data.append('file', file);
                    data.append('description', document.getElementById('description').value);

                    fetch(fetchUri, {
                        method: 'post',
                        body: data
                    }).then(function (response) {
                        return response.json();
                    }).then((data) => {
                        if (data.success) {
                            // clearFields(['qfFullNameError', 'qfEmailError', 'qfMessageError', 'qfCheckSError']);
                            clearValues(['description']);
                            resetFileInput('file');
                            Swal.fire({
                                icon: 'success',
                                title: data.message,
                                showConfirmButton: false,
                                timer: 3000,
                            });
                            emptyFileInfo();
                        } else if (!data.success && data.loginError) {
                            swalAlert('warning', 'Sorry for the inconvenience', data.errors.login);
                        } else if (!data.success && !data.loginError && data.errors.length === 0) {
                            swalAlert('error', 'There seems to be something wrong... :(', data.message);
                        } else {
                            swalAlert('info', 'Forgot something?', data.errors.errorFile);
                            showErrors(data.errors);
                        }
                    }).catch(function (error) {
                        Swal.fire({
                            icon: 'error',
                            title: "Something went wrong whilst submitting your form",
                            text: error.message,
                            footer: 'Contact the developer.'
                        })
                    });
                } else {
                    swalAlert('error', 'The file is too large... :(', 'The size of the file you selected is too big... Select a smaller image please.')
                }
            } else {
                swalAlert('info', 'Forgot something?', 'You need to select a file!');
                showErrors({'errorFile': 'You need to select a file to upload.'});
            }
        }

        function swalAlert(icon, title, text = '') {
            Swal.fire({
                icon: icon,
                title: title,
                text: text,
            })
        }

        function clearValues(toClear) {
            toClear.forEach(function (value, index) {
                document.getElementById(value).value = '';
            });
        }

        function resetFileInput(name) {
            document.getElementById(name).value = null;
        }

        function changeFileInfo() {
            document.getElementById('errorFile').innerText = '';
            document.getElementById('fileInfo').innerText = document.getElementById('file').files[0].name;
        }

        function emptyFileInfo() {
            document.getElementById('fileInfo').innerText = '';
        }

        function emptyDescriptionError() {
            document.getElementById('errorDescription').innerText = '';
        }

        function showErrors(errors) {
            for (property in errors) {
                document.getElementById(property).innerText = errors[property];
            }
        }
    </script>
<?php } ?>
</body>
</html>