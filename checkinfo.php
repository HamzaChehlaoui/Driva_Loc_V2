<?php
require('conn.php');
session_start();

class User {
    private $conn;
    private $email;
    private $password;

    public function __construct($db) {
        $this->conn = $db->getConnection();
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function authenticate() {

        $stmt = $this->conn->prepare("SELECT * FROM `user` WHERE emeil = :email");
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->execute();
        

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return [
            
                'emeil' => $row['emeil'],
                'motDepasse' => $row['motDepasse'],
                'roleId' => $row['roleId'],
                'idUser' => $row['idUser']
            ];
        }

        return false;
    }
}


class Auth {
    private $user;

    public function __construct($user) {
        $this->user = $user;
    }

    public function login($input_email, $input_password) {
        $this->user->setEmail($input_email);
        $this->user->setPassword($input_password);

        $user_data = $this->user->authenticate();

        if ($user_data && password_verify($input_password, $user_data['motDepasse'])) {
            $_SESSION['emeil'] = $user_data['emeil'];
            $_SESSION['idUser'] = $user_data['idUser'];
            $this->redirectBasedOnRole($user_data['roleId']);
        } else {
            $_SESSION['error'] = 'Invalid email or password';
            header('Location: index.php');
            exit;
        }
    }

    private function redirectBasedOnRole($role_id) {
        if ($role_id == 1) {
            header('Location: admin.php');
        } else {
            header('Location: user.php');
        }
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['emeil']) && isset($_POST['motDepasse'])) {
    $db = new Database();
    $user = new User($db);
    $auth = new Auth($user);
    $auth->login($_POST['emeil'], $_POST['motDepasse']);
    $db->close();
} else {
    echo 'Please enter both email and password';
}
?>