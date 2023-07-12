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
<h1 align="center">Booked Ticket</h1>
<div class="sar">
<form method="post">
    <input type="text" class="dsearch" placeholder="Search Here" name="txtSearch" />
    <input type="submit" name="btnSearch" class="dbutton" value="Search" />
</form>
</div>
<div class="feedtable">
    
<table class="table table-sm table-bordered">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Pasenger Id</th>
                  <th scope="col">Flight Id</th>
                  <th scope="col">User Id</th>
                  <th scope="col">Seat No</th>
                  <th scope="col">Cost</th>
                  <th scope="col">Class</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
            <?php
            if(isset($_POST['btnSearch']) && $_POST['txtSearch']!="")
            {
                $stmt = mysqli_stmt_init($conn);
                $searchData = $_POST['txtSearch'];
                $sql = 'SELECT * FROM ticket WHERE flight_id = ? OR seat_no = ? OR user_id=? ORDER BY ticket_id DESC';
                $stmt = mysqli_stmt_init($conn);
                
                if(!mysqli_stmt_prepare($stmt,$sql))
                {
                    exit();
                }
                mysqli_stmt_bind_param($stmt,'isi',$searchData,$searchData,$searchData);                  
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                while ($row = mysqli_fetch_assoc($result)) {
                  echo "
                  <tr class='text-center'>                  
                    <td scope='row'>
                      <a href='ticket.php?ticket_id=".$row['ticket_id']."'>
                      ".$row['ticket_id']." </a> </td>
                    <td>".$row['passenger_id']."</td>
                    <td>".$row['flight_id']."</td>
                    <td>".$row['user_id']."</td>
                    <td>".$row['seat_no']."</td>
                    <td>".$row['cost']."</td>
                    <td>".$row['class']."</td>
                    <td>
                    <form action='adminticket.php' method='post'>
                      <input name='ticket_id' type='hidden' value=".$row['ticket_id'].">
                      <button  class='btn' type='submit' name='ticket'>
                      <i class='text-danger fa fa-trash'></i></button>
                    </form>
                    </td>                  
                  </tr>
                  ";
                }
            }
            else{
                $sql = 'SELECT * FROM ticket ORDER BY ticket_id DESC';
                $stmt = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt,$sql);                
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                while ($row = mysqli_fetch_assoc($result)) {
                  echo "
                  <tr class='text-center'>                  
                    <td scope='row'>
                      <a href='ticket.php?ticket_id=".$row['ticket_id']."'>
                      ".$row['ticket_id']." </a> </td>
                    <td>".$row['passenger_id']."</td>
                    <td>".$row['flight_id']."</td>
                    <td>".$row['user_id']."</td>
                    <td>".$row['seat_no']."</td>
                    <td>".$row['cost']."</td>
                    <td>".$row['class']."</td>
                    <td>
                    <form action='adminticket.php' method='post'>
                      <input name='ticket_id' type='hidden' value=".$row['ticket_id'].">
                      <button  class='btn' type='submit' name='ticket'>
                      <i class='text-danger fa fa-trash'></i></button>
                    </form>
                    </td>                  
                  </tr>
                  ";
                }
            } 
            ?>
        <?php
        if(isset($_POST['ticket']) and isset($_SESSION['adminId'])) {
        $ticket_id = $_POST['ticket_id'];
        $sql = 'DELETE FROM ticket WHERE ticket_id=?';
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)) {
            header('Location: ../index.php?error=sqlerror');
            exit();            
        } else {  
            mysqli_stmt_bind_param($stmt,'i',$ticket_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            // header('Location: all_flights.php');
            //echo("<script>location.href = 'all_flights.php';</script>");
            exit();
        }
        }
        ?>
</tbody>
</table>
</div>