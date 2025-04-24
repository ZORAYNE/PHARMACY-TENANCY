<?php

namespace App\Http\Controllers;

use Google\Client;
use Illuminate\Http\Request;

class GmailController extends Controller
{
    public function redirectToGmail()
    {
        $client = new Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $client->addScope('email');

        return redirect()->to($client->createAuthUrl());
    }

    public function handleGmailCallback(Request $request)
    {
        $client = new Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));

        $token = $client->fetchAccessTokenWithAuthCode($request->code);

        // Save the token or use it to fetch user info
        $client->setAccessToken($token);

        $oauth2 = new \Google_Service_Oauth2($client);
        $userInfo = $oauth2->userinfo->get();

        // Here you can create the tenant user using the Gmail info
        // Use $userInfo->email to get the email

        return redirect()->route('home');
    }
}
