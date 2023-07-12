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
<h1 align="center">FEEDBACK</h1>
<div class="feedtable">
    
<table class="table table-sm table-bordered">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Email</th>
                  <th scope="col">Question 1</th>
                  <th scope="col">Question 2</th>
                  <th scope="col">Question 3</th>
                  <th scope="col">Rating</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
<?php
                $sql = 'SELECT * FROM feedback ORDER BY feed_id DESC';
                $stmt = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt,$sql);                
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                while ($row = mysqli_fetch_assoc($result)) {
                  echo "
                  <tr class='text-center'>                  
                    <td scope='row'>
                      <a href='feedback.php?feed_id=".$row['feed_id']."'>
                      ".$row['feed_id']." </a> </td>
                    <td>".$row['email']."</td>
                    <td>".$row['q1']."</td>
                    <td>".$row['q2']."</td>
                    <td>".$row['q3']."</td>
                    <td>".$row['rate']."</td>
                    <td>
                    <form action='adminfeedback.php' method='post'>
                      <input name='feed_id' type='hidden' value=".$row['feed_id'].">
                      <button  class='btn' type='submit' name='feed'>
                      <i class='text-danger fa fa-trash'></i></button>
                    </form>
                    </td>                  
                  </tr>
                  ";
                }
?>
        <?php
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
        ?>
</tbody>
</table>
</div>