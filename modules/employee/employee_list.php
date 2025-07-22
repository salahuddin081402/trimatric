<?php
require_once(__DIR__ . '/../../config/db.php');
require_once(__DIR__ . '/../../include/header.php');
require_once(__DIR__ . '/../../include/menu_ho.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// CSRF token for delete
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// --- 1. Read paging/search parameters(Pagination) ---
$page    = isset($_GET['page'])  ? max(1, intval($_GET['page'])) : 1;  /* default 1 , if page number not sent in query string */
$limit   = isset($_GET['limit']) ? max(1, intval($_GET['limit'])) : 10;/* default 10 , if page number not sent in query string */
$search  = isset($_GET['search']) ? trim($_GET['search']) : '';
$offset  = ($page - 1) * $limit;

// --- 2. Build WHERE clause for search (Pagination) ---
$where   = '';
$params  = [];
$types   = '';
if ($search !== '') {
    $where = "WHERE e.employee_name LIKE ? OR e.email LIKE ? OR e.designation LIKE ? OR d.department_name LIKE ? OR u.unit_name LIKE ?";
    // Repeated 5 times same thing for Array Fill up
    $params = array_fill(0, 5, "%$search%"); 
    // Seting type of each bind place holder. Here, all are string. so 's' is used 5 times.
    $types  = 'sssss';
}

// --- 3. Get total records count (Pagination) ---
// SQL query that counts the total number of employee records matching search criteria(if there).
$count_sql = "SELECT COUNT(*) FROM employee_info e JOIN unit u ON e.unit_id=u.unit_id JOIN department d ON u.department_id=d.department_id $where";
$count_stmt = $conn->prepare($count_sql);
    // checks whether where clause is prepared for search condition matching
if ($where) {  
    $bind_names = [];
    $bind_names[] = $types;
    foreach ($params as $key => $value) {
        $bind_names[] = &$params[$key];
    }
    //The following function is used only for this dynamic binding for dynamic where clause
    call_user_func_array([$count_stmt, 'bind_param'], $bind_names);
}
$count_stmt->execute();
$count_stmt->bind_result($total_records);
$count_stmt->fetch();
$count_stmt->close();

$total_pages = max(1, ceil($total_records / $limit));

// --- 4. Get current page data ---
$data_sql = "
    SELECT e.*, d.department_name, u.unit_name 
    FROM employee_info e
    JOIN unit u ON e.unit_id = u.unit_id
    JOIN department d ON u.department_id = d.department_id
    $where
    ORDER BY e.employee_id DESC
    LIMIT ? OFFSET ?
";
$data_stmt = $conn->prepare($data_sql);
if ($where) {
    $bind_names = [];
    $bind_names[] = $types . 'ii';
    foreach ($params as $key => $value) {
        $bind_names[] = &$params[$key];
    }
    $bind_names[] = &$limit;
    $bind_names[] = &$offset;
    call_user_func_array([$data_stmt, 'bind_param'], $bind_names);
} else {
    $data_stmt->bind_param('ii', $limit, $offset);
}
$data_stmt->execute();
$result = $data_stmt->get_result();
$employees = $result->fetch_all(MYSQLI_ASSOC);
$data_stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Information</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background: #f6f8fa;
        }
        .container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 16px #0002;
            padding: 2rem;
            margin-bottom: 2rem;
            border-left: 2px solid #1a237e;
            border-right: 2px solid #1a237e;
            border-bottom: 2px solid #1a237e;
            border-top: 2px solid #1a237e;
        }
        .main-title {
            font-size: 2.1rem;
            font-weight: bold;
            color: #12203a;
            text-align: center;
            margin-bottom: 1.3rem;
            letter-spacing: .02em;
        }
        .controls-bar {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: .5rem;
            margin-bottom: 1rem;
            background: #e3f2fd;
            border-radius: 0.5rem;
            padding: .6rem 1rem;
            border: 1px solid #1976d2;
        }
        .controls-bar > * {    /* For all direct child of controls-bar */
            flex: 1 1 180px;   /* shorthand for three flexbox properties: flex-grow: 1, flex-shrink: 1, flex-basis: 180px */
            min-width: 120px;  
            color: #12203a !important;
        }
        .search-form input[type="search"] {
            background: #fff;
            color: #12203a;
            border-radius: 0.5rem;
            border: 1px solid #bbb;
            padding: 0.25rem 0.5rem;
            width: 100%;
            max-width: 200px;
        }
        .add-btn-bar {
            margin-bottom: 1rem;
            text-align: right;
        }
        .table-responsive {
            max-height: 420px;
            overflow: auto;  /* Scrolling bar when needed */
        }
        table {
            min-width: 950px;
        }
        
        
       
        .table-bordered th, .table-bordered td {
            border-color: #1976d2 !important;
            border-width: 1.1px;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #e3f2fd !important;
        }
        .table-hover tbody tr:hover {
            background-color: #bbdefb !important;
        }
        .table td, .table th {
            vertical-align: middle;
            font-size: 1rem;
        }
         thead th {
            position: sticky;
            top: 0;
            color: #12203a;
            background: #3f7ae8ff;
            border: 1px solid #1976d2 !important;
            border-top: 2px solid #1976d2 !important;
            font-size: 1.08rem;
            z-index: 2;
        }
        @media (max-width: 600px) {
            .controls-bar { flex-direction: column; align-items: stretch; }
            .add-btn-bar { text-align: center; }
            .main-title { font-size: 1.25rem; }
            .container { padding: .5rem !important; }
            .search-form input[type="search"] { max-width: 100%; }
            table { min-width: 650px; }
        }
        @media (max-width: 400px) {
            table, th, td { font-size: .80rem !important; }
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <div class="main-title">Employee Information</div>
    <div class="add-btn-bar mb-2">
        <a href="add_employee.php" class="btn btn-primary"><i class="fa fa-plus"></i> Add Employee</a>
    </div>
    <!-- Control Panel: Show entries + Search (Pagination) -->
    <form method="get" class="controls-bar row gx-2 gy-1 align-items-center">
        <div class="col-md-3 col-12">
            Show
            <select name="limit" class="form-select d-inline w-auto" style="width: auto; display: inline;" onchange="this.form.submit()">
                <?php foreach ([10,25,50,100] as $opt): ?>
                <option value="<?= $opt ?>" <?= $limit==$opt ? 'selected':'' ?>><?= $opt ?></option>
                <?php endforeach; ?>
            </select>
            entries
        </div>
        <div class="col-md-4 col-12 ms-auto text-end search-form">
            <input type="search" name="search" class="form-control d-inline" value="<?= htmlspecialchars($search) ?>" placeholder="Search...">
        </div>
        <div class="col-md-2 col-12 text-end">
            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Go</button>
        </div>
    </form>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped align-middle rounded-3">
            <thead>
                <tr>
                    <th>ID</th><th>Name</th><th>Designation</th>
                    <th>Department</th><th>Unit</th>
                    <th>Email</th><th>Phone</th><th>Status</th><th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($employees as $row): ?>
                <tr id="row-<?php echo $row['employee_id']; ?>">
                    <td><?= htmlspecialchars($row['employee_id']); ?></td>
                    <td><?= htmlspecialchars($row['employee_name']); ?></td>
                    <td><?= htmlspecialchars($row['designation']); ?></td>
                    <td><?= htmlspecialchars($row['department_name']); ?></td>
                    <td><?= htmlspecialchars($row['unit_name']); ?></td>
                    <td><?= htmlspecialchars($row['email']); ?></td>
                    <td><?= htmlspecialchars($row['phone']); ?></td>
                    <td>
                    <?php if($row['status']): ?>
                        <span class="badge bg-success">Active</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">Inactive</span>
                    <?php endif; ?>
                    </td>
                    <td>
                        <!-- Since, type="button" it will not submit when clicked  -->
                        <!-- I have used HTML 5 Data attribute here for Jquery use  -->
                        <button type="button"   
                            class="btn btn-warning btn-sm me-1 edit-btn"
                            data-id="<?= $row['employee_id']; ?>">   
                            Edit
                        </button>
                        <button type="button"
                            class="btn btn-danger btn-sm delete-btn"
                            data-id="<?= $row['employee_id']; ?>">
                            Delete
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination Controls -->
    <nav>
      <ul class="pagination justify-content-center mt-3">
        <?php if ($page > 1): ?>
          <li class="page-item">
            <a class="page-link" href="?page=<?= $page-1 ?>&limit=<?= $limit ?>&search=<?= urlencode($search) ?>">Previous</a>
          </li>
        <?php endif; ?>
        <?php
        // Show a window of page numbers (max 7 at a time)
        $start = max(1, $page-3);
        $end   = min($total_pages, $page+3);
        if ($start > 1) echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
        for ($i=$start; $i<=$end; $i++): ?>
          <li class="page-item <?= $i == $page ? 'active' : '' ?>">
            <a class="page-link" href="?page=<?= $i ?>&limit=<?= $limit ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
          </li>
        <?php endfor;
        if ($end < $total_pages) echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
        ?>
        <?php if ($page < $total_pages): ?>
          <li class="page-item">
            <a class="page-link" href="?page=<?= $page+1 ?>&limit=<?= $limit ?>&search=<?= urlencode($search) ?>">Next</a>
          </li>
        <?php endif; ?>
      </ul>
    </nav>
</div>

<!-- Delete Confirm Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Confirm Delete</h5></div>
      <div class="modal-body">Are you sure you want to delete this employee?</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
      </div>
    </div>
  </div>
</div>

<!-- JS: jQuery, Bootstrap 5 -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
    // Edit button Handler 
    /* Why I did not used normal 'Selector' here ?
    Answer is: Bcoz, Edit btn is dynamic not fixed in this page.
    Here, in advance, For all clicks in the document, check if the original dynamic target matches class .edit-btn,
    and if so, run this JQuery.  */
    $(document).on('click', '.edit-btn', function(){
        var id = $(this).data('id');
        window.location.href = 'edit_employee.php?id=' + id;
    });

    // Delete logic
    let deleteId = null;
    $(document).on('click', '.delete-btn', function(){
        deleteId = $(this).data('id');
        $('#deleteModal').modal('show');  /* Here, modal is a Bootstrap method. Not Jquery method.  */
    });
    $('#confirmDeleteBtn').click(function(){
        if(deleteId) {
            $.post('delete_employee.php', {
                id: deleteId,
                csrf_token: '<?= $_SESSION['csrf_token']; ?>'
            }, function(res){
                if(res === 'success') {
                    $('#row-' + deleteId).fadeOut();
                } else {
                    alert('Failed to delete employee!');
                }
                $('#deleteModal').modal('hide');
            });
        }
    });
});
</script>
<?php require_once(__DIR__ . '/../../include/footer.php'); ?>
</body>
</html>
