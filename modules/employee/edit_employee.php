<?php
require_once(__DIR__ . '/../../config/db.php');
session_start();

// Image folder path (must be writable)
$image_folder = '/trimatric/image/employee';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Assigning GET parameter 'id' to local var 'employee_id'
$employee_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($employee_id < 1) {
    header("Location: employee_list.php");
    exit;
}

// Fetch employee's current data for prefill
$stmt = $conn->prepare("SELECT * FROM employee_info WHERE employee_id = ?");
$stmt->bind_param('i', $employee_id);
$stmt->execute();
$result = $stmt->get_result();
$employee = $result->fetch_assoc();
$stmt->close();

if (!$employee) {
    header("Location: employee_list.php");
    exit;
}

// --- Get department_id from unit table based on unit_id (since employee_info has no department_id) ---
$unit_id = $employee['unit_id'];
$unit_stmt = $conn->prepare("SELECT department_id FROM unit WHERE unit_id = ?");
$unit_stmt->bind_param('i', $unit_id);
$unit_stmt->execute();
$unit_stmt->bind_result($department_id);
$unit_stmt->fetch();
$unit_stmt->close();

// --- Fetch Departments for the select list ---
$dept_stmt = $conn->prepare("SELECT department_id, department_name FROM department ORDER BY department_name");
$dept_stmt->execute();
$departments = $dept_stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$dept_stmt->close();

