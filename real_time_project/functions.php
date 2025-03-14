<?php
// Example function for fetching data from the database
function display_data() {
    global $scon; // Access the database connection variable
    $query = "SELECT * FROM user_login"; // Replace 'your_table' with your actual table name
    $result = mysqli_query($scon, $query);
    return $result;
}

// Add more functions as needed...
