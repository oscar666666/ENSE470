<?php
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "HELLDB";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


$sql = "CREATE TABLE Access (
userid INT(6) NOT NULL, 
softwareid INT(6) NOT NULL,
startdate TIMESTAMP NOT NULL,
enddate DATE NOT NULL,
FOREIGN KEY (userid) REFERENCES Login(id),
FOREIGN KEY (softwareid) REFERENCES Software(id),
PRIMARY KEY(userid, softwareid)

)";

if ($conn->query($sql) === TRUE) {
    echo "Table MyGuests created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
