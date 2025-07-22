<?php
require_once(__DIR__ . '/../config/db.php');

$role_id = isset($_SESSION['role_id']) ? intval($_SESSION['role_id']) : 0;

// Populate allowed menu list for this role
$allowed_menus = [];
if ($role_id > 0) {
    $sql = "
        SELECT m.menu_name
        FROM role_menu rm
        JOIN menus m ON rm.menu_id = m.menu_id
        WHERE rm.role_id = ?
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $role_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $allowed_menus[] = $row['menu_name'];
    }
    $stmt->close();
}

// function to check and print each sub-menu with enabled/disabled feature. complete <li>.
function menu_link($menu_name, $href, $icon, $allowed_menus) {
    $enabled = in_array($menu_name, $allowed_menus);
    $class = $enabled ? 'dropdown-item' : 'dropdown-item disabled text-secondary';
    $href_attr = $enabled ? $href : '#';
    $tabindex = $enabled ? '' : ' tabindex="-1" aria-disabled="true"';
    echo '<li><a class="' . $class . '" href="' . $href_attr . '"' . $tabindex . '>';
    if ($icon) echo '<i class="fa ' . $icon . '"></i> ';
    echo htmlspecialchars($menu_name) . '</a></li>';
}
?>

<!-- Menu  -->
<nav class="navbar navbar-expand-lg navbar-dark menu-ho-navbar shadow-sm w-100" style="background:linear-gradient(90deg,#123c63 80%,#0d6efd 100%); margin-bottom:0;">
  <div class="container-fluid d-fex justify-content-center align-items-center">
    <!-- <a class="navbar-brand d-flex align-items-center gap-2" href="#">
      <span class="fw-bold fs-5">Trimatric Architects & Engineers</span>
    </a> -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#hoNavbar" aria-controls="hoNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="hoNavbar">
      <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-lg-2">

        <!-- Dashboard -->
        <li class="nav-item">
          <a class="nav-link" href="/trimatric/ho_dashboard.php"><i class="fa fa-gauge-high"></i> Dashboard</a>
        </li>

        <!-- Location Settings -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            <i class="fa fa-location-dot"></i> Location Settings
          </a>
          <ul class="dropdown-menu">
            <?php
              menu_link('Division', '#', 'fa-layer-group', $allowed_menus);
              menu_link('District', '#', 'fa-city', $allowed_menus);
              menu_link('Upazila', '#', 'fa-location-arrow', $allowed_menus);
              menu_link('Union', '#', 'fa-map-pin', $allowed_menus);
              menu_link('Village', '#', 'fa-house-flag', $allowed_menus);
            ?>
          </ul>
        </li>

        <!-- Cluster Management -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
            <i class="fa fa-people-group"></i> Cluster Management
          </a>
          <ul class="dropdown-menu">
            <?php
              menu_link('Define Cluster', '#', 'fa-clone', $allowed_menus);
              menu_link('Cluster Member', '#', 'fa-user-group', $allowed_menus);
              menu_link('Cluster Project', '#', 'fa-diagram-project', $allowed_menus);
              menu_link('Cluster Supervisor', '#', 'fa-user-tie', $allowed_menus);
              menu_link('Client', '#', 'fa-users', $allowed_menus);
            ?>
          </ul>
        </li>

        <!-- Head Office -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
            <i class="fa fa-building"></i> Head Office
          </a>
          <ul class="dropdown-menu">
            <?php
              menu_link('Department', '#', 'fa-sitemap', $allowed_menus);
              menu_link('Unit', '#', 'fa-cubes', $allowed_menus);
              menu_link('Employee Info', '/trimatric/modules/employee/employee_list.php', 'fa-id-card', $allowed_menus);
            ?>
          </ul>
        </li>

        <!-- User Administration -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
            <i class="fa fa-user-cog"></i> User Administration
          </a>
          <ul class="dropdown-menu">
            <?php
              menu_link('Role', '#', 'fa-user-tag', $allowed_menus);
              menu_link('Menu', '#', 'fa-bars', $allowed_menus);
              menu_link('Role-Menu Mapping', '#', 'fa-link', $allowed_menus);
              menu_link('User', '#', 'fa-users', $allowed_menus);
            ?>
          </ul>
        </li>

        <!-- Registration -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
            <i class="fa fa-registered"></i> Registration
          </a>
          <ul class="dropdown-menu">
            <?php
              menu_link('Corporate Client', '#', 'fa-building-user', $allowed_menus);
              menu_link('Individual Client', '#', 'fa-user', $allowed_menus);
            ?>
          </ul>
        </li>

        <!-- Logout -->
        <li class="nav-item">
          <a class="nav-link" href="/trimatric/logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<style>
/* Disabled menu style */
.dropdown-item.disabled,
.dropdown-item:disabled {
    pointer-events: none;
    color: #999 !important;
    background-color: #f8f9fa !important;
    opacity: 0.7;
}
</style>
