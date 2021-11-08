<?php
require_once('env_loader.php');
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
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Upload your code!</title>
</head>
<body>
<?php
if (empty($_SESSION['user']) || $_SESSION['user'] == null) {
    ?>
    <section class="flex items-center h-screen justify-center flex-col">
        <h1 class="mb-5 text-6xl items-center Avenir xl:w-2/2 text-gray-900">First things first...</h1>
        <a href="app/authentication.php"
           class="inline-block p-4 bg-purple-600 text-white rounded-md shadow-md tracking-wide uppercase border border-blue cursor-pointer hover:bg-white hover:text-purple-600 ease-linear transition-all duration-150">
            Log in with your Da Vinci Account
        </a>
    </section>
<?php } else { ?>
    <?php
    if($_SESSION['login']){
        $_SESSION['login'] = null;
    ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: "You are logged in!",
        })
    </script>
    <?php } ?>

    <div>
        <div class="text-black">
            <section class="text-gray-600 body-font">
                <div class="max-w-7xl mx-auto flex px-5 pt-12 md:pt-36 md:flex-row flex-col items-center">
                    <div class="md:w-1/2 md:ml-24 py-6 flex flex-col md:items-start md:text-left items-center text-center">
                        <h1 class="mb-5 sm:text-6xl text-5xl items-center Avenir xl:w-2/2 text-gray-900">
                            Showcase your work</h1>
                        <p class="mb-4 xl:w-3/4 text-gray-600 text-lg">Here you can upload a screenshot or image of your
                            work. Work in progress or a finished product!</p>
                        <p class="mb-4 xl:w-3/4 text-gray-600 text-lg">Upload an image and optionally add a description.</p>

                        <label class="mb-2 text-left text-gray-500 w-3/4 md:w-full xl:w-3/4 xl:self-start md:self-center"
                               for="description">Description</label>
                        <textarea
                                class="form-textarea resize-none p-1 mb-4 border w-3/4 md:w-full xl:w-3/4 xl:self-start md:self-center"
                                id="description" placeholder="Type your description here..." name="description" maxlength="140" rows="3"></textarea>

                        <div class="flex justify-center">
                            <span class="inline-flex items-center px-5 py-3 mt-2 font-medium text-white transition duration-500 ease-in-out transform bg-transparent border rounded-lg bg-gray-900 hover:bg-gray-700 cursor-pointer" onclick="upload()">
                                <span class="justify-center">Send it to the screen!</span>
                            </span>
                            <a class="inline-flex items-center px-5 py-3 mt-2 font-medium text-white transition duration-500 ease-in-out transform bg-transparent border rounded-lg bg-gray-900 hover:bg-gray-700 cursor-pointer" href="app/authentication.php">
                                <span class="justify-center">Log in again</span>
                            </a>
                        </div>
                    </div>

                    <div class="md:mr-24 p-10 pb-28 md:ml-5 bg-contain bg-no-repeat"
                         style="background-image:url('public/img/monitor.png');">
                        <label class="w-64 flex flex-col items-center px-4 py-6 bg-white rounded-md shadow-md tracking-wide uppercase border border-blue cursor-pointer hover:bg-purple-600 hover:text-white text-purple-600 ease-linear transition-all duration-150">
                            <i class="fas fa-cloud-upload-alt fa-3x"></i>
                            <span class="mt-2 text-base leading-normal">Select an image</span>
                            <input id="file" type="file" class="hidden" accept=".png,.jpg,.jpeg,.gif"/>
                        </label>
                        <p class=" w-64 truncate overflow-hidden" id="fileInfo"></p>
                        <span class="text-sm text-red-500 font-bold" id="errorFile"></span>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script>
        document.getElementById('file').addEventListener('change', changeFileInfo, true)
        function upload(){
            var fetchUri = '<?php echo $fetchUrl ?>';
            var data = new FormData();
            data.append('file', document.getElementById('file').files[0]);
            data.append('description', document.getElementById('description').value);

            fetch(fetchUri, {
                method: 'post',
                body: data
            }).then(function(response){
                return response.json();
            }).then((data) => {
                console.log(data);
                if(data.success){
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
                }
                else if(!data.success && data.loginError){
                    Swal.fire({
                        icon: 'warning',
                        title: 'Sorry for the inconvenience',
                        text: data.errors.login,
                    })
                }
                else if(!data.success && !data.loginError){
                    Swal.fire({
                        icon: 'error',
                        title: 'There seems to be something wrong... :(',
                        text: data.message,
                    })
                }
                else{
                    Swal.fire({
                        icon: 'Info',
                        title: 'Forgot something?',
                        text: data.errors.errorFile,
                    })
                    for(property in data.errors){
                        document.getElementById(property).innerText = data.errors[property];
                    }

                }
            }).catch(function (error) {
                Swal.fire({
                    icon: 'error',
                    title: "Something went wrong whilst submitting your form",
                    text: error.message,
                    footer: 'Contact the developer.'
                })
            });
        }

        function clearValues(toClear){
            toClear.forEach(function(value, index){
                document.getElementById(value).value = '';
            });
        }
        function resetFileInput(name){
            document.getElementById(name).value = null;
        }
        function changeFileInfo(){
            document.getElementById('errorFile').innerText = '';
            document.getElementById('fileInfo').innerText = document.getElementById('file').files[0].name;
        }
        function emptyFileInfo(){
            document.getElementById('fileInfo').innerText = '';
        }
    </script>
<?php } ?>
</body>
</html>