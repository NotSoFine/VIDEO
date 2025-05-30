<?php
class PasswordSecurity {
    // Minimum password requirements
    private $min_length = 8;
    private $require_uppercase = true;
    private $require_lowercase = true;
    private $require_numbers = true;
    private $require_special = true;

    // Password hashing options
    private $hash_algo = PASSWORD_BCRYPT;
    private $hash_options = ['cost' => 12];

    public function validatePassword($password) {
        $errors = [];

        // Check length
        if (strlen($password) < $this->min_length) {
            $errors[] = "Password must be at least {$this->min_length} characters long";
        }

        // Check for uppercase
        if ($this->require_uppercase && !preg_match('/[A-Z]/', $password)) {
            $errors[] = "Password must contain at least one uppercase letter";
        }

        // Check for lowercase
        if ($this->require_lowercase && !preg_match('/[a-z]/', $password)) {
            $errors[] = "Password must contain at least one lowercase letter";
        }

        // Check for numbers
        if ($this->require_numbers && !preg_match('/[0-9]/', $password)) {
            $errors[] = "Password must contain at least one number";
        }

        // Check for special characters
        if ($this->require_special && !preg_match('/[^A-Za-z0-9]/', $password)) {
            $errors[] = "Password must contain at least one special character";
        }

        return empty($errors) ? true : $errors;
    }

    public function hashPassword($password) {
        return password_hash($password, $this->hash_algo, $this->hash_options);
    }

    public function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }

    public function needsRehash($hash) {
        return password_needs_rehash($hash, $this->hash_algo, $this->hash_options);
    }

    public function generateTemporaryPassword($length = 12) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+';
        $password = '';
        
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[random_int(0, strlen($chars) - 1)];
        }

        return $password;
    }

    public function enforcePasswordUpdate($user_id, $db) {
        $sql = "UPDATE users SET password_change_required = 1 WHERE id = ?";
        $stmt = $db->getConnection()->prepare($sql);
        $stmt->bind_param('i', $user_id);
        return $stmt->execute();
    }
}

// Example usage in user creation/update:
/*
$security = new PasswordSecurity();

// When creating a new user or updating password
$password = $_POST['password'];
$validation = $security->validatePassword($password);

if ($validation === true) {
    $hashed_password = $security->hashPassword($password);
    // Store $hashed_password in database
} else {
    // Display validation errors to user
    foreach ($validation as $error) {
        echo $error . "<br>";
    }
}

// When verifying login
$stored_hash = // Get from database
$entered_password = $_POST['password'];

if ($security->verifyPassword($entered_password, $stored_hash)) {
    // Login successful
    
    // Check if password needs rehashing
    if ($security->needsRehash($stored_hash)) {
        $new_hash = $security->hashPassword($entered_password);
        // Update hash in database
    }
} else {
    // Login failed
}
*/
?>