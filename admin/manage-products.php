<?php  
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['aid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_GET['delid'])) {
        $rid = intval($_GET['delid']);

        // Use prepared statement for secure deletion
        $stmt = mysqli_prepare($con, "DELETE FROM tblproduct WHERE ID = ?");
        mysqli_stmt_bind_param($stmt, "i", $rid);
        $execute = mysqli_stmt_execute($stmt);

        if ($execute) {
            echo "<script>alert('Product details deleted successfully.');</script>";
            echo "<script type='text/javascript'> document.location = 'manage-products.php'; </script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again.');</script>";
        }

        mysqli_stmt_close($stmt);
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Agriculture Equipment Rental Management System | Manage Products</title>
    <!-- Style-sheets -->
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" href="css/style4.css">
    <link href="css/fontawesome-all.css" rel="stylesheet">
    <!-- Web fonts -->
    <link href="//fonts.googleapis.com/css?family=Poiret+One" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <?php include_once('includes/sidebar.php'); ?>

        <!-- Page Content -->
        <div id="content">
            <?php include_once('includes/header.php'); ?>

            <h2 class="main-title-w3layouts mb-2 text-center">Manage Products</h2>

            <!-- Tables content -->
            <section class="tables-section">
                <div class="outer-w3-agile mt-3">
                    <h4 class="tittle-w3-agileits mb-4">Manage Products</h4>
                    <div class="container-fluid">
                        <div class="row">
                            <?php
                            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                            $records_per_page = 10;
                            $offset = ($page - 1) * $records_per_page;

                            $query = "SELECT * FROM tblproduct LIMIT $records_per_page OFFSET $offset";
                            $ret = mysqli_query($con, $query);
                            ?>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>S.NO</th>
                                        <th>Product Name</th>
                                        <th>Model Number</th>
                                        <th>Rent Price (per day)</th>
                                        <th>Creation Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $cnt = $offset + 1;
                                    while ($row = mysqli_fetch_array($ret)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $cnt; ?></td>
                                            <td><?php echo $row['ProductName']; ?></td>
                                            <td><?php echo $row['ModelNumber']; ?></td>
                                            <td><?php echo $row['RentPrice']; ?></td>
                                            <td><?php echo $row['CreationDate']; ?></td>
                                            <td>
                                                <a class="btn btn-sm btn-primary" href="edit-product.php?editid=<?php echo $row['ID']; ?>">Edit</a>
                                                <a class="btn btn-sm btn-danger" href="manage-products.php?delid=<?php echo $row['ID']; ?>" onclick="return confirm('Do you really want to Delete ?');">Delete</a>
                                            </td>
                                        </tr>
                                    <?php
                                        $cnt++;
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <?php
                            $total_query = "SELECT COUNT(*) as total FROM tblproduct";
                            $total_result = mysqli_query($con, $total_query);
                            $total_row = mysqli_fetch_array($total_result);
                            $total_records = $total_row['total'];
                            $total_pages = ceil($total_records / $records_per_page);

                            echo '<nav>';
                            echo '<ul class="pagination">';
                            for ($i = 1; $i <= $total_pages; $i++) {
                                echo '<li class="page-item ' . ($i == $page ? 'active' : '') . '">';
                                echo '<a class="page-link" href="manage-products.php?page=' . $i . '">' . $i . '</a>';
                                echo '</li>';
                            }
                            echo '</ul>';
                            echo '</nav>';
                            ?>
                        </div>
                    </div>
                </div>
            </section>

            <?php include_once('includes/footer.php'); ?>
        </div>
    </div>

    <!-- Scripts -->
    <script src='js/jquery-2.2.3.min.js'></script>
    <script>
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });

            $(".dropdown").hover(
                function () {
                    $('.dropdown-menu', this).stop(true, true).slideDown("fast");
                    $(this).toggleClass('open');
                },
                function () {
                    $('.dropdown-menu', this).stop(true, true).slideUp("fast");
                    $(this).toggleClass('open');
                }
            );
        });
    </script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
<?php } ?>
