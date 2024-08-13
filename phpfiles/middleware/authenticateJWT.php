<?php
require_once __DIR__ . '../../vendor/autoload.php';  
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthenticateJWT {
    private $secretKey = 'your_secret_key'; 
    private $algorithm = 'HS256';

    public function validateToken() {
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            $token = str_replace('Bearer ', '', $headers['Authorization']);
            try {
                $decoded = JWT::decode($token, new Key($this->secretKey, $this->algorithm));
                $_SESSION['user'] = $decoded;
            } catch (Exception $e) {
                http_response_code(401);
                echo json_encode(array("message" => "Unauthorized: " . $e->getMessage()));
                exit();
            }
        } else {
            http_response_code(401);
            echo json_encode(array("message" => "Authorization header not found."));
            exit();
        }
    }

    // public function isAdmin() {
    //     if (isset($_SESSION['user'])) {
    //         $user = $_SESSION['user'];
    //         // Check if the username is 'admin'
    //         if (isset($user->username) && $user->username === 'admin') {
    //             return true;
    //         }
    //     }
    //     return false;
    // }
}
?>
