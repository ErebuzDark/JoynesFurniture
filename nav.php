<?php

$sql = "
    SELECT status, SUM(total) AS total FROM (
        SELECT 'Pending Approval' AS status, COUNT(*) AS total 
        FROM checkoutcustom 
        WHERE status = 'Pending Approval' AND userID = $userID

        UNION ALL

        SELECT 'Pending Approval' AS status, COUNT(*) AS total 
        FROM checkout 
        WHERE status = 'Pending Approval' AND userID = $userID

        UNION ALL

        SELECT 'On Progress' AS status, COUNT(*) AS total 
        FROM checkoutcustom 
        WHERE status = 'In progress' AND userID = $userID

        UNION ALL

        SELECT 'On Progress' AS status, COUNT(*) AS total 
        FROM checkout 
        WHERE status = 'In progress' AND userID = $userID

        UNION ALL

        SELECT 'Completed' AS status, COUNT(*) AS total 
        FROM checkoutcustom 
        WHERE status = 'Completed' AND userID = $userID

        UNION ALL

        SELECT 'Completed' AS status, COUNT(*) AS total 
        FROM checkout 
        WHERE status = 'Completed' AND userID = $userID
    ) AS combined
    GROUP BY status
";

$result = $conn->query($sql);

$notifications = [
    'Pending Approval' => 0,
    'On Progress' => 0,
    'Completed' => 0,
];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $notifications[$row['status']] = $row['total'];
    }
}

// Total count of all notifications (if greater than 0)
$totalNotifications = array_sum(array_filter($notifications));


// Total notification count (only count those > 0)
$totalNotifications = array_sum(array_filter($notifications));
?>



<!-- Navbar start -->
<div class="container-fluid fixed-top">
    <div class="container topbar d-none d-lg-block">
    </div>

    <div class="container px-0">
        <nav class="navbar navbar-light bg-white navbar-expand-xl">
            <a href="shop.php" class="navbar-brand"><img class="logo" src="./img/logo1.png" alt="Bootstrap"
                    style="width: 200px"></a>

            <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarCollapse">
                <span class="fa fa-bars text-primary"></span>
            </button>

            <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                <ul class="navbar-nav mx-auto">
                    <!-- Optional nav links here -->
                </ul>

                <ul class="navbar-nav">
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link position-relative <?php echo $totalNotifications > 0 ? 'fw-bold text-dark' : 'text-muted'; ?>"
                            href="#" id="alertsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-bell fa-fw"></i>
                            <?php if ($totalNotifications > 0): ?>
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark">
                                    <?php echo $totalNotifications; ?>
                                </span>
                            <?php endif; ?>
                        </a>

                        <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in"
                            aria-labelledby="alertsDropdown">
                            <h6 class="dropdown-header">Notifications</h6>

                            <?php if ($notifications['Pending Approval'] > 0): ?>
                                <a class="dropdown-item d-flex align-items-center" href="profile.php#on-queue">
                                    <div class="me-3">
                                        <div class="icon-circle">
                                            <i class="fas fa-hourglass-start text-warning"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500"><?php echo date('F j, Y'); ?></div>
                                        <span
                                            class="<?php echo $notifications['Pending Approval'] > 0 ? 'fw-bold' : ''; ?>">
                                            <?php echo $notifications['Pending Approval']; ?> order(s) pending approval
                                        </span>
                                    </div>
                                </a>
                            <?php endif; ?>

                            <?php if ($notifications['On Progress'] > 0): ?>
                                <a class="dropdown-item d-flex align-items-center" href="profile.php#on-progress">
                                    <div class="me-3">
                                        <div class="icon-circle">
                                            <i class="fas fa-cogs text-success"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500"><?php echo date('F j, Y'); ?></div>
                                        <span class="<?php echo $notifications['On Progress'] > 0 ? 'fw-bold' : ''; ?>">
                                            <?php echo $notifications['On Progress']; ?> order(s) on progress
                                        </span>
                                    </div>
                                </a>
                            <?php endif; ?>

                            <?php if ($notifications['Completed'] > 0): ?>
                                <a class="dropdown-item d-flex align-items-center" href="profile.php#completed">
                                    <div class="me-3">
                                        <div class="icon-circle">
                                            <i class="fas fa-check-circle text-primary"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500"><?php echo date('F j, Y'); ?></div>
                                        <span class="<?php echo $notifications['Completed'] > 0 ? 'fw-bold' : ''; ?>">
                                            <?php echo $notifications['Completed']; ?> order(s) completed
                                        </span>
                                    </div>
                                </a>
                            <?php endif; ?>

                            <?php if ($totalNotifications == 0): ?>
                                <div class="dropdown-item text-center small text-gray-500">No new notifications</div>
                            <?php endif; ?>
                        </div>
                    </li>
                </ul>



                <!-- Customize & Cart Icons -->
                <div class="d-flex align-items-center ms-3">
                    <a href="customize.php" class="me-3">
                        <img width="40" height="40" src="https://img.icons8.com/ios-filled/50/737373/hammer.png"
                            alt="hammer">
                    </a>
                    <a href="cart.php" class="position-relative me-4 text-muted">
                        <i class="fa fa-shopping-bag fa-2x"></i>
                        <span
                            class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1"
                            style="top: -5px; left: 15px; height: 20px; min-width: 20px;"><?php echo $i; ?></span>
                    </a>
                    <!-- User Dropdown -->
                    <div class="nav-item dropdown">
                        <i class="fas fa-user fa-2x"></i>
                        <div class="dropdown-menu m-0 bg-secondary rounded-0">
                            <a href="profile.php" class="dropdown-item">My Profile</a>
                            <a href="logout.php" class="dropdown-item"><i class="fa fa-sign-out"></i>Log Out</a>
                        </div>
                    </div>
                </div>
            </div>

        </nav>
    </div>
</div>