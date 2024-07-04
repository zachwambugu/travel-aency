<?php
include 'config.php';

if ($conn->ping()) {
    echo "Connection successful!";
} else {
    echo "Connection failed: " . $conn->error;
}
?>
