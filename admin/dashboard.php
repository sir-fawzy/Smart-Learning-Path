<?php 
include "header.php";
include "../connection.php";
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
</head>
<body>
      <section class="dashboard-cards">
      <div class="album py-5 bg-body-tertiary">
    <div class="container">

      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        <div class="col">
          <div class="card shadow-sm">
            <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>
            <div class="card-body">
              <p class="card-text">Add Lecture Materials</p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                <a href="upload_lecture.php" class="btn btn-sm btn-outline-secondary" role="button">Open</a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col">
          <div class="card shadow-sm">
            <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>
            <div class="card-body">
              <p class="card-text">Add Assesment Content</p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                <a href="exam_category.php" class="btn btn-sm btn-outline-secondary" role="button">Open</a>
                </div>
              </div>
            </div>
          </div>
        </div>
       
        <div class="col">
          <div class="card shadow-sm">
            <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>
            <div class="card-body">
              <p class="card-text">Grading and Results</p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                <a href="old_exam_results.php" class="btn btn-sm btn-outline-secondary" role="button">Open</a>
                </div>
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>



      </section>
  
</body>
</html>



