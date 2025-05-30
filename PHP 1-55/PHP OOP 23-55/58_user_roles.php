<?php
require_once '28_database_class.php';
require_once '29_layout_structure.php';

class UserRoleManager {
    private $db;
    private $allowed_roles = ['admin', 'staff', 'manager'];

    public function __construct() {
        $this->db = new Database();
    }

    public function updateUserRole($user_id, $new_role) {
        if (!in_array($new_role, $this->allowed_roles)) {
            return false;
        }

        $sql = "UPDATE users SET role = ? WHERE id = ?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param('si', $new_role, $user_id);
        return $stmt->execute();
    }

    public function getAllUsers() {
        $sql = "SELECT id, username, email, role, is_active, last_login 
                FROM users 
                ORDER BY username";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function displayUserRoles() {
        $users = $this->getAllUsers();
        ?>
        <div class="container mt-4">
            <h2>User Role Management</h2>
            
            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-<?php echo $_SESSION['message_type']; ?>">
                    <?php 
                    echo $_SESSION['message']; 
                    unset($_SESSION['message']);
                    unset($_SESSION['message_type']);
                    ?>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Current Role</th>
                            <th>Status</th>
                            <th>Last Login</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['username']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td>
                                    <form method="POST" class="d-inline">
                                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                        <select name="role" class="form-select form-select-sm" 
                                                onchange="this.form.submit()" 
                                                <?php echo $user['id'] === $_SESSION['user_id'] ? 'disabled' : ''; ?>>
                                            <?php foreach ($this->allowed_roles as $role): ?>
                                                <option value="<?php echo $role; ?>" 
                                                        <?php echo $user['role'] === $role ? 'selected' : ''; ?>>
                                                    <?php echo ucfirst($role); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </form>
                                </td>
                                <td><?php echo $user['is_active'] ? 'Active' : 'Inactive'; ?></td>
                                <td><?php echo $user['last_login'] ? date('Y-m-d H:i', strtotime($user['last_login'])) : 'Never'; ?></td>
                                <td>
                                    <?php if ($user['id'] !== $_SESSION['user_id']): ?>
                                        <button class="btn btn-sm btn-warning" 
                                                onclick="confirmRoleChange(<?php echo $user['id']; ?>)">
                                            Change Role
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <script>
        function confirmRoleChange(userId) {
            if (confirm('Are you sure you want to change this user\'s role?')) {
                document.querySelector(`form input[value="${userId}"]`).form.submit();
            }
        }
        </script>
        <?php
    }
}

// Process role update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id']) && isset($_POST['role'])) {
    $roleManager = new UserRoleManager();
    $success = $roleManager->updateUserRole($_POST['user_id'], $_POST['role']);
    
    $_SESSION['message'] = $success ? 'User role updated successfully.' : 'Failed to update user role.';
    $_SESSION['message_type'] = $success ? 'success' : 'danger';
    
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Check if user is logged in and has admin role
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: 41_login.php');
    exit();
}

// Display the page
render_header('User Role Management');

$roleManager = new UserRoleManager();
$roleManager->displayUserRoles();

render_footer();
?>