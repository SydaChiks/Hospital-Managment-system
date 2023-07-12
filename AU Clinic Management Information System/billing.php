<?php 
require_once "importance.php"; 

if(!User::loggedIn()){
    Config::redir("login.php"); 
}
?>

<html>
<head>
    <title>Add billing - <?php echo CONFIG::SYSTEM_NAME; ?></title>
    <?php require_once "inc/head.inc.php";  ?> 
</head>
<body>
    <?php require_once "inc/header.inc.php"; ?> 
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-2'><?php require_once "inc/sidebar.inc.php"; ?></div> <!-- this should be a sidebar --> 
            <div class='col-md-7'>
                <div class='content-area'> 
                <div class='content-header'>
                    <?php if(isset($_GET['token'])){ echo "Add billing <small>Edit this billing</small>"; } else { ?> Please Enter Payment Details <small>fill in</small> <?php } ?> 
                </div>
                <?php require_once "inc/alerts.inc.php";  ?> 
                <div class='content-body'>
                    <div class='form-holder'>
                        
                        <?php 
                            $description = ""; 
                            $amount= "";
                            $payment = ""; 
                            $date = ""; 
                            $token = "";
                            if(isset($_GET['token'])){
                                $token = $_GET['token'];
                                $description = User::get($token, "description"); 
                                $amount = User::get($token, "amount");
                                $payment = User::get($token, "payment"); 
                                $date = User::get($token, "date(format)"); 
                            }
                            if(isset($_POST['des'])){
                                $description = $_POST['des']; 
                                $amount = $_POST['am']; 
                                $payment = $_POST['payment']; 
                                $date = $_POST['dat']; 
                                if($token == ""){
                                    $description = $_POST['des']; 
                                } else {
                                    $description = "$description"; 
                                }
                                
                                
                                
                            }
                            
                            $form = new Form(3, "post");
                            $form->init(); 
                            $form->textBox("description", "des", "text", "$description", "");
                            $form->textBox("amount", "am", "text", "$amount", "");
                            /*$form->textBox("payment", "pay", "text", "$payment", "");*/
                            $form->textBox("date(format)", "dat","date(format)", "$date", "");
                            if(isset($_GET['token'] )){
                                $form->textBox("description", "", "text", "$description", array("disabled"));
                            } else {
                                $form->select("payment", "payment", "", array("Ecocash", "Medical Aid", "Swipe","Cash(RTGS/USD)"));
                            }
                            if(isset($_GET['token'] )){
                                $form->close("Edit billing"); 
                            } else {
                                $form->close("Add billing"); 
                            }


                            /*Db::formSpecial(
                            array("description", "amount", "payment", "date"),
                            3,
                            array("des", "am", "pay", "dat"), 
                            array("text", "number", "text", "date"),  
                            "", 
                            "",  
                            array("description"), 
                            array("payment"), 
                            array("Ecocash", "Medical Aid", "Swipe","Cash(RTGS/USD)"), 
                            "Add billing") */?> 
                    </div> 
                </div><!-- end of the content area --> 
                </div> 
                
            </div><!-- col-md-7 --> 

            <div class='col-md-3'>
                <img src='images/career1.jpg' class='img-responsive' /> 
            </div> <!-- this should be a sidebar -->
                
        </div> 
    </div> 
</body>
</html>
