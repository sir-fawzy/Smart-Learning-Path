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
          <svg viewBox="0 0 400 300" xmlns="http://www.w3.org/2000/svg">

    <rect width="400" height="300" fill="#f5f5f5"/>

    <rect x="50" y="180" width="160" height="30" fill="#4a90e2"/>
    <rect x="45" y="150" width="160" height="30" fill="#e74c3c"/>
    <rect x="40" y="120" width="160" height="30" fill="#2ecc71"/>
    
    <rect x="240" y="140" width="120" height="80" fill="#34495e"/>
    <rect x="230" y="220" width="140" height="10" fill="#2c3e50"/>
    <rect x="250" y="150" width="100" height="60" fill="#ecf0f1"/>

    <path d="M40 90 L180 90 L170 200 L30 200 Z" fill="#fff"/>
    <line x1="60" y1="110" x2="160" y2="110" stroke="#95a5a6" stroke-width="2"/>
    <line x1="60" y1="130" x2="160" y2="130" stroke="#95a5a6" stroke-width="2"/>
    <line x1="60" y1="150" x2="160" y2="150" stroke="#95a5a6" stroke-width="2"/>
    
    <rect x="190" y="100" width="80" height="8" fill="#f1c40f" transform="rotate(45, 190, 100)"/>
    <polygon points="185,95 195,105 180,110" fill="#e67e22" transform="rotate(45, 190, 100)"/>
    
    <path d="M300 100 Q300 80 320 80 L340 80 Q360 80 360 100 L355 130 L305 130 Z" fill="#95a5a6"/>
    <ellipse cx="330" cy="80" rx="20" ry="5" fill="#7f8c8d"/>
    <path d="M360 95 Q380 100 375 115 Q370 130 360 125" fill="#7f8c8d"/>
    
    <path d="M320 70 Q325 60 330 70 Q335 80 340 70" fill="none" stroke="#95a5a6" stroke-width="2"/>
</svg>
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
          <svg viewBox="0 0 400 300" xmlns="http://www.w3.org/2000/svg">

    <rect width="400" height="300" fill="#f8f9fa"/>
    
    <rect x="100" y="40" width="200" height="240" rx="10" fill="#ffffff" stroke="#2c3e50" stroke-width="2"/>
    <rect x="100" y="40" width="200" height="40" rx="10" fill="#3498db"/>

    <rect x="180" y="30" width="40" height="20" rx="5" fill="#7f8c8d"/>
    
    <rect x="120" y="100" width="20" height="20" fill="#fff" stroke="#2c3e50" stroke-width="2"/>
    <rect x="120" y="140" width="20" height="20" fill="#fff" stroke="#2c3e50" stroke-width="2"/>
    <rect x="120" y="180" width="20" height="20" fill="#fff" stroke="#2c3e50" stroke-width="2"/>
    <path d="M120 220 h20 v20 h-20 z" fill="#fff" stroke="#2c3e50" stroke-width="2"/>
    
    <path d="M123 148 l5 5 l8 -8" stroke="#27ae60" stroke-width="3" fill="none"/>
    
    <line x1="150" y1="110" x2="280" y2="110" stroke="#95a5a6" stroke-width="2"/>
    <line x1="150" y1="150" x2="280" y2="150" stroke="#95a5a6" stroke-width="2"/>
    <line x1="150" y1="190" x2="280" y2="190" stroke="#95a5a6" stroke-width="2"/>
    <line x1="150" y1="230" x2="280" y2="230" stroke="#95a5a6" stroke-width="2"/>
    
    <circle cx="320" cy="70" r="25" fill="#e74c3c"/>
    <rect x="318" y="50" width="4" height="22" fill="white"/>
    <rect x="318" y="70" width="15" height="4" fill="white"/>
    
    <text x="340" y="180" font-family="Arial" font-size="40" font-weight="bold" fill="#27ae60">A+</text>

    <g transform="translate(50, 200) rotate(-45)">
        <rect x="0" y="0" width="80" height="8" fill="#f1c40f"/>
        <polygon points="0,0 0,8 -10,4" fill="#e67e22"/>
    </g>
    
    <circle cx="60" cy="100" r="8" fill="none" stroke="#3498db" stroke-width="2"/>
    <circle cx="60" cy="120" r="8" fill="none" stroke="#3498db" stroke-width="2"/>
    <circle cx="60" cy="140" r="8" fill="none" stroke="#3498db" stroke-width="2"/>
    <circle cx="60" cy="120" r="4" fill="#3498db"/>
</svg>
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
          <svg viewBox="0 0 400 300" xmlns="http://www.w3.org/2000/svg">
<rect width="400" height="300" fill="#f8f9fa"/>

<rect x="40" y="60" width="140" height="180" rx="5" fill="white" stroke="#2c3e50" stroke-width="2"/>
<rect x="230" y="60" width="140" height="180" rx="5" fill="white" stroke="#2c3e50" stroke-width="2"/>

<text x="65" y="45" font-family="Arial" font-size="16" fill="#2c3e50">Assignment Grades</text>
<text x="270" y="45" font-family="Arial" font-size="16" fill="#2c3e50">Progress</text>

<rect x="60" y="80" width="100" height="20" rx="3" fill="#3498db"/>
<rect x="60" y="110" width="85" height="20" rx="3" fill="#2ecc71"/>
<rect x="60" y="140" width="70" height="20" rx="3" fill="#e74c3c"/>
<rect x="60" y="170" width="90" height="20" rx="3" fill="#f1c40f"/>
<rect x="60" y="200" width="95" height="20" rx="3" fill="#9b59b6"/>

<circle cx="300" cy="150" r="60" fill="none" stroke="#3498db" stroke-width="15"/>
<path d="M300 150 L300 90 A60 60 0 0 1 352 180 Z" fill="#2ecc71" stroke="none"/>
<text x="285" y="160" font-family="Arial" font-size="24" font-weight="bold" fill="#2c3e50">85%</text>

<line x1="170" y1="90" x2="190" y2="90" stroke="#95a5a6" stroke-width="1"/>
<line x1="170" y1="120" x2="190" y2="120" stroke="#95a5a6" stroke-width="1"/>
<line x1="170" y1="150" x2="190" y2="150" stroke="#95a5a6" stroke-width="1"/>
<line x1="170" y1="180" x2="190" y2="180" stroke="#95a5a6" stroke-width="1"/>
<line x1="170" y1="210" x2="190" y2="210" stroke="#95a5a6" stroke-width="1"/>

<text x="45" y="270" font-family="Arial" font-size="14" fill="#7f8c8d"></text>
</svg>
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



