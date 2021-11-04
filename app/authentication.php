<?php
require_once('../vendor/autoload.php');
require_once('../env_loader.php');

session_start();

$provider = new Stevenmaguire\OAuth2\Client\Provider\Microsoft([
    //'ObjectId'                  => env('objectId'),
    'clientId'                  => env('clientId'),
    'clientSecret'              => env('clientSecret'),
    'redirectUri'               => env('redirectUri'),

    'urlAuthorize'              => env('urlAuthorize'),
    'urlAccessToken'            => env('urlAccessToken'),
    'urlResourceOwnerDetails'   => env('urlResourceOwnerDetails')
]);

if (!isset($_GET['code'])) {
    // If we don't have an authorization code then get one
    $options = [
        'scope' => ['User.Read'] // array or string
    ];
    $authUrl = $provider->getAuthorizationUrl($options);
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: '.$authUrl);
    exit;
}
// Check given state against previously stored one to mitigate CSRF attack
elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
    unset($_SESSION['oauth2state']);
    exit('Invalid state');
}
else {
    // Try to get an access token (using the authorization code grant)
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    // Optional: Now you have a token you can look up a users profile data
    try {
        // We got an access token, let's now get the user's details
        //$user = $provider->getResourceOwner($token);
        $headers = [
            "Authorization" => "Bearer ". $token->getToken(),
            'Content-Type' => 'application/json'
        ];
        $client = new GuzzleHttp\Client();

        $response = $client->request('GET', env('urlResourceOwnerDetails'), ['headers' => $headers], ['debug' => true]);

        $data = json_decode($response->getBody()->getContents());

        printf('Logged in with %s!', $data->mail);
        $_SESSION['user'] = $data->mail;
        $_SESSION['name'] = $data->displayName;
//        echo $token->getToken();
        header('Location: ../index.php');
    }
    catch (Exception $e) {
        // Failed to get user details
        exit('Oh dear... contact the developer and include this message: ' . $e->getMessage());
    }
    // Use this to interact with an API on the users behalf
    //echo $token->getToken();
}
