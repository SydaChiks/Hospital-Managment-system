<?php 

class billing{
	public static function add($description, $amount, $payment, $date){
		if($token == ""){
			$token = md5(time().uniqid().unixtojd().$description.$amount.$payment.$date);
			$password = "clinic"; 
			
			Db::insert(
				"users", 
				array("description", "amount", "payment", "date(format)"), 
				array($description, $amount, $payment, $date)
			);
			
			Messages::success("Payment has been successully made!");
		} else {
			self::edit($description, $amount, $payment, $date);
			}
	}
	
	public static function load(){
		$query = Db::fetch("users", "", "status = ? ", "2", "id DESC", "", "");
		if(Db::count($query)){
			echo"<div class='form-holder'>
					<table class='table table-bordered table-stripped'> 
					<tr>
						<td><strong>description</strong></td> 
						<td><strong>amount</strong></td> 
						<td><strong>payment</strong></td> 
						<td><strong>date(format)</strong></td> 
					</tr>
			"; 
			
			while($data = Db::assoc($query)){
				$description = $data['description']; 
				$amount = $data['amount']; 
				$payment= $data['payment']; 
				$date = $data['date(format)']; 
				
				echo "<tr>
						<td>$description</td> 
						<td>$amount</td> 
						<td>$payment</td> 
						<td>$date</td> 
						<td><center><a href='actions.php?action=remove-doc&token=$token'>Delete</a> | <a href='billing.php?token=$token'>Edit</a></center></td>
					</tr>";
			}
			
			echo "</table></div>";
			return; 
		}
		
		Messages::info("Unable to make payment, Please Try Again");
	}
	
	public static function getArray($name, $labelDistance){
		$nextLabel = 12 - (int) $labelDistance; 
		$query = Db::fetch("users", "", "status = ? ", "2", "id DESC", "", "");
		$array = array(); 
		echo "<div class='form-group'>
				<label class='col-md-".$labelDistance."' >billing</label>
				<div class='col-md-".$nextLabel."'>
				<select name='$name' class='form-control'>
					<option value='' >--Select payment--</option>
				";
				
		while($data = Db::assoc($query)){
			$token = $data['token']; 
			$description = User::get($token,"description"); 
			$amount = User::get($token, "amount"); 
			
			echo "<option value='$token'>$description $amount</option> ";
		}
		echo "</select></div></div> ";
	}
	
	public static function delete($token){
		Db::delete("users", "token = ? ", $token);
	}
	
	public static function edit($token, $description, $amount, $payment, $date){
		Db::update("users",
		array("description", "amount", "payment", "date), 
		array($description, $amount, $payment, $date), 
		"status = ? AND token = ? ", array(2, $token)); 
		
		Messages::success("You have edited this billing payment <strong><a href='billing.php'>View Edits</a></strong> ");
	}
}