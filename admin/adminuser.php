<?php include_once 'header.php'; 
require '../helpers/init_conn_db.php';?>
<style>

.usertable{
    padding:90px;
    width: 100%;
    
}
table {
  background-color: white;
  width: 80%;
}
h1 {
  margin-top: 30px;
  margin-bottom: -50px;
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
<h1 align="center">USER</h1>
<div class="usertable">


<table class="table table-sm table-bordered">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Username</th>
                  <th scope="col">Email</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
<?php
                $sql = 'SELECT * FROM users ORDER BY user_id DESC';
                $stmt = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt,$sql);                
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                while ($row = mysqli_fetch_assoc($result)) {
                  echo "
                  <tr class='text-center'>                  
                    <td scope='row'>
                      <a href='feedback.php?user_id=".$row['user_id']."'>
                      ".$row['user_id']." </a> </td>
                    <td>".$row['username']."</td>
                    <td>".$row['email']."</td>
                    <td>
                    <form action='adminuser.php' method='post'>
                      <input name='user_id' type='hidden' value=".$row['user_id'].">
                      <button  class='btn' type='submit' name='user'>
                      <i class='text-danger fa fa-trash'></i></button>
                    </form>
                    </td>                  
                  </tr>
                  ";
                }
?>
<?php
if(isset($_POST['user']) and isset($_SESSION['adminId'])) {
  $user_id = $_POST['user_id'];
  $sql = 'DELETE FROM users WHERE user_id=?';
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt,$sql)) {
      header('Location: ../index.php?error=sqlerror');
      exit();            
  } else {  
    mysqli_stmt_bind_param($stmt,'i',$user_id);
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