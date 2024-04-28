<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <style>
        h1 {
            color: rgb(165, 50, 42);
        }
        label {
            color:brown;
        }
    </style>
</head>
<body>
    <h1 align="center">User Registration</h1>

    <form align="center" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="email">Email:</label><br>
        <input type="email" name="email" required placeholder="Email">
        <br>
        <br>
        <input type="submit" name="submit" value="Submit">
    </form>
     <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database_name = "codespindle"; 
    $table_name = "RegistrationForm"; 
    $conn = new mysqli($servername, $username, $password, $database_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require 'vendor/autoload.php'; 
        $email = $_POST['email'];
        $sql_insert = "INSERT INTO $table_name (Email) VALUES ('$email')";
          if ($conn->query($sql_insert) === TRUE) {
            echo "<h2>Registration Successful:</h2>";
            echo "<p>Email: $email</p>";
            echo "<p>Record inserted into database successfully.</p>";
            $owner_email = "mm4661454@gmail.com";
            $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'mm4661454@gmail.com'; 
                $mail->Password = 'pkic mqke cwuo mnac'; 
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->setFrom('mm4661454@gmail.com', 'CodeSpindle'); 
                $mail->addAddress($owner_email); 

                $mail->isHTML(true);
                $mail->Subject = 'New Registration';
                $mail->Body = "New registration:\nEmail: $email";

                $mail->send();
                echo "<p>Email sent successfully to the owner</p>";
            } catch (Exception $e) {
                echo "Email sending failed. Error: {$mail->ErrorInfo}";
            }
        } else {
            echo "Error: " . $sql_insert . "<br>" . $conn->error;
        }
    }

    $conn->close();
    ?>
</body>
</html>
