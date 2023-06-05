<?php

if (!isset($_SESSION)) {
    session_start();
}

include_once("connections/connection.php");
$con = connection();

if (isset($_GET['ID'])) {
    $id = $_GET['ID'];

    $sql = "SELECT * FROM students_list_old WHERE id = '$id'";
    
    $result = $con->query($sql) or die ($con->error);
    $row = $result->fetch_assoc();
    
    $sqlSubjects = "SELECT * FROM students_subjects_old WHERE id = '$id'";
    
    $resultSubjects = $con->query($sqlSubjects) or die ($con->error);
    $rowSubjects = $resultSubjects->fetch_assoc();
    
    $table1_subject = "";
    $table1_final_remark = "";
    
    if (!empty($rowSubjects)) {
        $table1_subject = $rowSubjects['table1_subject'];
        $table1_final_remark = $rowSubjects['table1_final_remark'];
    } else {
        $table1_subject = "N/A";
        $table1_final_remark = "N/A";
    }    
} else {
    header("Location: old-list.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/buttons.css">
    <title>Students Transcripts System</title>
</head>
<body>
<div id="wrapper">
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-user">
                    <div class="show-access">
                        <i class="fa-regular fa-circle-user"></i>
                        <?php
                        if (isset($_SESSION['UserLogin'])) {
                            if ($_SESSION['UserLogin'] === 'admin') {
                                echo "Welcome Admin";
                            } else {
                                echo "Welcome " . $_SESSION['UserLogin'];
                            }
                        } else {
                            echo "Welcome Guest";
                        }
                        ?>
                    </div>
                </li>
                <li>
                    <a href="home.php">
                    <i class="fa fa-home"></i> Home
                    </a>
                </li>
                <li>
                    <a href="new-list.php" target="_self">
                        <i class="fa-solid fa-table-list"></i> Students List New
                    </a>
                </li>
                <li>
                    <a href="old-list.php" target="_self">
                        <i class="fa-solid fa-table-list"></i> Students List Old
                    </a>
                </li>
                <li>
                    <a href="settings.php" target="_self">
                        <i class="fa-solid fa-gear"></i> Settings
                    </a>
                </li>
                <li>
                    <?php if(isset($_SESSION['Access']) && $_SESSION['Access'] == "administration") { ?>
                        <a href="login.php"><i class="fa-solid fa-right-from-bracket"></i> Log out</a>
                    <?php } elseif(isset($_SESSION['Access']) && $_SESSION['Access'] == "guest") { ?>
                        <a href="login.php"><i class="fa-solid fa-right-from-bracket"></i> Log out</a>
                    <?php } else { ?>
                        <a href="login.php">Log In</a>
                    <?php } ?>
                </li>
            </ul>
        </div>
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="top-section">
                    <button class="menu-btn" id="menu-toggle">
                        <span><i class="fa-solid fa-bars-staggered"></i></span>
                    </button>
                    <div class="clock-container">
                        <i class="fa-regular fa-calendar"></i><div id="clock"></div>
                    </div>
                </div>
                <div class="section-header">
                    <h1><?php echo $row['first_name']; ?>'s Information</span> <i class="fa-solid fa-circle-info"></i></h1>
                    <hr class="section-divider">
                </div>
                <div class="main-content">
                    <div class="table-controls">
                        <button class="btn"><a href="old-list.php"><i class="fa-solid fa-chevron-left"></i> Back</a></button>
                        <button class="btn"><a href="old-edit.php?ID=<?php echo $row['id']; ?>"><i class="fa-solid fa-pen-to-square"></i> Edit</a></button>
                    </div>
                    <div class="table-container">
                        <table class="table">
                            <tr>
                                <th class="th" colspan="5">SECONDARY STUDENT'S PERMANENT RECORD</th>
                            </tr>
                            <tr>
                                <td colspan="2" class="bold-letter">Last name: 
                                    <span class="value">
                                        <?php echo $row['last_name'] ?>
                                    </span>
                                </td>
                                <td colspan="2" class="bold-letter">First name: 
                                    <span class="value">
                                        <?php echo $row['first_name'] ?>
                                    </span>
                                </td>
                                <td colspan="1" class="bold-letter">Middle name: 
                                    <span class="value">
                                        <?php echo $row['middle_name'] ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="1" class="bold-letter">Date of Birth: 
                                    <span class="value">
                                        <?php echo $row['date_of_birth'] ?>
                                    </span>
                                </td>
                                <td colspan="1" class="bold-letter">Gender: 
                                    <span class="value">
                                        <?php if ($row['gender'] === 'Male'): ?>
                                            <span>Male</span>
                                        <?php else: ?>
                                            <span>Female</span>
                                        <?php endif; ?>
                                    </span>
                                </td>
                            </tr>
                        </table>
                        <table class="table">
                            <tr>
                                <th colspan="5" class="row-divide"></th>
                            </tr>
                            <tr>
                                <td colspan="2">Subject:
                                    <?php echo $table1_subject ?>
                                </td>
                                <td colspan="1">Final Remark:
                                    <?php echo $table1_final_remark ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="js/clock.js"></script>
<script src="js/script.js"></script>
</html>