<?php
class Database {
    private $host = "localhost";
    private $db_name = "rooms_data";
    private $username = "root";
    private $password = "";
    public $conn;

    public function dbConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}

class Room {
    private $conn;
    private $table_name = "rooms";

    public $id;
    public $roomNo;
    public $seater;
    public $feePerMonth;
    public $foodStatus;
    public $stayFrom;
    public $duration;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create room
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET roomNo=:roomNo, seater=:seater, feePerMonth=:feePerMonth, foodStatus=:foodStatus, stayFrom=:stayFrom, duration=:duration";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":roomNo", $this->roomNo);
        $stmt->bindParam(":seater", $this->seater);
        $stmt->bindParam(":feePerMonth", $this->feePerMonth);
        $stmt->bindParam(":foodStatus", $this->foodStatus);
        $stmt->bindParam(":stayFrom", $this->stayFrom);
        $stmt->bindParam(":duration", $this->duration);
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Read rooms
    public function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Update room
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET roomNo=:roomNo, seater=:seater, feePerMonth=:feePerMonth, foodStatus=:foodStatus, stayFrom=:stayFrom, duration=:duration WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":roomNo", $this->roomNo);
        $stmt->bindParam(":seater", $this->seater);
        $stmt->bindParam(":feePerMonth", $this->feePerMonth);
        $stmt->bindParam(":foodStatus", $this->foodStatus);
        $stmt->bindParam(":stayFrom", $this->stayFrom);
        $stmt->bindParam(":duration", $this->duration);
        $stmt->bindParam(":id", $this->id);
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete room
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}

// Usage Example
$database = new Database();
$db = $database->dbConnection();

$room = new Room($db);

// Create
$room->roomNo = "101";
$room->seater = 2;
$room->feePerMonth = 5000.00;
$room->foodStatus = "with_food";
$room->stayFrom = "2023-01-01";
$room->duration = 12;
if($room->create()) {
    echo "Room created successfully.";
} else {
    echo "Unable to create room.";
}

// Read
$stmt = $room->read();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    echo "Room No: {$roomNo}, Seater: {$seater}, Fee Per Month: {$feePerMonth}, Food Status: {$foodStatus}, Stay From: {$stayFrom}, Duration: {$duration}<br>";
}

// Update
$room->id = 1;
$room->roomNo = "102";
$room->seater = 3;
$room->feePerMonth = 6000.00;
$room->foodStatus = "without_food";
$room->stayFrom = "2023-02-01";
$room->duration = 6;
if($room->update()) {
    echo "Room updated successfully.";
} else {
    echo "Unable to update room.";
}

// Delete
$room->id = 1;
if($room->delete()) {
    echo "Room deleted successfully.";
} else {
    echo "Unable to delete room.";
}
?>
