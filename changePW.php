<?session_start();
  function Hashed($ip_pass, $salt)
  {
        $arr = array();
        $arr[0] = $ip_pass;
        $arr[1] = $salt;
        
        $hashedPW = implode($arr);
        $hashedPW = md5($hashedPW);
        //echo($hashedPW);
        
        return $hashedPW;
  }
  if($newPW != $RenewPW)
  {
      echo("
      <script>
                   window.alert('Please check PW check')
                  history.go(-1)
                 </script>
    ");
  }
  else
  {
		$connect=mysqli_connect("localhost", "root", "apmsetup", "Task");
	  if (mysqli_connect_errno()) {
		  die('Connect Error: '.mysqli_connect_error());
	  }

	  $mail = $_SESSION['userid'];
	  $sql = "select * from student_list where Mail='$mail'";
	  $result = mysqli_query($connect,$sql);
	  $row=mysqli_fetch_array($result); //넘버 받아오기

	  echo($_SESSION['userid']);

	  //newPW로 비번 변경
		$salt = mt_rand(1000, 9999);  
		$hashedPW = Hashed($newPW, $salt);

		$sql = "UPDATE student_list SET HashedPW = '$hashedPW' where Mail = '$mail'";
		mysqli_query($connect,$sql);
        
		$sql = "UPDATE student_list SET Salt = '$salt' where Mail = '$mail'";
		mysqli_query($connect,$sql);

	  mysqli_close($connect);                // DB 연결 끊기
	  echo('Your PW is changed.');
  }


?>