<?
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

    $connect=mysqli_connect("localhost", "root", "apmsetup", "Task");
  if (mysqli_connect_errno()) {
      die('Connect Error: '.mysqli_connect_error());
  }

  $sql = "select * from student_list where Mail='$mail'";
  $result = mysqli_query($connect,$sql);
  $num_match=mysqli_num_rows($result); //�ѹ� �޾ƿ���

  if(!$num_match) 
  {
    echo("
      <script>
                   window.alert('��ϵ��� ���� ���̵��Դϴ�.')
                  history.go(-1)
                 </script>
    ");
  }
  else
  {
	$tmpPW = mt_rand(1000, 9999);  
	$salt = mt_rand(1000, 9999);  
	$tmphashedPW = Hashed($tmpPW, $salt);

	$sql = "UPDATE student_list SET HashedPW = '$tmphashedPW' where Mail = '$mail'";
    mysqli_query($connect,$sql);
        
    $sql = "UPDATE student_list SET Salt = '$salt' where Mail = '$mail'";
    mysqli_query($connect,$sql);

  mysqli_close($connect);                // DB ���� ����
  echo('New PW is '.$tmpPW);
  }


?>