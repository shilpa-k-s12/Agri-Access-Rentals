<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Agri Access Rentals - Shopping Page</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>
<body class="goto-here">
  <?php include_once('includes/header.php'); ?>

  <div class="hero-wrap hero-bread" style="background-image: url('images/bg_1.jpg');">
    <div class="container">
      <div class="row no-gutters slider-text align-items-center justify-content-center">
        <div class="col-md-9 ftco-animate text-center">
          <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Category Wise Products</span></p>
          <h1 class="mb-0 bread">Products</h1>
        </div>
      </div>
    </div>
  </div>

  <section class="ftco-section">
    <div class="container">
      <?php
      $cid = $_GET['catid'];
      $pageno = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
      $no_of_records_per_page = 8;
      $offset = ($pageno - 1) * $no_of_records_per_page;

      $category_query = mysqli_query($con, "SELECT CategoryName FROM tblcategory WHERE ID='$cid'");
      $category = mysqli_fetch_array($category_query)['CategoryName'];

      $product_count_query = mysqli_query($con, "SELECT COUNT(*) AS product_count FROM tblproduct WHERE CategoryID='$cid'");
      $product_count = mysqli_fetch_array($product_count_query)['product_count'];

      $total_pages_sql = "SELECT COUNT(*) FROM tblproduct WHERE CategoryID='$cid'";
      $ret1 = mysqli_query($con, $total_pages_sql);
      $total_rows = mysqli_fetch_array($ret1)[0];
      $total_pages = ceil($total_rows / $no_of_records_per_page);

      $query = mysqli_query($con, "SELECT ID, ProductName, RentPrice, Image FROM tblproduct WHERE CategoryID='$cid' LIMIT $offset, $no_of_records_per_page");
      ?>

      <h2 class="category-name"><?php echo $category . " (" . $product_count . " products)"; ?></h2>
      <div class="row">
        <?php if (mysqli_num_rows($query) > 0) {
          while ($row = mysqli_fetch_array($query)) { ?>
          <div class="col-md-6 col-lg-3 ftco-animate">
            <div class="product">
              <a href="single-product-details.php?viewid=<?php echo $row['ID']; ?>" class="img-prod">
                <img src="admin/images/<?php echo $row['Image']; ?>" class="img-fluid" style="width: 100%; height: 230px; object-fit: cover;">
                <div class="overlay"></div>
              </a>
              <div class="text py-3 pb-4 px-3 text-center">
                <h3><a href="single-product-details.php?viewid=<?php echo $row['ID']; ?>"><?php echo $row['ProductName']; ?></a></h3>
                <div class="pricing">
                  <p class="price"><span class="price-sale">Rs <?php echo $row['RentPrice']; ?>/day</span></p>
                </div>
              </div>
            </div>
          </div>
        <?php } } else { ?>
          <div class="col-12 text-center">
            <p>No products available in this category right now. Check back soon.</p>
          </div>
        <?php } ?>
      </div>

      <div class="row mt-5">
        <div class="col text-center">
          <div class="page-pagi">
            <nav aria-label="Page navigation example">
              <ul class="pagination justify-content-center">
                <li class="page-item <?php if($pageno <= 1) echo 'disabled'; ?>">
                  <a class="page-link" href="?pageno=1">First</a>
                </li>
                <li class="page-item <?php if($pageno <= 1) echo 'disabled'; ?>">
                  <a class="page-link" href="?pageno=<?php echo max(1, $pageno - 1); ?>">Prev</a>
                </li>
                <li class="page-item <?php if($pageno >= $total_pages) echo 'disabled'; ?>">
                  <a class="page-link" href="?pageno=<?php echo min($total_pages, $pageno + 1); ?>">Next</a>
                </li>
                <li class="page-item <?php if($pageno >= $total_pages) echo 'disabled'; ?>">
                  <a class="page-link" href="?pageno=<?php echo $total_pages; ?>">Last</a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php include_once('includes/footer.php'); ?>

  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>
</body>
</html>
