<?php ob_start(); 
include_once 'header.php'; ?>
<?php include_once 'footer.php'; ?>
<?php require '../helpers/init_conn_db.php'; ?>

<link rel="stylesheet" href="../assets/css/flight_form.css">
<link rel="stylesheet" href="../assets/css/form.css">

<?php if(isset($_SESSION['adminId'])) { ?>

<style>
  input {
    border :0px !important;
    border-bottom: 2px solid #5c5c5c !important;
    /* color :cornflowerblue !important; */
    border-radius: 0px !important;
    font-weight: bold !important;
    background-color: whitesmoke !important;    
  }
  *:focus {
    outline: none !important;
  }
  label {
    /* color : #79BAEC !important; */
    color: #5c5c5c !important;
    font-size: 19px;
  }
  h5.form-name {
    /* color: cornflowerblue; */
    /* font-family: 'Courier New', Courier, monospace; */
    font-weight: 50;
    margin-bottom: 0px !important;
    margin-top: 10px;
  }
  h1 {
    font-size: 45px !important;
    font-family: 'product sans';  
    margin-bottom: 20px;  
  }
  body {
    /* padding-top: 20px; */
    /* background-image: url('../assets/images/bg5.jpg'); */
    background-color: #efefef;
    /* background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: 100% 100%;     */
  }
  div.form-out {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);  
    background-color: whitesmoke !important;
    padding: 40px;
    margin-top: 30px;
  }
  select.airline {
    float: right;
    font-weight: bold !important;
    /* color :cornflowerblue !important; */
  }
  @media screen and (max-width: 900px){
    body {
      background-color: lightblue;
      background-image: none;
    }
    div.form-out {
    padding: 20px;
    background-color: none !important;
    margin-top: 20px;
  }    
}  
</style>
<main>
<div class="container mt-0">
  <div class="row">
<?php
    
    $arrivale=null;
    $departure=null;
    $Destination=null;
    $source=null;
    $airline=null;
    $duration=null;
    $Price=null;
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
        header('Location:flight.php?error=same');ob_end_flush();
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
        header("Location:all_flights.php");
        ob_end_flush();
        exit();
    }
    if(isset($_POST['edit_flight']))
    {
        $fID = $_POST['flight_id'];
        $stmt = mysqli_stmt_init($conn);
        $sql_fetch = 'SELECT * FROM flight WHERE flight_id  = ?';
        $stmt = mysqli_stmt_init($conn);
        
        if(!mysqli_stmt_prepare($stmt,$sql_fetch))
        {
            exit();
        }
        mysqli_stmt_bind_param($stmt,'i',$fID);                  
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($result)) {
            $arrivale = $row['arrivale'];
            $departure = $row['departure'];
            $Destination = $row['Destination'];
            $source = $row['source'];
            $airline = $row['airline'];
            $duration = $row['duration'];
            $Price = $row['Price'];
        }
    }
    ?>
      <div class="bg-light form-out col-md-12">
      <h1 class="text-secondary text-center">ADD FLIGHT DETAILS</h1>

      <form method="POST" class=" text-center">
        <input type="hidden" name="flight_id" value="<?php echo $fID;?>"/>
        <div class="form-row mb-4">
          <div class="col-md-3 p-0">
            <h5 class="mb-0 form-name">DEPARTURE</h5>
          </div>
          <div class="col">           
            <input type="date" name = "source_date" class="form-control" >
          </div>
          <div class="col">         
            <input type="time" name = "source_time" class="form-control" >
          </div>
        </div>


        <div class="form-row mb-4">
        <div class="col-md-3 ">
            <h5 class="form-name mb-0">ARRIVAL</h5>
          </div>          
          <div class="col">
            <input type="date" name = "dest_date" class="form-control"
             >
          </div>
          <div class="col">
            <input type="time" name = "dest_time" class="form-control"
             >
          </div>
        </div>

        <div class="form-row mb-4">
          <div class="col">                
            <?php
            $sql = 'SELECT * FROM Cities ';
            $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt,$sql);         
            mysqli_stmt_execute($stmt);          
            $result = mysqli_stmt_get_result($stmt);    
            echo '<select class="mt-4" name="dep_city" style="border: 0px; border-bottom: 
              2px solid #5c5c5c; background-color: whitesmoke !important;
              font-weight: bold !important;
              width:80%">
              <option>From</option>';
            while ($row = mysqli_fetch_assoc($result)) {
                if($source==$row['city'])
                {
                    echo "<option value='{$row['city']}' selected>{$row['city']}</option>";
                }
                else{
                    echo "<option value='{$row['city']}'>{$row['city']}</option>";
                }
								
            }
            ?>
            </select>             
          </div>
          <div class="col">
              <?php
              $sql = 'SELECT * FROM Cities ';
              $stmt = mysqli_stmt_init($conn);
              mysqli_stmt_prepare($stmt,$sql);         
              mysqli_stmt_execute($stmt);          
              $result = mysqli_stmt_get_result($stmt);    
              echo '<select class="mt-4" name="arr_city" style="border: 0px; border-bottom: 
                2px solid #5c5c5c; background-color: whitesmoke !important;
                font-weight: bold !important;
                width:80%">
                <option>To</option>';
              while ($row = mysqli_fetch_assoc($result)) {
                if($Destination==$row['city'])
                {
                    echo "<option value='{$row['city']}' selected>{$row['city']}</option>";
                }
                else{
                    echo "<option value='{$row['city']}'>{$row['city']}</option>";
                }
              }
              ?>
              </select>                
          </div>
        </div>

        <div class="form-row">
          <div class="col">
            <div class="input-group">
                <label for="dura">Duration</label>
                <input type="text" name="dura" id="dura"  value ="<?php echo $duration; ?>"required />
              </div>              
            </div>            
          <div class="col">
            <div class="input-group">
                <label for="price">Price</label>
                <input type="number" style="border: 0px; border-bottom: 2px solid #5c5c5c;" 
                  name="price" id="price" value="<?php echo $Price; ?>"required />
              </div>            
          </div>
          <?php
          $sql = 'SELECT * FROM Airline ';
          $stmt = mysqli_stmt_init($conn);
          mysqli_stmt_prepare($stmt,$sql);         
          mysqli_stmt_execute($stmt);          
          $result = mysqli_stmt_get_result($stmt);    
          echo '<select class="airline col-md-3 mt-4" name="airline_name" style="border: 0px; border-bottom: 
            2px solid #5c5c5c; background-color: whitesmoke !important;">
            <option selected>Select Airline</option>';
          while ($row = mysqli_fetch_assoc($result)) {
            if($airline==$row['name'])
            {
                echo '<option value='. $row['name']  .' selected>'.$row['name'] .'</option>';
            }
            else{
                echo '<option value='. $row['name']  .'>'.$row['name'] .'</option>';
            }
          }
        ?>
        </select>            
        </div>              

        <button name="btnFlightEdit" type="submit" 
          class="btn btn-success mt-5">
          <div style="font-size: 1.5rem;">
          <i class="fa fa-lg fa-arrow-right"></i> Edit
          </div>
        </button>
      </form>
    </div>
    </div>
</div>
</main>
<script>
$(document).ready(function(){
  $('.input-group input').focus(function(){
    me = $(this) ;
    $("label[for='"+me.attr('id')+"']").addClass("animate-label");
  }) ;
  $('.input-group input').blur(function(){
    me = $(this) ;
    if ( me.val() == ""){
      $("label[for='"+me.attr('id')+"']").removeClass("animate-label");
    }
  }) ;
});
</script>
<?php } ?>
