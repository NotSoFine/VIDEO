<?php
// Initialize error array
$errors = [];
$formData = [];

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate name
    if (empty($_POST['name'])) {
        $errors['name'] = 'Name is required';
    } else {
        $formData['name'] = trim($_POST['name']);
        if (strlen($formData['name']) < 2) {
            $errors['name'] = 'Name must be at least 2 characters long';
        }
    }

    // Validate email
    if (empty($_POST['email'])) {
        $errors['email'] = 'Email is required';
    } else {
        $formData['email'] = trim($_POST['email']);
        if (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format';
        }
    }

    // Validate age
    if (empty($_POST['age'])) {
        $errors['age'] = 'Age is required';
    } else {
        $formData['age'] = trim($_POST['age']);
        if (!is_numeric($formData['age']) || $formData['age'] < 18 || $formData['age'] > 120) {
            $errors['age'] = 'Age must be between 18 and 120';
        }
    }

    // Validate password
    if (empty($_POST['password'])) {
        $errors['password'] = 'Password is required';
    } else {
        $formData['password'] = $_POST['password'];
        if (strlen($formData['password']) < 8) {
            $errors['password'] = 'Password must be at least 8 characters long';
        }
    }

    // If no errors, process the form
    if (empty($errors)) {
        echo "<div class='success'>Form submitted successfully!</div>";
        // Process the form data here (e.g., save to database)
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Form Validation Example</title>
    <style>
        .error { color: red; }
        .success { color: green; }
        .form-group { margin-bottom: 15px; }
    </style>
</head>
<body>
    <h2>Registration Form with Validation</h2>

    <form method="POST" action="">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" 
                   value="<?php echo isset($formData['name']) ? htmlspecialchars($formData['name']) : ''; ?>">
            <?php if (isset($errors['name'])) echo "<span class='error'>" . $errors['name'] . "</span>"; ?>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email"
                   value="<?php echo isset($formData['email']) ? htmlspecialchars($formData['email']) : ''; ?>">
            <?php if (isset($errors['email'])) echo "<span class='error'>" . $errors['email'] . "</span>"; ?>
        </div>

        <div class="form-group">
            <label for="age">Age:</label>
            <input type="number" id="age" name="age"
                   value="<?php echo isset($formData['age']) ? htmlspecialchars($formData['age']) : ''; ?>">
            <?php if (isset($errors['age'])) echo "<span class='error'>" . $errors['age'] . "</span>"; ?>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
            <?php if (isset($errors['password'])) echo "<span class='error'>" . $errors['password'] . "</span>"; ?>
        </div>

        <div class="form-group">
            <input type="submit" value="Register">
        </div>
    </form>

    <?php
    // Display all errors at the bottom (optional)
    if (!empty($errors)) {
        echo "<div class='error'>\n";
        echo "<h3>Please fix the following errors:</h3>\n";
        echo "<ul>\n";
        foreach ($errors as $error) {
            echo "<li>" . htmlspecialchars($error) . "</li>\n";
        }
        echo "</ul>\n";
        echo "</div>\n";
    }
    ?>
</body>
</html>