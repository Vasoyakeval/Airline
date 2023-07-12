<?php include_once 'header.php'; 
require '../helpers/init_conn_db.php';?>
<style>

.feedtable{
    padding:60px;
}
table {
  background-color: white;
  width: 80%;
}
h1 {
  margin-top: 30px;
  margin-bottom: -30px;
  font-family: 'product sans';  
  font-size: 45px !important; 
  font-weight: lighter;
}
a:hover {
  text-decoration: none;
}
body {
  /* background-color: #B0E2FF; */
  background-color: #efefef;
}
th {
  font-size: 22px;
  /* font-weight: lighter; */
  /* font-family: 'Courier New', Courier, monospace; */
}
td {
  margin-top: 10px !important;
  font-size: 16px;
  font-weight: bold;
  font-family: 'Assistant', sans-serif !important;
}
.sar{
    float:right;
    margin-right:60px;
    margin-top:20px;
}
.dsearch{
border-radius:25px;

}
.dbutton{
    border-radius:20px;
    width:100px;
}
</style>
<h1 align="center">PASSENGERS</h1>
<div class="sar">
<form method="post">
    <input type="text" class="dsearch" placeholder="Search Here" name="txtSearch" />
    <input type="submit" class="dbutton" name="btnSearch" value="Search" />
</form>
</div>
<div class="feedtable">
<table class="table table-sm table-bordered">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">Passenger_ID</th>
                  <th scope="col">User_ID</th>
                  <th scope="col">Flight_ID</th>
                  <th scope="col">Mobile Number</th>
                  <th scope="col">Birth Date</th>
                  <th scope="col">Name</th>
                  <!-- <th scope="col"></th>
                  <th scope="col">Action</th> -->
                </tr>
              </thead>
              <tbody>
                <?php
                if(isset($_POST['btnSearch']) && $_POST['txtSearch']!="")
                {
                    $stmt = mysqli_stmt_init($conn);
                    $searchData = $_POST['txtSearch'];
                    $sql = 'SELECT * FROM passenger_profile WHERE passenger_id = ?';
                    $stmt = mysqli_stmt_init($conn);
                    
                    if(!mysqli_stmt_prepare($stmt,$sql))
                    {
                        exit();
                    }
                    mysqli_stmt_bind_param($stmt,'i',$searchData);                  
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "
                        <tr class='text-center'>                  
                            <td scope='row'>
                            <a href='pass_detail.php?passenger_id=".$row['passenger_id']."'>
                            ".$row['passenger_id']." </a> </td>
                            <td>".$row['user_id']."</td>
                            <td>".$row['flight_id']."</td>
                            <td>".$row['mobile']."</td>
                            <td>".$row['dob']."</td>
                            <td>".$row['f_name']."  ".$row['m_name']."  ".$row['l_name']."</td>
                        
                        </tr>
                        ";
                    }
                }
                else{
                    $sql = 'SELECT * FROM passenger_profile ORDER BY passenger_id DESC';
                    $stmt = mysqli_stmt_init($conn);
                    mysqli_stmt_prepare($stmt,$sql);                
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    while ($row = mysqli_fetch_assoc($result)) {
                    echo "
                    <tr class='text-center'>                  
                        <td scope='row'>
                        <a href='pass_detail.php?passenger_id=".$row['passenger_id']."'>
                        ".$row['passenger_id']." </a> </td>
                        <td>".$row['user_id']."</td>
                        <td>".$row['flight_id']."</td>
                        <td>".$row['mobile']."</td>
                        <td>".$row['dob']."</td>
                        <td>".$row['f_name']."  ".$row['m_name']."  ".$row['l_name']."</td>
                    
                    </tr>
                    ";
                    }
                }
                
                ?>
        <!-- 
        if(isset($_POST['feed']) and isset($_SESSION['adminId'])) {
        $feed_id = $_POST['feed_id'];
        $sql = 'DELETE FROM feedback WHERE feed_id=?';
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)) {
            header('Location: ../index.php?error=sqlerror');
            exit();            
        } else {  
            mysqli_stmt_bind_param($stmt,'i',$feed_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            // header('Location: all_flights.php');
            //echo("<script>location.href = 'all_flights.php';</script>");
            exit();
        }
        }
        -->
</tbody>
</table>
</div>