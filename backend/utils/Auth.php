<?php
declare(strict_types=1);
require_once "database.php";
require_once "../models/Teacher.php";
require_once "../models/Student.php";

class Auth
{
    public static function signUpTeacher(string $name, string $email, string $password): void
    {
        try {
            $teacher = new Teacher($name, $email, $password);

            $stmt = $db->prepare("INSERT INTO users (name, email, password, type) VALUES (?, ?, ?, ?)");
            $stmt->bindParam(1, $teacher->getName());
            $stmt->bindParam(2, $teacher->getEmail());
            $stmt->bindParam(3, $teacher->getPassword());
            $stmt->bindParam(4, $teacher->getType());
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Could not register teacher into database" . $e->getMessage();
        }
    }

    public static function signInTeacher(string $email, string $password): ?Teacher
    {
        try {
            $stmt = $db->prepare("SELECT * FROM users WHERE email=? AND password=? AND type='teacher'");
            $stmt->bindParam(1, $email);
            $stmt->bindParam(2, $password);
            $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            while ($row = $stmt->fetch()) {
                return new Teacher($row['name'], $row['email'], $row['password']);
            }
        } catch (PDOException $e) {
            echo "Could not register teacher into database" . $e->getMessage();
        }
    }

    public static function signUpStudent(string $name, string $email, string $password): void
    {
        try {
            $teacher = new Student($name, $email, $password);

            $stmt = $db->prepare("INSERT INTO users (name, email, password, type) VALUES (?, ?, ?, ?)");
            $stmt->bindParam(1, $teacher->getName());
            $stmt->bindParam(2, $teacher->getEmail());
            $stmt->bindParam(3, $teacher->getPassword());
            $stmt->bindParam(4, $teacher->getType());
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Could not register teacher into database" . $e->getMessage();
        }
    }

    public static function signInStudent(string $email, string $password): ?Student
    {
        try {
            $stmt = $db->prepare("SELECT * FROM users WHERE email=? AND password=? AND type='teacher'");
            $stmt->bindParam(1, $email);
            $stmt->bindParam(2, $password);
            $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            while ($row = $stmt->fetch()) {
                return new Student($row['name'], $row['email'], $row['password']);
            }
        } catch (PDOException $e) {
            echo "Could not register teacher into database" . $e->getMessage();
        }
    }
}
?>