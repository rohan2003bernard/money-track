<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Update</title>
</head>
<body>
    <div id="top_bar">
        <label id="label"></label>
    </div>
    <nav class="active" id="nav">
        <div id='ul'>
            <a <?php if ("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" == "http://localhost/money_track/update.php?page=receive") echo 'class="active"'; ?> id="total" href="http://localhost/money_track/display.php">Total</a>
        </div>
    </nav>

    <div id="main_body">
            <div id="container">
                <form method="post">
                    <label id="amount_label">Amount :</label>
                    <input name="amount" id="amount" type="number" placeholder="Enter amount">

                    <label id="source_label"></label>
                    <input name="source" id="source" type="text" placeholder="Enter Source or Sender">

                    <label id="reason_label">Reason :</label>
                    <textarea name="reason" id="reason" cols="30" rows="5" placeholder="Enter Reason"></textarea>

                    <button  id="update" name="update">Update</button>
                    

                    <div id="message">
            <label id="mes"></label>
            <button id="ok" onclick=hide()>Ok</button>
        </div>

        <div id="dt">
    <input type="number" name="hr" id="hr" min=1 max=12 placeholder="hh"> : <input type="number" name="mm" id="mm" placeholder="mm" min=00 max=59>
    <select name="ap" id="ap">
        <option value="am">AM</option>
        <option value="pm">PM</option>
    </select><br>
    <input type="date" name="date" id="date">
</div>
                </form>
            </div>
            </div>
    </div>
<!------------------------------------------------------------------------------------------------------------------------------------>
    <?php

    $dbHost = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "track";
    $con = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

    if (isset($_GET['edi_s_no'])){
        $s=intval($_GET['edi_s_no']);
        $q="SELECT * FROM info where s_no=$s";
        $details=$con->query($q);
        $d=$details->fetch_assoc();
        $a=$d['amount'];
        $rec=$d['source'];
        $r=$d['reason'];
        $dateTime = new DateTime($d['time']);
        $ap=substr($d['time'],5);
        $hr=substr($d['time'],0,2);
        $mm=substr($d['time'],3,2);
        
        
        $Date=$d['date'];        

        echo"<script>document.getElementById('label').textContent='Edit Spent Money';
        document.getElementById('source_label').textContent='Receiver Name';
        document.getElementById('message').style.visibility='hidden';
        document.getElementById('amount').value=$a;
        document.getElementById('source').value='$rec';
        document.getElementById('reason').textContent='$r';
        document.getElementById('hr').value='$hr';
        document.getElementById('mm').value='$mm';
        document.getElementById('ap').value='$ap';
        document.getElementById('date').value='$Date';
        
        </script>";
    if (isset($_POST['update'])){
        $amount=$_POST['amount'];
        $source=$_POST["source"];
        $reason=$_POST["reason"];
        $date=$_POST["date"];
        $hour=$_POST["hr"];
        $minute=$_POST["mm"];
        $ap=$_POST["ap"];

        $sql="update info set amount=$amount,reason='$reason',source='$source',date='$date',time='$hour:$minute$ap' where s_no=$s";

        $con->query($sql);

        header("Location: http://localhost/money_track/update.php?page=send&edi_s_no=$s");
    
    }
    
}elseif (isset($_GET['edi_r_no'])){
    $s=intval($_GET['edi_r_no']);
        $q="SELECT * FROM info where s_no=$s";
        $details=$con->query($q);
        $d=$details->fetch_assoc();
        $a=$d['amount'];
        $rec=$d['source'];
        $r=$d['reason'];
        $dateTime = new DateTime($d['time']);
        $ap=substr($d['time'],5);
        $hr=substr($d['time'],0,2);
        $mm=substr($d['time'],3,2);
        
        
        $Date=$d['date'];        

        echo"<script>document.getElementById('label').textContent='Edit Received Money';
        document.getElementById('source_label').textContent='Sender Name';
        document.getElementById('message').style.visibility='hidden';
        document.getElementById('amount').value=$a;
        document.getElementById('source').value='$rec';
        document.getElementById('reason').textContent='$r';
        document.getElementById('hr').value='$hr';
        document.getElementById('mm').value='$mm';
        document.getElementById('ap').value='$ap';
        document.getElementById('date').value='$Date';
        
        </script>";
    if (isset($_POST['update'])){
        $amount=$_POST['amount'];
        $source=$_POST["source"];
        $reason=$_POST["reason"];
        $date=$_POST["date"];
        $hour=$_POST["hr"];
        $minute=$_POST["mm"];
        $ap=$_POST["ap"];

        $sql="update info set amount=$amount,reason='$reason',source='$source',date='$date',time='$hour:$minute$ap' where s_no=$s";

        $con->query($sql);

        header("Location: http://localhost/money_track/update.php?edi_r_no=$s");
    
    }
}
?>

<script>
    function clr_fields(){
        document.getElementById("amount").value='';
        document.getElementById("reason").value='';
        document.getElementById("source").value='';
        
    }
    </script>
</body>
</html>