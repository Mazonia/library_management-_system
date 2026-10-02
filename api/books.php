<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../db.php';

$method = $_SERVER['REQUEST_METHOD'];

try {
    if ($method === 'GET') {
        $search = isset($_GET['q']) ? '%' . trim($_GET['q']) . '%' : '%';
        $stmt = $conn->prepare("SELECT * FROM Books WHERE Title LIKE ? OR Author LIKE ? OR Genre LIKE ? ORDER BY BookID DESC");
        $stmt->bind_param("sss", $search, $search, $search);
        $stmt->execute();
        $res = $stmt->get_result();
        $books = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
        echo json_encode(["status" => "success", "data" => $books]);
    } elseif ($method === 'POST') {
        $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        $title = trim($input['title'] ?? '');
        $author = trim($input['author'] ?? '');
        $publication_year = (int)($input['publication_year'] ?? date('Y'));
        $genre = trim($input['genre'] ?? 'General');
        $isbn = trim($input['isbn'] ?? '');
        $available_copies = (int)($input['available_copies'] ?? 1);

        if (empty($title) || empty($author) || empty($isbn)) {
            echo json_encode(["status" => "error", "message" => "Title, Author, and ISBN are required."]);
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO Books (Title, Author, PublicationYear, Genre, ISBN, AvailableCopies) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssissi", $title, $author, $publication_year, $genre, $isbn, $available_copies);
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Book created successfully.", "id" => $stmt->insert_id]);
        } else {
            echo json_encode(["status" => "error", "message" => $stmt->error]);
        }
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
