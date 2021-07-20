<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {
  box-sizing: border-box;
}

input[type=text],input[type=password], select, textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  resize: vertical;
}

label {
  padding: 12px 12px 12px 0;
  display: inline-block;
}

input[type=submit] {
  background-color: #04AA6D;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  float: right;
}

input[type=submit]:hover {
  background-color: #45a049;
}

.container {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}

.col-25 {
  float: left;
  width: 25%;
  margin-top: 6px;
}

.col-75 {
  float: left;
  width: 75%;
  margin-top: 6px;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 600px) {
  .col-25, .col-75, input[type=submit] {
    width: 100%;
    margin-top: 0;
  }
}
</style>
</head>
<body>
<h1>Change Password</h1>
<div><?php echo validation_errors() ?>
<?php if(isset($message)){
	echo $message;
}

?>
</div>
<div class="container">
  <form method="post" action="<?=base_url('user/update_password')?>">
  	<div class="row">
      <div class="col-25">
        <label for="old_password">Old Password</label>
      </div>
      <div class="col-75">
        <input type="password" id="old_password" name="old_password" placeholder="Old Password">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="new_password">Password</label>
      </div>
      <div class="col-75">
        <input type="password" id="new_password" name="new_password" placeholder="New Password">
      </div>
    </div>
		<div class="row">
      <div class="col-25">
        <label for="confirm_password">Confirm Password</label>
      </div>
      <div class="col-75">
        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
      </div>
    </div>


    <div class="row">
      <input type="submit" value="Submit">
    </div>
  </form>
</div>


</body>
</html>
