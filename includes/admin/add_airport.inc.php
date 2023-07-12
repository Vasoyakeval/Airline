<?php
if(isset($_POST['btnAddAirport'])) {
    require '../../helpers/init_conn_db.php'; 
    $city = $_POST['city'];
    $airport = $_POST['airport'];
    $sql = 'INSERT INTO cities (city,airport) VALUES (?,?)';
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)) {
        header('Location: ../feedback.php?error=sqlerror');
        exit();            
    } else {
        mysqli_stmt_bind_param($stmt,'ss',$city,$airport);            
        mysqli_stmt_execute($stmt); 
        header('Location: ../../admin/index.php');
        exit();       
        mysqli_stmt_close($stmt);
        mysqli_close($conn);          
    }

} else {
    header('Location: ../../admin/index.php');
    exit();  
}
