<?php include_once 'header.php'; 
require '../helpers/init_conn_db.php';?>
<style>

.feedtable{
    padding:60px;
    width:1000px;
    margin-left:260px;
}
table {
  background-color: white;
  width: 80%;
  align:center;

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
<h1 align="center">AIRPORTS</h1>
<div class="feedtable" align="center"> 
<table  class="table table-sm table-bordered" align="center">
              <thead class="thead-dark" align="center">
                <tr>
                  <th scope="col">City</th>
                  <th scope="col">Airport</th>
                  <th scope="col">Action</th>
              </thead>
              <tbody>
<?php
                $sql = 'SELECT * FROM cities ORDER BY id DESC';
                $stmt = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt,$sql);                
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                while ($row = mysqli_fetch_assoc($result)) {
                  echo "
                  <tr class='text-center'>                  
                    <td>".$row['city']."</td>
                    <td>".$row['airport']."</td>
                    <td>
                    <form action='all_airport.php' method='post'>
                      <input name='id' type='hidden' value=".$row['id'].">
                      <button  class='btn' type='submit' name='airport'>
                      <i class='text-danger fa fa-trash'></i></button>
                    </form>
                    </td>                  
                  </tr>
                  ";
                }
?>
        <?php
        if(isset($_POST['airport']) and isset($_SESSION['adminId'])) {
        $feed_id = $_POST['id'];
        $sql = 'DELETE FROM cities WHERE id=?';
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