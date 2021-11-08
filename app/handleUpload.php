<?php
require_once('../vendor/autoload.php');
require_once('connection.php');

session_start();

if (!empty($_SESSION['user']) || $_SESSION['user'] != null) {
    $response = validate($_POST, []);
    if ($response['success']) {
        try {
            $target_dir = "../" . env('uploadFolder');
            $imageFileType = strtolower(pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION));
            $newFileName = strtotime("now").str_replace(' ', '', $_SESSION['name']). '.' .$imageFileType;
            $target_file = $target_dir . $newFileName;

            // Check if image file is a actual image or fake image
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $check = finfo_file($finfo, $_FILES["file"]["tmp_name"]);

            if (in_array($check, ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'])) {
                // Check file size
                if ($_FILES["file"]["size"] <= 500000) {
                    // if everything is ok, try to upload file
                    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                        saveUploadToDatabase($newFileName, $_SESSION['user'], $response['data']['description'], $_SESSION['name']);
                        $response = [
                            'success' => true,
                            'loginError' => false,
                            'errors' => [],
                            'data' => [],
                            'message' => "Your submission was a success! Keep an eye on the screen!"
                        ];
                    } else {
                        $response = [
                            'success' => false,
                            'loginError' => false,
                            'errors' => [],
                            'data' => [],
                            'message' => "Sorry... There was something wrong with your submission, we couldn't upload your file."
                        ];
                    }
                }
                else{
                    $response = [
                        'success' => false,
                        'loginError' => false,
                        'errors' => [],
                        'data' => [],
                        'message' => "Sorry... Your file was too large in size (max 500000kb) ¯\_(ツ)_/¯"
                    ];
                }
            } else {
                $response = [
                    'success' => false,
                    'loginError' => false,
                    'errors' => [],
                    'data' => [],
                    'message' => "Oops... It looks like you didn't upload an image... ¯\_(ツ)_/¯"
                ];
            }
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'loginError' => false,
                'errors' => [],
                'data' => [],
                'message' => "Couldn't process the request...;" . $e->getMessage()
            ];
        }
    }
} else {
    $response = [
        'success' => false,
        'loginError' => true,
        'errors' => ['login' => 'Please log in (again) before trying that.'],
        'data' => [],
        'message' => 'Please log in (again) before trying that.'
    ];
}
echo json_encode($response);

function validate($post, $toCheck)
{
    $data = null;
    $errors = null;
    $valid = true;
    //loop over postvariable
    foreach ($post as $key => $value) {
        //check of gebruiker iets heeft ingevuld
        if ($value) {
            //clean input en zet in data
            $data[$key] = clean_input($value);
        } //anders zet error in error array en zet valid op false
        else {
            if (in_array($key, $toCheck)) {
                $errors['error' . ucfirst($key)] = "The $key field is mandatory.";
                $valid = false;
            }
        }
    }
    if (empty($_FILES['file'])) {
        $errors['errorFile'] = "You need to select a file to upload.";
        $valid = false;
    }
    //als valid return true met data
    if ($valid) {
        return [
            'success' => true,
            'loginError' => false,
            'errors' => [],
            'data' => $data,
            'message' => 'Your submission has been sent. Keep an eye on the screen ;).'
        ];
    } //anders return false met errors
    else {
        return [
            'success' => false,
            'loginError' => false,
            'errors' => $errors,
            'data' => $data,
            'message' => ''
        ];
    }
}

function clean_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}