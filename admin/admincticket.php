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
</style>
<h1 align="center">Cancel Ticket</h1>
<div class="feedtable">
<table class="table table-sm table-bordered">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">Ticket ID</th>
                  <th scope="col">Pasenger ID</th>
                  <th scope="col">Flight ID</th>
                  <th scope="col">User ID </th>
                  <th scope="col">Seat No</th>
                  <th scope="col">Class</th>
                  <th scope="col">Fullname</th>
                </tr>
              </thead>
              <tbody>
            <?php
                $sql = 'SELECT * FROM cticket ORDER BY ticket_id DESC';
                $stmt = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt,$sql);                
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                while ($row = mysqli_fetch_assoc($result)) {
                  echo "
                  <tr class='text-center'>                  
                    <td scope='row'>".$row['ticket_id']."</td>
                    <td>".$row['passenger_id']."</td>
                    <td>".$row['flight_id']."</td>
                    <td>".$row['user_id']."</td>
                    <td>".$row['seat_no']."</td>
                    <td>".$row['class']."</td>
                    <td>".$row['fullname']."</td>               
                  </tr>
                  ";
                }
            ?>
</tbody>
</table>
</div>