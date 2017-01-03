<?php

function get_auth($user)
{
    $user['token'] = @openssl_encrypt(json_encode($user), 'aes128', 'stacker_salt');
    //$user['projectIds'] = $user['project_id'];
    return $user;
}

function get_logged_in_user()
{
    if ($_SERVER['HTTP_TOKEN']) {
        $user = json_decode(@openssl_decrypt($_SERVER['HTTP_TOKEN'], 'aes128', 'stacker_salt'));
    } else {
        $user = false;
    }
    return $user;
}

function check_login($project_id)
{
    if (!isset($project_id) || $project_id == false) {
        // no login required
        return true;
    } else {
        if ($_SERVER['HTTP_TOKEN']) {

            $user = get_logged_in_user();
            if ($user->type == "admin" || array_search($project_id, $user->projectIds) !== false) {
                return true;
            } else {
                header('HTTP/1.1 401 Unauthorized', true, 401);
                exit(0);
            }
        } else {
            header('HTTP/1.1 401 Unauthorized', true, 401);
            exit(0);
        }
    }
}

