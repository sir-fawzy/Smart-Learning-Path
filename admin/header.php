<!doctype html>

<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Instructor View</title>
    <meta name="description" content="Sufee Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">


    <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/selectFX/css/cs-skin-elastic.css">

    <link rel="stylesheet" href="assets/css/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

    <style>
        .sidebar {
            height: 100vh;

            width: 250px;

            background-color: #1f2937;

            display: flex;
            flex-direction: column;

            justify-content: space-between;

            padding: 10px;

        }

        .nav-item {
            color: white;
            margin: 10px 0;
            /* Space between items */
            display: flex;
            align-items: center;
            /* Vertically center icon and text */
        }

        .nav-item:hover {
            background-color: #374151;
            /* Darker background on hover */
            border-radius: 5px;
            cursor: pointer;
            padding: 5px;
        }
    </style>

</head>

<body>
    <!-- Left Panel -->

    <aside id="left-panel" class=" left-panel" style="background-color: #4C0013">
        <nav class=" navbar navbar-expand-sm navbar-default" style="height: 100%; background-color: #4C0013;">

            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu"
                    aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="./">Smart Learning Path</a>
                <a class="navbar-brand hidden" href="./"><img src="images/logo2.png" alt="Logo"></a>
            </div>

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="./index.html"> <i class="nav-item menu-icon fa fa-dashboard"></i>Dashboard </a>
                    </li>
                    <hr>
                    <li>
                        <a href="exam_category.php"> <i class="nav-item menu-icon fa fa-dashboard"></i>Lectures
                            Materials
                        </a>
                    </li>
                    <hr>
                    <li>
                        <a href="exam_category.php"> <i class="nav-item menu-icon fa fa-dashboard"></i>Homework
                        </a>
                    </li>
                    <li>
                        <a href="exam_category.php"> <i class="nav-item menu-icon fa fa-dashboard"></i>Excerises
                        </a>
                    </li>
                    <li>
                        <a href="exam_category.php"> <i class="nav-item menu-icon fa fa-dashboard"></i>Quizzes
                        </a>
                    </li>
                    <li>
                        <a href="exam_category.php"> <i class="nav-item menu-icon fa fa-dashboard"></i>Exams
                        </a>
                    </li>

                    <li>
                        <a href="exam_category.php"> <i class="nav-item menu-icon fa fa-dashboard"></i>Supplements
                        </a>
                    </li>
                    <li>
                        <a href="index.html"> <i class="nav-item menu-icon fa fa-close"></i>Logout </a>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside><!-- /#left-panel -->

    <!-- Left Panel -->

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <header id="header" class="header">
            <div class="header-menu">
                <div class="col-sm-7">
                    <!-- Other content can go here -->
                </div>

                <div class="col-sm-5">
                    <div class="user-area dropdown float-right">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <img class="user-avatar rounded-circle" src="images/admin.jpg" alt="User Avatar">
                        </a>

                        <div class="user-menu dropdown-menu dropdown-menu-right">
                            <!-- Added dropdown-menu-right to align -->
                            <a class="nav-link" href="#"><i class="fa fa-power-off"></i> Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>