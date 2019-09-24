<?php
declare(strict_types=1);
require_once "database.php";
require_once "../models/Teacher.php";
require_once "../models/Student.php";

class Auth
{
    public static function signUp(string $name, string $email, string $password, string $type): void
    {
        try {
            if ($type === 'student') {
                $user = new Student($name, $email, $password);
            } elseif ($type === 'teacher') {
                $user = new Teacher($name, $email, $password);
            }

            $stmt = $db->prepare("INSERT INTO users (name, email, password, type) VALUES (?, ?, ?, ?)");
            $stmt->bindParam(1, $user->getName());
            $stmt->bindParam(2, $user->getEmail());
            $stmt->bindParam(3, $user->getPassword());
            $stmt->bindParam(4, $user->getType());
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Could not register user into database. " . $e->getMessage();
        }
    }

    public static function signIn(string $email, string $password, string $type): ?User
    {
        try {
            $stmt = $db->prepare("SELECT * FROM users WHERE email=? AND password=? AND type=?");
            $stmt->bindParam(1, $email);
            $stmt->bindParam(2, $password);
            $stmt->bindParam(2, $type);
            $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            while ($row = $stmt->fetch()) {
                if ($type === 'student') {
                    return new Student($row['name'], $row['email'], $row['password']);
                } elseif ($type === 'teacher') {
                    return new Teacher($row['name'], $row['email'], $row['password']);
                }
            }
        } catch (PDOException $e) {
            echo "Could not sign in user. " . $e->getMessage();
        }
    }
}
?>