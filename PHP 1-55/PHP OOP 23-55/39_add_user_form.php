<?php
require_once '28_database_class.php';

class UserForm {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function displayForm() {
        ?>
        <div class="container mt-4">
            <h2>Add New User</h2>
            <form action="40_process_user.php" method="POST" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                    <div class="invalid-feedback">Please enter a username.</div>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                    <div class="invalid-feedback">Please enter a valid email address.</div>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <div class="invalid-feedback">Please enter a password.</div>
                </div>
                
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    <div class="invalid-feedback">Please confirm your password.</div>
                </div>
                
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="">Select a role</option>
                        <option value="admin">Administrator</option>
                        <option value="staff">Staff</option>
                    </select>
                    <div class="invalid-feedback">Please select a role.</div>
                </div>
                
                <button type="submit" class="btn btn-primary">Add User</button>
            </form>
        </div>
        <?php
    }
}

$form = new UserForm();
$form->displayForm();
?>