$image_error = '';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employee_name = trim($_POST['employee_name'] ?? '');
    $designation   = trim($_POST['designation'] ?? '');
    $department_id = intval($_POST['department_id'] ?? 0);
    $unit_id       = intval($_POST['unit_id'] ?? 0);
    $email         = trim($_POST['email'] ?? '');
    $phone         = trim($_POST['phone'] ?? '');
    $address       = trim($_POST['address'] ?? '');
    $gender        = trim($_POST['gender'] ?? '');
    $date_of_birth = trim($_POST['date_of_birth'] ?? '');
    $nid           = trim($_POST['nid'] ?? '');
    $join_date     = trim($_POST['join_date'] ?? '');
    $status        = isset($_POST['status']) ? $_POST['status'] : '1';
    $old_image     = trim($_POST['old_image'] ?? '');

    // --- Validation (same as add_employee) ---
    if ($employee_name === '') $errors['employee_name'] = 'Required';
    if ($designation === '')   $errors['designation']   = 'Required';
    if ($department_id < 1)    $errors['department_id'] = 'Required';
    if ($unit_id < 1)          $errors['unit_id']       = 'Required';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Invalid email';
    if ($phone === '')         $errors['phone'] = 'Required';
    if (!preg_match('/^0\d{10}$/', $phone)) $errors['phone'] = 'Phone must be 11 digits and start with 0.';
    if ($address === '')       $errors['address'] = 'Required';
    if ($gender === '')        $errors['gender']  = 'Required';
    if ($date_of_birth === '') $errors['date_of_birth'] = 'Required';
    if ($join_date === '')     $errors['join_date'] = 'Required';

    // --- Image field: not required, but must be jpg/png/gif if uploaded ---
    $image_file_name = $old_image;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $img = $_FILES['image'];
        $img_ext = strtolower(pathinfo($img['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($img_ext, $allowed)) {
            $errors['image'] = "Only JPG, JPEG, PNG, GIF allowed";
        } else {
            // Generate unique file name
            $image_file_name = 'emp_' . $employee_id . '_' . time() . '.' . $img_ext;
            $save_path = $_SERVER['DOCUMENT_ROOT'] . $image_folder . '/' . $image_file_name;
            if (!move_uploaded_file($img['tmp_name'], $save_path)) {
                $errors['image'] = "Failed to upload image";
                $image_file_name = $old_image;
            } else {
                // Optionally delete old image file if you wish (not required)
                if ($old_image && file_exists($_SERVER['DOCUMENT_ROOT'] . $image_folder . '/' . $old_image)) {
                    @unlink($_SERVER['DOCUMENT_ROOT'] . $image_folder . '/' . $old_image);
                }
            }
        }
    }

    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $errors['csrf'] = 'Invalid CSRF token';
    }

    if (!$errors) {
        $stmt = $conn->prepare("UPDATE employee_info SET 
            employee_name = ?, designation = ?, unit_id = ?, email = ?, phone = ?, address = ?, gender = ?, date_of_birth = ?, nid = ?, join_date = ?, status = ?, image = ?
            WHERE employee_id = ?");
        $stmt->bind_param("ssisssssssssi", $employee_name, $designation, $unit_id, $email, $phone, $address, $gender, $date_of_birth, $nid, $join_date, $status, $image_file_name, $employee_id);
        $stmt->execute();
        $stmt->close();
        header("Location: employee_list.php");
        exit;
    }
} else {
    // Prefill from DB (GET)
    $employee_name = $employee['employee_name'];
    $designation   = $employee['designation'];
    $unit_id       = $employee['unit_id'];
    $email         = $employee['email'];
    $phone         = $employee['phone'];
    $address       = $employee['address'];
    $gender        = $employee['gender'];
    $date_of_birth = $employee['date_of_birth'];
    $nid           = $employee['nid'];
    $join_date     = $employee['join_date'];
    $status        = $employee['status'];
    $image_file_name = $employee['image'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Employee</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome (for calendar icon) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Tom Select CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <style>
        body { background: #f6f8fa; }
        .container { background: #fff; border-radius: 12px; box-shadow: 0 2px 16px #0002; padding: 2rem; margin-bottom: 2rem; border-left: 2px solid #1a237e; border-right: 2px solid #1a237e; border-bottom: 2px solid #1a237e; border-top: 2px solid #1a237e;}
        .main-title { font-size: 2.1rem; font-weight: bold; color: #12203a; text-align: center; margin-bottom: 1.3rem; }
        .form-label.required:after { content:" *"; color: #dc3545; }
        .is-invalid { border-color: #dc3545 !important; }
        .invalid-feedback { color: #dc3545 !important; }
        .input-group-text { background: #f6f8fa; border-right: 0; cursor:pointer; }
        .status-small { max-width: 180px; min-width: 120px; width:auto; display: inline-block;}
        .img-preview {max-width: 120px; max-height: 120px; border: 1px solid #eee; border-radius: 5px; background: #f9f9f9;}
        @media (max-width: 600px) { .main-title { font-size: 1.25rem; } .container { padding: .5rem !important; } }
    </style>
</head>
<body>
<?php require_once(__DIR__ . '/../../include/header.php'); ?>
<?php require_once(__DIR__ . '/../../include/menu_ho.php'); ?>

<div class="container mt-4 mb-4">
    <div class="main-title">Edit Employee</div>
    <?php if (!empty($errors['csrf'])): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($errors['csrf']) ?></div>
    <?php endif; ?>
    <form method="post" autocomplete="off" enctype="multipart/form-data" id="employeeForm">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <input type="hidden" name="old_image" value="<?= htmlspecialchars($image_file_name) ?>">
        <div class="row mb-3">
            <div class="col-md-6 mb-3">
                <label class="form-label required">Employee Name</label>
                <input type="text" name="employee_name" class="form-control <?= isset($errors['employee_name']) ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($employee_name ?? '') ?>" required>
                <?php if (isset($errors['employee_name'])): ?><div class="invalid-feedback">Employee Name is required</div><?php endif; ?>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label required">Designation</label>
                <input type="text" name="designation" class="form-control <?= isset($errors['designation']) ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($designation ?? '') ?>" required>
                <?php if (isset($errors['designation'])): ?><div class="invalid-feedback">Designation is required</div><?php endif; ?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6 mb-3">
                <label class="form-label required">Department</label>
                <select name="department_id" id="department_id" class="form-select <?= isset($errors['department_id']) ? 'is-invalid' : '' ?>" required>
                    <option value="">--- Select Department ---</option>
                    <?php foreach($departments as $dept): ?>
                        <option value="<?= $dept['department_id'] ?>"
                            <?= (isset($department_id) && $department_id == $dept['department_id']) ? 'selected':'' ?>>
                            <?= htmlspecialchars($dept['department_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (isset($errors['department_id'])): ?><div class="invalid-feedback">Select Department</div><?php endif; ?>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label required">Unit</label>
                <select name="unit_id" id="unit_id" class="form-select <?= isset($errors['unit_id']) ? 'is-invalid' : '' ?>" required>
                    <option value="">--- Select Unit ---</option>
                </select>
                <?php if (isset($errors['unit_id'])): ?><div class="invalid-feedback">Select Unit</div><?php endif; ?>
            </div>
        </div>
        <!-- Image Upload Field -->
        <div class="row mb-3">
            <div class="col-md-6 mb-3">
                <label class="form-label">Employee Image</label>
                <input type="file" name="image" class="form-control <?= isset($errors['image']) ? 'is-invalid' : '' ?>" accept="image/*">
                <small class="text-muted">Allowed: JPG, JPEG, PNG, GIF</small>
                <?php if (isset($errors['image'])): ?><div class="invalid-feedback"><?= htmlspecialchars($errors['image']) ?></div><?php endif; ?>
                <?php if ($image_file_name): ?>
                    <div class="mt-2">
                        <span>Current file: <strong><?= htmlspecialchars($image_file_name) ?></strong></span>
                        <br>
                        <img src="<?= $image_folder . '/' . htmlspecialchars($image_file_name) ?>" alt="Employee Image" class="img-preview mt-1">
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col-md-6 mb-3">
                <label class="form-label required">Email</label>
                <input type="email" name="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($email ?? '') ?>" required>
                <?php if (isset($errors['email'])): ?><div class="invalid-feedback">Valid email required</div><?php endif; ?>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label required">Phone</label>
                <input type="text" name="phone" class="form-control <?= isset($errors['phone']) ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($phone ?? '') ?>" required>
                <?php if (isset($errors['phone'])): ?><div class="invalid-feedback"><?= htmlspecialchars($errors['phone']) ?></div><?php endif; ?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6 mb-3">
                <label class="form-label required">Address</label>
                <input type="text" name="address" class="form-control <?= isset($errors['address']) ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($address ?? '') ?>" required>
                <?php if (isset($errors['address'])): ?><div class="invalid-feedback">Address is required</div><?php endif; ?>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label required">Gender</label>
                <select name="gender" class="form-select <?= isset($errors['gender']) ? 'is-invalid' : '' ?>" required>
                    <option value="">Select</option>
                    <option value="Male" <?= (isset($gender) && $gender=="Male") ? 'selected':'' ?>>Male</option>
                    <option value="Female" <?= (isset($gender) && $gender=="Female") ? 'selected':'' ?>>Female</option>
                    <option value="Other" <?= (isset($gender) && $gender=="Other") ? 'selected':'' ?>>Other</option>
                </select>
                <?php if (isset($errors['gender'])): ?><div class="invalid-feedback">Gender is required</div><?php endif; ?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6 mb-3">
                <label class="form-label required">Date of Birth</label>
                <div class="input-group">
                    <input type="date" name="date_of_birth" class="form-control <?= isset($errors['date_of_birth']) ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($date_of_birth ?? '') ?>" required>
                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                </div>
                <?php if (isset($errors['date_of_birth'])): ?><div class="invalid-feedback">Date of Birth is required</div><?php endif; ?>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">NID</label>
                <input type="text" name="nid" class="form-control" value="<?= htmlspecialchars($nid ?? '') ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6 mb-3">
                <label class="form-label required">Join Date</label>
                <div class="input-group">
                    <input type="date" name="join_date" class="form-control <?= isset($errors['join_date']) ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($join_date ?? '') ?>" required>
                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                </div>
                <?php if (isset($errors['join_date'])): ?><div class="invalid-feedback">Join Date is required</div><?php endif; ?>
            </div>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label required">Status</label>
            <select class="form-select status-small" name="status" id="status" required>
                <option value="1" <?=((isset($status) && $status=='1')?'selected':'')?>>Active</option>
                <option value="0" <?=((isset($status) && $status=='0')?'selected':'')?>>Inactive</option>
                <option value="2" <?=((isset($status) && $status=='2')?'selected':'')?>>Resigned</option>
                <option value="3" <?=((isset($status) && $status=='3')?'selected':'')?>>Dismissed</option>
            </select>
        </div>
        <div class="mb-3 text-end">
            <a href="employee_list.php" class="btn btn-secondary">Cancel</a>
            <button class="btn btn-primary" type="submit">Save</button>
        </div>
    </form>
</div>
<!-- Bootstrap JS, jQuery (for AJAX), Tom Select -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script>
$(document).ready(function() {
    // Tom Select for Department and Unit only
    var deptSelect = new TomSelect('#department_id', {create: false, sortField: 'text', allowEmptyOption: true, persist: false, maxOptions: 5000});
    var unitSelect = new TomSelect('#unit_id', {create: false, sortField: 'text', allowEmptyOption: true, persist: false, maxOptions: 5000});

    // AJAX for Unit
    $('#department_id').on('change', function(){
        var deptId = $(this).val();
        unitSelect.clear(true); // clear existing selection/options
        unitSelect.clearOptions();
        if (!deptId) return;
        $.ajax({
            url: 'get_units.php',
            method: 'POST',
            data: {department_id: deptId},
            dataType: 'json',
            success: function(data) {
                unitSelect.addOption({value:"",text:"--- Select Unit ---"});
                $.each(data, function(i, unit){
                    unitSelect.addOption({value:unit.unit_id, text:unit.unit_name});
                });
                unitSelect.refreshOptions(false);
            }
        });
    });

    // On initial load: auto-populate Unit select if Department and Unit are set (edit mode)
    <?php if (isset($department_id) && $department_id > 0 && isset($unit_id) && $unit_id > 0 && empty($errors)) : ?>
    $.ajax({
        url: 'get_units.php',
        method: 'POST',
        data: {department_id: <?= intval($department_id) ?>},
        dataType: 'json',
        success: function(data) {
            unitSelect.clear(true);
            unitSelect.clearOptions();
            unitSelect.addOption({value:"",text:"--- Select Unit ---"});
            $.each(data, function(i, unit){
                unitSelect.addOption({value:unit.unit_id, text:unit.unit_name});
            });
            unitSelect.refreshOptions(false);
            unitSelect.setValue("<?= htmlspecialchars($unit_id) ?>");
        }
    });
    <?php endif; ?>
});
</script>
<?php require_once(__DIR__ . '/../../include/footer.php'); ?>
</body>
</html>
