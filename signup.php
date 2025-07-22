<?php
session_start();
require_once 'config/db.php';

$name = $email = $password = $confirm_password = $role_type_id = $role_id = '';
$error = '';
$success = '';

// Fetch all role types
$role_types = [];
$res = $conn->query("SELECT role_type_id, role_type_name FROM role_type ORDER BY role_type_name");
while ($row = $res->fetch_assoc()) {
    $role_types[] = $row;
}

// Password regex (at least 8, upper, lower, digit, special, no space)
$password_regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,}$/';

// On form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $role_type_id = $_POST['role_type_id'] ?? '';
    $role_id  = $_POST['role_id'] ?? '';

    // Validation (server-side)
    if ($name === '' || $email === '' || $password === '' || $role_id === '' || $role_type_id === '') {
        $error = "Please fill all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address.";
    } elseif (!preg_match($password_regex, $password) || preg_match('/\s/', $password)) {
        $error = "Password must be at least 8 characters, with uppercase, lowercase, number, special character, and no spaces.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Check if email exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $error = "Email already registered.";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (name, email, password, role_id) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $name, $email, $hashed, $role_id);
            if ($stmt->execute()) {
                $success = "Signup successful! Please login.";
                header("refresh:2;url=login.php");
            } else {
                $error = "Database error. Try again.";
            }
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign Up | Trimatric</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- FontAwesome for eye icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        body { background: #f6f8fa; }
        .signup-container { max-width: 450px; margin: 60px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 16px #0002; padding: 2.5rem 2rem; }
        .brand-logo { width: 60px; }
        .select2-container .select2-selection--single { height: 46px; padding: 7px 10px; border-radius: 6px; border: 1px solid #ced4da;}
        .select2-selection__arrow { height: 46px !important; }
        .is-invalid, .select2-container--default .select2-selection--single.is-invalid { border-color: #dc3545 !important; }
        .invalid-feedback { display: block; }
        .input-group-text.bg-white { cursor: pointer; }
    </style>
</head>
<body>
    <div class="signup-container">
        <div class="text-center mb-4">
            <img src="image/trimatric_logo.png" class="brand-logo mb-1" alt="Trimatric Logo">
            <div class="fs-4 fw-bold">Trimatric Signup</div>
        </div>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php elseif ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <form id="signupForm" method="post" autocomplete="off" novalidate>
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input name="name" type="text" class="form-control" required value="<?= htmlspecialchars($name) ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Email address</label>
                <input name="email" type="email" class="form-control" required value="<?= htmlspecialchars($email) ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Role Type</label>
                <select id="role_type" name="role_type_id" class="form-select select2-single" required>
                    <option value="">-- Select Role Type --</option>
                    <?php foreach ($role_types as $rt): ?>
                        <option value="<?= $rt['role_type_id'] ?>" <?= $role_type_id == $rt['role_type_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($rt['role_type_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Role</label>
                <select id="role" name="role_id" class="form-select select2-single" required>
                    <option value="">-- Select Role --</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <input name="password" id="password" type="password" class="form-control" required>
                    <span class="input-group-text bg-white" id="togglePwd">
                        <i class="fa fa-eye-slash"></i>
                    </span>
                </div>
                <small class="text-muted">Password must be at least 8 characters and contain uppercase, lowercase, number, and special character.</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <div class="input-group">
                    <input name="confirm_password" id="confirm_password" type="password" class="form-control" required>
                    <span class="input-group-text bg-white" id="toggleConfirmPwd">
                        <i class="fa fa-eye-slash"></i>
                    </span>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100">Sign Up</button>
            <div class="text-center mt-3">
                <a href="login.php" class="small">Already have an account? Login</a>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery & Select2 JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
    $(document).ready(function() {
        $('.select2-single').select2({ width: '100%' });

        function loadRoles(role_type_id, selected) {
            $('#role').html('<option value="">Loading...</option>');
            if (!role_type_id) {
                $('#role').html('<option value="">-- Select Role --</option>');
                return;
            }
            $.ajax({
                url: 'config/get_roles.php',
                type: 'GET',
                data: { role_type_id: role_type_id },
                dataType: 'json',
                success: function(data) {
                    var html = '<option value="">-- Select Role --</option>';
                    for (var i = 0; i < data.length; i++) {
                        var sel = (data[i].role_id == selected) ? 'selected' : '';
                        html += '<option value="' + data[i].role_id + '" ' + sel + '>' + data[i].role_name + '</option>';
                    }
                    $('#role').html(html).trigger('change');
                }
            });
        }

        // On load, if a role type is selected (eg. after error), load roles
        var currentRoleType = $('#role_type').val();
        var currentRole     = "<?= $role_id ?>";
        if (currentRoleType) {
            loadRoles(currentRoleType, currentRole);
        }

        $('#role_type').on('change', function() {
            loadRoles($(this).val());
        });

        // --- Client-side required validation with red border and focus ---
        $('#signupForm').on('submit', function(e) {
            let focusSet = false;
            $(this).find('input, select').removeClass('is-invalid');
            $('.select2-selection').removeClass('is-invalid');
            // Loop through required fields
            $(this).find('[required]').each(function() {
                if ($(this).val() === '') {
                    if ($(this).hasClass('select2-hidden-accessible')) {
                        $(this).next('.select2-container').find('.select2-selection').addClass('is-invalid');
                    } else {
                        $(this).addClass('is-invalid');
                    }
                    if (!focusSet) {
                        $(this).focus();
                        focusSet = true;
                    }
                    e.preventDefault();
                }
            });
        });

        // --- Show/Hide Password (both fields) ---
        $('#togglePwd').on('click', function() {
            let pwd = $('#password');
            let icon = $(this).find('i');
            if (pwd.attr('type') === 'password') {
                pwd.attr('type', 'text');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            } else {
                pwd.attr('type', 'password');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            }
        });
        $('#toggleConfirmPwd').on('click', function() {
            let pwd = $('#confirm_password');
            let icon = $(this).find('i');
            if (pwd.attr('type') === 'password') {
                pwd.attr('type', 'text');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            } else {
                pwd.attr('type', 'password');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            }
        });
    });
    </script>
</body>
</html>
