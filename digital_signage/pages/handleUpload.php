<?php
require_once('../../app/env_loader.php');
require_once('../../app/vendor/autoload.php');

use App\DBConnection;

session_start();
$dbConnection = new DBConnection();

if (!empty($_SESSION['user'])) {
    $response = validate($_POST, []);

    if($response['success']) {
        try {
            $target_dir = env('httpProtocol') . env('domain') . env('subFolder'). env('appFolder').env('uploadFolder');
            $imageFileType = strtolower(pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION));
            $newFileName = strtotime("now") . str_replace(' ', '', $_SESSION['name']) . '.' .$imageFileType;
            $target_file = '../uploads/'. $newFileName;

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $check = finfo_file($finfo, $_FILES["file"]["tmp_name"]);

            if (in_array($check, ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'])) {
                // Check file size
                if ($_FILES["file"]["size"] <= 3000000) {
//                    // if everything is ok, try to upload file
                    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                        $dbConnection->saveUploadToDatabase($newFileName, $_SESSION['user'], $_SESSION['name'], empty($response['data']['description']) ? null : $response['data']['description']);
                        $response = [
                            'success' => true,
                            'loginError' => false,
                            'errors' => [],
                            'data' => [],
                            'message' => "Your submission was successful! Keep an eye on the screen!"
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
                'message' => "Couldn't process the request...;",
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
    return htmlspecialchars($data);
}