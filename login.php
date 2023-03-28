<?php
session_start();

if( isset($_SESSION['user'])!="" ){
   header("Location: index.php");
}
include_once 'connect.php';

if ( isset($_POST['sca']) ) {
    $username = trim($_POST['username']);
    $pass = trim($_POST['pass']);
    $password = hash('sha256', $pass);
    
    $query = "select userid, username, pass from people where username=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username]);
    $count = $stmt->rowCount();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if( $count == 1 && $row['pass']==$password ) {
        $_SESSION['user'] = $row['userid'];
        header("Location: profile.php");
    }
    else {
        $message = "Invalid Login";
    }
    $_SESSION['message'] = $message;
}
?>

<html>
<head><title>Login</title></head>
<body>
<p><h1>
<?php
  if ( isset($message) ) {
    echo $message;
  }
?>
</h1></p>

<form action="login.php" method="post">
Username: <input type="text" name="username" /><br /><br />
Password: <input type="password" name="pass" /><br /><br />
<input type="submit" name="sca" value="Login" /> <br />
</form>
</body>
</html>