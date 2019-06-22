<?php

include("include/dbcon.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>

	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="style/style.css">

	<!-- Fonts -->
	<link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	<title>Welcome to facebook profile data</title>


</head>
<body>

<?php

session_start();

require_once 'Facebook/autoload.php';
$fb = new Facebook\Facebook([
  'app_id' => '{Your app-id}', // Replace {app-id} with your app id
  'app_secret' => '{Your app-secret}',
  'default_graph_version' => 'v3.3',
  ]);

try {
  // Returns a `Facebook\FacebookResponse` object
  $response = $fb->get('/me?fields=id,name,email,gender,link', $_SESSION['fb_access']);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

$user = $response->getGraphUser();
// echo "<pre>";
// print_r($user);
// echo 'Name: ' . $user['name'];

?>

<div class="container">
	<div class="jumbotron">
		<h3 class="text-center">Your facebook Data</h3>
		<table class="table text-center">
  			<thead>
    			<tr>
      				<th scope="col">Id</th>
      				<th scope="col">Name</th>
      				<th scope="col">Email</th>
    			</tr>
  			</thead>
  			<tbody>
    			<tr>
      				<td><?=$user['id']; ?></td>
      				<td><?=$user['name']; ?></td>
      				<td><?=$user['email']; ?></td>
    			</tr>
  			</tbody>
		</table>
		<a href="index.html" class="btn btn-danger rounded-0 shadow-lg float-left">Back to homepage</a>
		<button type="button" class="btn btn-dark float-right rounded-0 shadow-lg" data-toggle="modal" data-target="#insertusermodal">Save Data to Database</button>
	</div>
</div>


<!-- Modal -->
<div class="modal fade text-dark" id="insertusermodal" tabindex="-1" role="dialog"aria-labelledby="insertusermodal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="insertusermodal">Insert User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="profile.php">
                <div class="modal-body">
                
                    <div class="form-group">
                  
                        <div class="form-group">
                            <label class="form-label">Id</label>
                            <input type="text" class="form-control" name="user_id" value="<?=$user['id']; ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="user_name" value="<?=$user['name']; ?>">  
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="user_email" value="<?=$user['email']; ?>"> 
                        </div>
                        
                        <div class="form-group float-right">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    
                            <button type="submit" name="submit" class="btn btn-primary">
                              Save  
                            </button>      
                        </div>              
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php

if(isset($_POST['submit']))
{
	$u_id = $_POST['user_id'];
	$u_name = $_POST['user_name'];
	$u_email = $_POST['user_email'];

	$check = mysqli_query($con, "SELECT * FROM `user_data` WHERE user_email = '$u_email';");

	$run = mysqli_fetch_assoc($check);

	if(mysqli_num_rows($check)>0)
	{
		echo "<script>alert('Data Already exists')</script>";

        echo "<script>window.open('profile.php','_self')</script>";
	}
	else
	{
		$insert_user = "INSERT INTO `user_data`(`user_id`, `user_name`, `user_email`) VALUES ('$u_id','$u_name','$u_email')";

		$run_user = mysqli_query($con, $insert_user);

		echo "<script>alert('Data Save Successfully..!')</script>";

        echo "<script>window.open('index.php','_self')</script>";
	}

}

?>


	<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
