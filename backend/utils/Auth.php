<?php
declare(strict_types=1);
require_once "database.php";
require_once "../models/User.php";
require_once "../models/Teacher.php";
require_once "../models/Student.php";

class Auth
{
    public static function signUp(string $name, string $email, string $password, string $type): void
    {
        try {
            $stmt = $db->prepare("INSERT INTO users (name, email, password, type) VALUES (:name, :email, :password, :type)");
            $stmt->execute(array(':name' => $name, ':email' => $email, ':password' => $password, ':type' => $type));

            $id = $db->lastInsertId();
            if ($type === 'student') {
                $user = new Student($id, $name, $email, $password);
            } elseif ($type === 'teacher') {
                $user = new Teacher($id, $name, $email, $password);
            }
        } catch (PDOException $e) {
            echo "Could not register user into database: " . $e->getMessage();
        }
    }

    public static function signIn(string $email, string $password, string $type): ?User
    {
        try {
            $stmt = $db->prepare("SELECT * FROM users WHERE email=:email AND password = :password AND type = :type");
            $stmt->execute(array(':email' => $email, ':password' => $password, ':type' => $type));

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            while ($row = $stmt->fetch()) {
                if ($type === 'student') {
                    return new Student($row['uid'], $row['name'], $row['email'], $row['password']);
                } elseif ($type === 'teacher') {
                    return new Teacher($row['uid'], $row['name'], $row['email'], $row['password']);
                }
            }
        } catch (PDOException $e) {
            echo "Could not sign in user: " . $e->getMessage();
        }
    }
}
?>