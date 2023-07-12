<?php include_once 'header.php'; ?>
<?php include_once 'footer.php';
require '../helpers/init_conn_db.php';?>
<?php
if(isset($_POST['btnFlightEdit']))
{
    $source_date = $_POST['source_date'];
    $source_time = $_POST['source_time'];
    $dest_date = $_POST['dest_date'];
    $dest_time = $_POST['dest_time'];
    $dep_city = $_POST['dep_city'];
    $arr_city = $_POST['arr_city'];
    $Price = $_POST['price'];
    $airline_name = $_POST['airline_name'];
    $dura = $_POST['dura'];

    if($dep_city===$arr_city || $arr_city==='To' || $arr_city==='From') {
    header('Location:flight.php?error=same');
    exit();
    }
    $dest_date_len = strlen($dest_date);
    $dest_time_len = strlen($dest_time);
    $source_date_len = strlen($source_date);
    $source_time_len = strlen($source_time);

    $dest_date_str = '';
    for($i=$dest_date_len-2;$i<$dest_date_len;$i++) {
    $dest_date_str .= $dest_date[$i];
    }
    $source_date_str = '';
    for($i=$source_date_len-2;$i<$source_date_len;$i++) {
    $source_date_str .= $source_date[$i];
    }
    $dest_time_str = '';
    for($i=0;$i<$dest_time_len-3;$i++) {
    $dest_time_str .= $dest_time[$i];
    }
    $source_time_str = '';
    for($i=0;$i<$source_time_len-3;$i++) {
    $source_time_str .= $source_time[$i];
    }
    $dest_date_str = (int)$dest_date_str;
    $source_date_str = (int)$source_date_str;
    $dest_time_str = (int)$dest_time_str;
    $source_time_str = (int)$source_time_str;

    $time_source = $source_time.':00';
    $time_dest = $dest_time.':00';
    $arrival = $dest_date.' '.$time_dest;
    $departure = $source_date.' '.$time_source;

    $dest_mnth = (int)substr($dest_date,5,2);
    $src_mnth = (int)substr($source_date,5,2);
    $flag = false;
    if($dest_mnth > $src_mnth)
    {
        $flag = true;
    }
    else if($dest_mnth == $src_mnth)
    {
        if($dest_date_str > $source_date_str) {
            $flag = true;
        } else if($dest_date_str == $source_date_str) {
            if($dest_time_str > $source_time_str){
            $flag = true;
            }
        }

    }
    $fID=$_POST['flight_id'];
    $sql ="UPDATE flight SET arrivale=?,departure=?,Destination=?,source=?,airline=?,duration=?,Price=? WHERE flight_id=?";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,'ssssssii',$arrival,$departure,$arr_city,$dep_city,$airline_name,$dura,$Price,$fID);            
    mysqli_stmt_execute($stmt);
    exit();
}

if(isset($_POST['del_flight']) and isset($_SESSION['adminId'])) {
  $flight_id = $_POST['flight_id'];
  $sql = 'DELETE FROM Flight WHERE flight_id=?';
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt,$sql)) {
      header('Location: ../index.php?error=sqlerror');
      exit();            
  } else {  
    mysqli_stmt_bind_param($stmt,'i',$flight_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    // header('Location: all_flights.php');
    echo("<script>location.href = 'all_flights.php';</script>");
    exit();
  }
}
?>

<style>
table {
  background-color: white;
}
h1 {
  margin-top: 20px;
  margin-bottom: 20px;
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
    <main>
        <?php if(isset($_SESSION['adminId'])) { ?>
          <div class="container-md mt-2">
            <h1 class="display-4 text-center text-secondary"
              >FLIGHT LIST</h1>
            <table class="table table-sm table-bordered">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Arrival</th>
                  <th scope="col">Departure</th>
                  <th scope="col">Source</th>
                  <th scope="col">Destination</th>
                  <th scope="col">Airline</th>
                  <th scope="col">Seats</th>
                  <th scope="col">Price</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                
                <?php
                $sql = 'SELECT * FROM Flight ORDER BY flight_id DESC';
                $stmt = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt,$sql);                
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                while ($row = mysqli_fetch_assoc($result)) {
                  echo "
                  <tr class='text-center'>                  
                    <td scope='row'>
                      <a href='pass_list.php?flight_id=".$row['flight_id']."'>
                      ".$row['flight_id']." </a> </td>
                    <td>".$row['arrivale']."</td>
                    <td>".$row['departure']."</td>
                    <td>".$row['source']."</td>
                    <td>".$row['Destination']."</td>
                    <td>".$row['airline']."</td>
                    <td>".$row['Seats']."</td>
                    <td>₹ ".$row['Price']."</td>
                    <td><table><tr><td>
                    <form action='edit_flight.php' method='post'>
                      <input name='flight_id' type='hidden' value=".$row['flight_id'].">
                      <button  class='btn' type='submit' name='edit_flight'>
                      <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>
                        <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
                        <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z'/>
                        </svg></button>
                    </form>
                    </td>
                    <td>
                    <form action='all_flights.php' method='post'>
                      <input name='flight_id' type='hidden' value=".$row['flight_id'].">
                      <button  class='btn' type='submit' name='del_flight'>
                      <i class='text-danger fa fa-trash'></i></button>
                    </form>
                    </td></tr></table>
                    </td>                 
                  </tr>
                  ";
                }
                ?>

              </tbody>
            </table>

          </div>
        <?php } ?>

    </main>
	
