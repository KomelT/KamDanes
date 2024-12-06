<?php

class ViewHelper
{
    public static function render($file, $variables = array())
    {
        extract($variables);

        ob_start();
        include($file);
        $renderedView = ob_get_clean();

        echo $renderedView;
    }

    // Redirects to the given URL
    public static function redirect($url)
    {
        header("Location: " . $url);
    }
    public static function registerResponse($status)
    {
        header('Content-Type: application/json');
        $responseData = [
            'status' => $status ? 'success' : 'fail',
            'message' => $status ? 'User registered' : 'User not registered',

        ];
        echo json_encode($responseData);
    }
    public static function loginResponse($usernameExists, $password)
    {
        if (!$usernameExists) {
            header('Content-Type: application/json');
            $responseData = [
                'status' => 'fail',
                'message' => '1'

            ];

        } else if ($password) {
            $responseData = [
                'status' => 'success',
                'message' => 'Logged in'

            ];


        } else {
            $responseData = [
                'status' => 'fail',
                'message' => '0'

            ];

        }
        echo json_encode($responseData);
    }




    public static function returnJson($data)
    {
        header('Content-Type: application/json');
        echo $data;
    }
    // Displays a simple 404 message
    public static function error404()
    {
        header('This is not the page you are looking for', true, 404);
        $html404 = sprintf("<!doctype html>\n" .
            "<title>Error 404: Page does not exist</title>\n" .
            "<h1>Error 404: Page does not exist</h1>\n" .
            "<p>The page <i>%s</i> does not exist.</p>", $_SERVER["REQUEST_URI"]);

        echo $html404;
    }


}