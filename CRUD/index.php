<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crud";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}


if (isset($_POST['addRecord'])) {
    $firstName = sanitize_input($_POST['firstName']);
    $lastName = sanitize_input($_POST['lastName']);
    $department = sanitize_input($_POST['department']);

    $sql = "INSERT INTO Employees (FirstName, LastName, DepartmentID) VALUES ('$firstName', '$lastName', $department)";
    $conn->query($sql);
}


if (isset($_POST['deleteRecord'])) {
    $deleteID = sanitize_input($_POST['id']);
    $sql = "DELETE FROM Employees WHERE id = $deleteID";
    $conn->query($sql);
}


if (isset($_POST['editRecord'])) {
    $editID = sanitize_input($_POST['id']);
    $editFirstName = sanitize_input($_POST['editFirstName']);
    $editLastName = sanitize_input($_POST['editLastName']);
    $editDepartment = sanitize_input($_POST['editDepartment']);

    $sql = "UPDATE Employees SET FirstName = '$editFirstName', LastName = '$editLastName', DepartmentID = $editDepartment WHERE id = $editID";
    $conn->query($sql);
}


$sql = "SELECT id, FirstName, LastName, DepartmentID FROM Employees";
$result = $conn->query($sql);

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style.css">
    <title>Employee Management System</title>
</head>

<body>
    <div class="container">
        <h1 style="color: #2d6e30;">Employee Management System</h1>
        <Section>
            <h1 style="color: #4CAF50;">Add Record in the Database</h1>
            <form id="addForm" method="POST" action="index.php">
                <label for="firstName">First Name:</label>
                <input type="text" name="firstName" required>

                <label for="lastName">Last Name:</label>
                <input type="text" name="lastName" required>

                <label for="department">Department ID:</label>
                <input type="number" name="department" required>

                <button type="submit" name="addRecord">Add Record</button>
            </form>
        </Section>
        <hr>
        <section>
            <h1 style="color: #4CAF50;">Delete Record from the Database</h1>
            <form id="deleteForm" method="POST" action="index.php">
                <label for="deleteID">Employee ID to Delete:</label>
                <input type="number" name="id" required>
                <button type="submit" name="deleteRecord">Delete Record</button>
            </form>
        </section>
        <hr>

        <section>
            <h1 style="color: #4CAF50;">Edit Record from the Database</h1>
            <form id="editForm" method="POST" action="index.php">
                <label for="editID">Employee ID to Edit:</label>
                <input type="number" name="id" required>

                <label for="editFirstName">New First Name:</label>
                <input type="text" name="editFirstName">

                <label for="editLastName">New Last Name:</label>
                <input type="text" name="editLastName">

                <label for="editDepartment">New Department ID:</label>
                <input type="number" name="editDepartment">

                <button type="submit" name="editRecord">Edit Record</button>
            </form>
        </section>
        <hr>
        <section>
            <h1 style="color: #4CAF50;">Retrieve Record from the Database</h1>
            <table id="employeeTable">
                <thead>
                    <tr>
                        <th>Employee ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Department ID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
            if ($result === false) {
                echo "<tr><td colspan='4'>Error executing query: " . $conn->error . "</td></tr>";
            } else {
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr><td>{$row['id']}</td><td>{$row['FirstName']}</td><td>{$row['LastName']}</td><td>{$row['DepartmentID']}</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No records found</td></tr>";
                }
            }
            ?>
                </tbody>
            </table>
        </section>



    </div>
</body>

</html>