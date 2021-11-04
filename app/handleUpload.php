<?php
session_start();

if(!empty($_SESSION['user']) || $_SESSION['user'] != null)
{
    $response = validate($_POST, []);
    if($response['success']){
        try{
            //TODO: UPLOAD FILE
            //TODO: Send to database
//            throw new Exception('This is a test');
        }
        catch(Exception $e){
            $response = [
                'success' => false,
                'loginError' => false,
                'errors' => [],
                'data' => [],
                'message' => "Couldn't process the request...;". $e->getMessage()
            ];
        }
    }
}
else{
    $response = [
        'success' => false,
        'loginError' => true,
        'errors' => ['login' => 'Please log in (again) before trying that.'],
        'data' => [],
        'message' => 'Please log in (again) before trying that.'
    ];
}
echo json_encode($response);

function validate($post, $toCheck){
    $data = null;
    $errors = null;
    $valid = true;
    //loop over postvariable
    foreach($post as $key => $value){
        //check of gebruiker iets heeft ingevuld
        if($value){
            //clean input en zet in data
            $data[$key] = clean_input($value);
        }
        //anders zet error in error array en zet valid op false
        else{
            if(in_array($key, $toCheck)){
                $errors['error'. ucfirst($key)] = "The $key field is mandatory.";
                $valid = false;
            }
        }
    }
    if(empty($_FILES['file'])){
        $errors['errorFile'] = "You need to select a file to upload.";
        $valid = false;
    }
    //als valid return true met data
    if($valid){
        return [
            'success' => true,
            'loginError' => false,
            'errors' => [],
            'data' => $data,
            'message' => 'Your submission has been sent. Keep an eye on the screen ;).'
        ];
    }
    //anders return false met errors
    else{
        return [
            'success' => false,
            'loginError' => false,
            'errors' => $errors,
            'data' => $data,
            'message' => ''
        ];
    }
}

function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}