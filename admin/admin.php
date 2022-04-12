<?php
$page_title = "Admin";

// Initialize the session
session_start();

// Check if the user is already logged in. If yes, redirect to next page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: ./CRUDE/index.php");
    exit;
}



require_once "../includes/elements/header.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $query = "
            SELECT id,
                   username,
                   password
              FROM users
             WHERE username = :username
        ";
        $pdo = DatabaseConnection::getConnection();
        if ($stmt = $pdo->prepare($query)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Check is username exists, if yes, then verify password
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        var_dump($row);
                        $id = $row["id"];
                        $username = $row["username"];
                        $hashed_password = $row["password"];
                        echo $password;
                        echo $username;
                        if (password_verify($password, $hashed_password)) {
                            session_start();
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            // Redirect to next page
                            header("location: ./CRUDE/index.php");
                        } else {
                            // Invalid password, display error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else {
                    // Username doesn't exist, display error message
                    $login_err = "Invalid username or password.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            // Close statment
            unset($stmt);
        }
    }
    // Close connection
    unset($pdo);
}
?>
<main>

    <?php
    if (!empty($login_err)) {
        echo '<div>' . $login_err . '</div>';
    }
    ?>
    <form class="login-box" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <div class="username">
            <label for="username">Enter your username:</label><br>
            <input id="username" name="username" placeholder="Username" type="text" class="login-input"
                autocomplete="off">
            <span><?= $username_err; ?></span>
        </div>
        <div class="pass">
            <label for="passw">Enter your password:</label><br>
            <input id="passw" name="password" placeholder="Password" type="text" class="login-input" autocomplete="off">
            <span><?= $password_err; ?></span>
        </div>
        <input class="submit-button" type="submit" value="Login">
    </form>
    <a href="./CRUDE/index.php">So the login isn't set up yet...</a>
</main>
</body>
<?php
require_once "../includes/elements/footer.php";
?>


</html>