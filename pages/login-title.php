<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php
        if (isset($_SESSION['role']) && $_SESSION['role'] == 1) {
            echo 'Login untuk Admin';
        } else {
            echo 'Login untuk User';
        }
        ?>
    </title>
</head>
<body>
    <!-- Kode form login seperti sebelumnya -->
</body>
</html>
