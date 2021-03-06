<?php
session_start();
if(!isset($_SESSION['UserName']) && $title != "Login")
{
  $username = "notLoggedIn";  	 
   header( "refresh:0;url=../allusers/login.php" );
}
else
{
  $username = $_SESSION['UserName'];

}
  require_once("../../../backend/dbscripts/dbconnect.php");
  require_once("../../../backend/dbscripts/commonfunctions.php");
  /**
   * 
   * The header page is to provide a place to write the header-bar generation
   * 
   */
  
  $TaskCount = 0;
  $PendingCount = 0;
  $RequestCount = 0;
  $query = "SELECT * FROM users WHERE username='$username'";
    
    if($query = mysqli_query($conn, $query)){
      $user = mysqli_Fetch_assoc($query);
        $userid = $user['id'];
      $userlocation = $user['location'];
    }
  $query = "SELECT * FROM approvers WHERE userid = '$userid'";
  $softwareids = array();
    if($query = mysqli_query($conn, $query)){
      while($approver = mysqli_Fetch_assoc($query))
    {
      // if user has Canada domain, they have approval access over all of canada for that software.
      $userlocation = explode(',',$userlocation);
      foreach($userlocation as $userlocationelement)
      {
      if($approver['location'] == "Canada" || strpos($approver['location'], $userlocationelement) !== False)
      {
        array_push($softwareids, $approver['softwareid']);   
      }
    }
  }
}
  $query = "SELECT COUNT(*) FROM requests WHERE userid = '$userid'";
  
    if($query = mysqli_query($conn, $query)){
      $count = mysqli_Fetch_assoc($query);
        $RequestCount = $count['COUNT(*)'];
    }
   $softwareids = implode(',', $softwareids);
  $query = "SELECT COUNT(*) FROM requests WHERE status='Awaiting Approval' AND softwareid IN ($softwareids)";
  
    if($query = mysqli_query($conn, $query)){
      $count = mysqli_Fetch_assoc($query);
        $PendingCount = $count['COUNT(*)'];
    }
  
  $query = "SELECT COUNT(*) FROM requests WHERE status='Approver Approved'";
  
    if($query = mysqli_query($conn, $query)){
      $count = mysqli_Fetch_assoc($query);
        $TaskCount = $count['COUNT(*)'];
    }
    
  $query = "SELECT * FROM users WHERE id= '$userid'";
  
  if($query = mysqli_query($conn, $query)){
    $user = mysqli_Fetch_assoc($query);
      $access = $user['accessType'];
  }

  if(isset($_POST['requestid']) && $pagetype == "TaskPage")
  {
    $title = "Task " . $_POST['requestid'];
  }

  if(isset($_POST['requestid']) && ($pagetype == "RequestPage") || $pagetype == "Request" )
  {
    $title = "Request " . $_POST['requestid'];
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">    
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>

 <title><?php echo $title;?></title>
</head>
<body>
<ul class="nav nav-pills">
  <li role="presentation"><a href="../softwareuser/form.php">HELL</a></li>
  <?php
  if($access == "user" || $access == "approver" || $access == "analyst" || $access == "approver analyst")
  {
      echo ' <li role="presentation" ';
      if($title == "Request Form"|| $pagetype == "requestform") echo "class='active'";
      echo '><a href="../softwareuser/form.php">Create Request</a></li>';
  } 
  
  if($access == "user" || $access == "approver" || $access == "analyst" || $access == "approver analyst")
  {
      echo '<li role="presentation" ';
      if($pagetype == "myRequests" || $pagetype == "Request") echo "class='active'";
      echo '><a href="../softwareuser/requestlist.php">My Requests ';
      if($RequestCount > 0) echo "<button class='btn btn-xs btn-info'>", $RequestCount, '</button>';
      echo '</a></li>';
  }

  if($access == "analyst" || $access == "approver analyst")
  {
      echo '<li role="presentation" ';
      if($pagetype == "myTasks" ) echo "class='active'";
      echo ' ><a href="../analyst/analysttasklist.php">My Tasks ';
      if($TaskCount > 0) echo "<button class='btn btn-xs btn-info'>", $TaskCount, '</button>';
      echo '</a></li>';
  }

  if($access == "approver" || $access == "approver analyst")
  {
      echo '<li role="presentation"';
      if($pagetype == "pendingapprovals" || $pagetype == "ApprovalPage") echo "class='active'";
      echo ' ><a href="../approver/approvertasklist.php">Pending Approvals ';
      if($PendingCount > 0) echo "<button class='btn btn-xs btn-info'>", $PendingCount, '</button>';
      echo '</a></li>';
  }
?>
  <li role="presentation" class="dropdown dropdown-menu-right pull-right">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="presentation" aria-haspopup="true" aria-expanded="false">
    <?php echo $username?> <span class="caret"></span>
    </a>
    <ul class="dropdown-menu pull-right " role="presentation">
      <li role="presentation" class="dropdown-menu-right">
        <a class="text-center"  href="../allusers/signout.php">sign out</a>
      </li>
    </ul>
  </li> 
</ul>
<div style="padding-left:10%; padding-right:10%; padding-top:2%;">
<?php

?>