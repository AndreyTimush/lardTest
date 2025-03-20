<?php

require_once 'dbConnection.php';

class CompanyRegistration
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function validate($data)
    {
        $errors = [];

        if (empty($data['companyName'])) {
            $errors[] = "Название компании обязательно.";
        }
        if (empty($data['inn']) || !preg_match('/^\d{10}$/', $data['inn'])) {
            $errors[] = "ИНН должен состоять из 10 цифр.";
        }
        if (empty($data['phone']) || !preg_match('/^8\d{10}$/', $data['phone'])) {
            $errors[] = "Телефон должен начинаться с 8 и содержать 10 цифр.";
        }
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Некорректный email.";
        }

        return $errors;
    }

    public function save($data)
    {
        $query = "INSERT INTO companies (company_name, inn, phone, email) VALUES (:company_name, :inn, :phone, :email)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':company_name', $data['companyName']);
        $stmt->bindParam(':inn', $data['inn']);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':email', $data['email']);

        return $stmt->execute();
    }

    public function getAllCompanies()
    {
        $query = "SELECT * FROM companies";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

$registration = new CompanyRegistration($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = $registration->validate($_POST);
    if (empty($errors)) {
        if ($registration->save($_POST)) {
            echo json_encode(['success' => true, 'message' => 'Регистрация успешна!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Ошибка при сохранении данных.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => $errors]);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $companies = $registration->getAllCompanies();
    echo json_encode($companies);
    exit;
}
