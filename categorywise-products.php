<?php
session_start();
error_reporting(0);

include('includes/dbconnection.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Agriculture Equipment Rental Management System - Shopping Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body class="goto-here">
    <?php include_once('includes/header.php');?>

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
        <div class="row">
          <?php
          $cid = $_GET['catid'];

          $pageno = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
          $no_of_records_per_page = 8;
          $offset = ($pageno - 1) * $no_of_records_per_page;

          $category_query = mysqli_query($con, "SELECT CategoryName FROM tblcategory WHERE ID='$cid'");
          $category = mysqli_fetch_array($category_query)['CategoryName'];

          $product_count_query = mysqli_query($con, "SELECT COUNT(*) AS product_count FROM tblproduct WHERE CategoryID='$cid' AND Image IS NOT NULL AND Image <> ''");
          $product_count = mysqli_fetch_array($product_count_query)['product_count'];

          $query = mysqli_query($con, "SELECT ProductName, ID, RentPrice, Image FROM tblproduct WHERE CategoryID='$cid' AND Image IS NOT NULL AND Image <> '' LIMIT $offset, $no_of_records_per_page");
          ?>

          <h2 class="category-name mb-4"><?php echo htmlentities($category) . " (" . htmlentities($product_count) . " products)"; ?></h2>

          <?php if(mysqli_num_rows($query) > 0) { ?>
            <div class="row">
              <?php while ($row = mysqli_fetch_array($query)) { ?>
                <div class="col-md-6 col-lg-3 ftco-animate">
                  <div class="product">
                    <a href="single-product-details.php?viewid=<?php echo htmlentities($row['ID']); ?>" class="img-prod">
                      <img class="img-fluid" 
                           src="admin/images/<?php echo htmlentities($row['Image']); ?>" 
                           onerror="this.onerror=null;this.src='images/noimage.png';" 
                           alt="Product Image">
                      <div class="overlay"></div>
                    </a>
                    <div class="text py-3 pb-4 px-3 text-center">
                      <h3><a href="single-product-details.php?viewid=<?php echo htmlentities($row['ID']); ?>"><?php echo htmlentities($row['ProductName']); ?></a></h3>
                      <div class="d-flex">
                        <div class="pricing">
                          <p class="price"><span class="price-sale">Rs <?php echo htmlentities($row['RentPrice']); ?>/day</span></p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>
            </div>
          <?php } else { ?>
            <hr>
            <div class="row mt-5">
              <div class="col text-center">
                <div class="page-pagi">
                  <p>No products available in this category right now. New stock will be available in <strong>one week</strong>! Check back soon.</p>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>

        <div class="row mt-5">
          <div class="col text-center">
            <div class="page-pagi">
              <nav aria-label="Page navigation example">
                <ul class="pagination">
                  <li class="page-item"><a class="page-link" href="?catid=<?php echo $cid; ?>&pageno=1"><strong>First</strong></a></li>
                  <li class="page-item <?php echo ($pageno <= 1) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="<?php echo ($pageno <= 1) ? '#' : "?catid=$cid&pageno=" . ($pageno - 1); ?>"><strong>Prev</strong></a>
                  </li>
                  <li class="page-item <?php echo ($pageno >= ceil($product_count / $no_of_records_per_page)) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="<?php echo ($pageno >= ceil($product_count / $no_of_records_per_page)) ? '#' : "?catid=$cid&pageno=" . ($pageno + 1); ?>"><strong>Next</strong></a>
                  </li>
                  <li class="page-item"><a class="page-link" href="?catid=<?php echo $cid; ?>&pageno=<?php echo ceil($product_count / $no_of_records_per_page); ?>"><strong>Last</strong></a></li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </section>

    <?php include_once('includes/footer.php');?>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>
