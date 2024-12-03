<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total</title>
    <link rel="stylesheet" href="style.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap');
</style>
</head>
<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "track";

    global $conn ;
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    ?>
<body> 

        <div id="top_bar">
            <label id="label"></label>
        </div>
        <nav class="active" id="nav">
            <div id='ul'>
                <a <?php if ("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" == "http://localhost/money_track/add_send.php?page=receive") echo 'class="active"'; ?> id="receive" href="http://localhost/money_track/add_send.php?page=receive">Received</a>
                <a id="total" href="http://localhost/money_track/display.php" <?php echo 'class="active"'; ?>>Total</a>
                <a <?php if ("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" == "http://localhost/money_track/add_send.php?page=send") echo 'class="active"'; ?> id="spent" href="http://localhost/money_track/add_send.php?page=send">Spent</a>
            </div>
        </nav>
        <div id="main_body">
            <div id="container">
                <tab_nav>
                <a id="receive_tab" href="http://localhost/money_track/display.php?page=receive">Received</a>
                <a id="total_tab" href="http://localhost/money_track/display.php">Total</a>
                <a id="spent_tab" href="http://localhost/money_track/display.php?page=spent">Spent</a>
                </tab_nav>
                <form action="get">
            <table id="dis_tab">
                <tr>
                    <th>Amount</th>
                    <th>Source</th>
                    <th>Status</th>
                    <th>Reason</th>
                    <th>Date & Time</th>
                    <th></th>
                </tr>
                
                <?php
                if ("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"=="http://localhost/money_track/display.php"){

                    $sql = "SELECT * FROM info";
                    $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    $formattedDate = date("d/m/Y", strtotime($row["date"]));
                    ?>
            
                    <tr>
                        <td><?php echo '₹ ' . $row["amount"]; ?></td>
                        <td><?php echo $row["source"]; ?></td>
                        <td><?php echo $row["status"]; ?></td>  
                        <td><?php echo $row["reason"]; ?></td>
                        <td><?php echo $formattedDate . '<br>' . $row['time']; ?></td>
                        <td><a id="edit_button" href="http://localhost/money_track/update.php?page=send&edi_s_no=<?php echo $row['s_no']?>" name="delete">Edit</a><a id="delete_button" href="http://localhost/money_track/display.php?sp_s_no=<?php echo $row['s_no']?>">Delete</a></td>
                    </tr>
                <?php
            }
            $sum_query="SELECT 
            SUM(CASE WHEN status = 'received' THEN amount ELSE 0 END) - 
            SUM(CASE WHEN status = 'spent' THEN amount ELSE 0 END) AS total_sum
        FROM 
            info;";
            $sum=$conn->query($sum_query);
            $sums=$sum->fetch_assoc();
    ?>
            
            <tr><td class="total_sum">Total :</td><td class="total_sum"><?php echo '₹ ' . $sums['total_sum']; ?></td></tr>
            

            <?php }elseif("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"=="http://localhost/money_track/display.php?page=receive"){
                $sql = "SELECT * FROM info where status='received'";
                $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                $formattedDate = date("d/m/Y", strtotime($row["date"]));
                ?>
        
                <tr>
                    <td><?php echo '₹ ' . $row["amount"]; ?></td>
                    <td><?php echo $row["source"]; ?></td>
                    <td><?php echo $row["status"]; ?></td>
                    <td><?php echo $row["reason"]; ?></td>
                    <td><?php echo $formattedDate . '<br>' . $row['time']; ?></td>
                    <td><a id="edit_button" href="http://localhost/money_track/update.php?page=send&edi_r_no=<?php echo $row['s_no']?>" name="delete">Edit</a><a id="delete_button" href="http://localhost/money_track/display.php?page=receive&sp_r_no=<?php echo $row['s_no']?>">Delete</a></td>
                </tr>
            <?php
        }
        $sum_query="SELECT SUM(amount) as total_sum from info where status='received'";
        $sum=$conn->query($sum_query);
        $sums=$sum->fetch_assoc();
?>
        
        <tr><td class="total_sum">Total :</td><td class="total_sum"><?php echo '₹ ' . $sums['total_sum']; ?></td></tr>
       
            <?php }elseif("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"=="http://localhost/money_track/display.php?page=spent"){
                $sql = "SELECT * FROM info where status='spent'";
                $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                $formattedDate = date("d/m/Y", strtotime($row["date"]));
                ?>
        
                <tr>
                    <td><?php echo '₹ ' . $row["amount"]; ?></td>
                    <td><?php echo $row["source"]; ?></td>
                    <td><?php echo $row["status"]; ?></td>
                    <td><?php echo $row["reason"]; ?></td>
                    <td><?php echo $formattedDate . '<br>' . $row['time']; ?></td>
                    <td><a id="edit_button" href="http://localhost/money_track/update.php?page=send&edi_s_no=<?php echo $row['s_no']?>" name="delete">Edit</a><a id="delete_button" href="http://localhost/money_track/display.php?page=receive&sp_s_no=<?php echo $row['s_no']?>">Delete</a></td>
                </tr>
            <?php
        }
        $sum_query="SELECT SUM(amount) as total_sum from info where status='spent'";
        $sum=$conn->query($sum_query);
        $sums=$sum->fetch_assoc();
?>
        
        <tr><td class="total_sum">Total :</td><td class="total_sum"><?php echo '₹ ' . $sums['total_sum']; ?></td></tr>
        
            <?php }?>
    

        <?php
        if(isset($_GET["sp_s_no"])){
            $s=$_GET["sp_s_no"];
            $del_q="DELETE from info where s_no=$s";
            $conn->query($del_q);

            header("Location: http://localhost/money_track/display.php?page=spent");
        }?>

        <?php
        if(isset($_GET["re_s_no"])){
            $s=$_GET["re_s_no"];
            $del_q="DELETE from info where s_no=$s";
            $conn->query($del_q);

            header("Location: http://localhost/money_track/display.php?page=receive");
        }?>

        <?php
        if(isset($_GET["to_s_no"])){
            $s=$_GET["to_s_no"];
            $del_q="DELETE from info where s_no=$s";
            $conn->query($del_q);

            header("Location: http://localhost/money_track/display.php");
        }?></table>
        </form>
        </div>
    </div>
</body>
</html>