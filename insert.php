<meta charset="euc-kr">
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

  $regist_day=date("Y-m-d (H:i)");          // 현재 시간(년-월-일-시-분) 저장
  $ip=$REMOTE_ADDR;                         // 방문자의 IP 주소 저장

  $connect=mysqli_connect("localhost", "root", "apmsetup", "Task");
  if (mysqli_connect_errno()) {
  die('Connect Error: '.mysqli_connect_error());
  }

  $sql="select * from student_list where Mail='$email'";
  $result = mysqli_query($connect,$sql);
  $exist_id=mysqli_num_rows($result); //넘버 받아오기
  
  if($exist_id)
  {
    echo("
    <script>
          window.alert('exist ID.')
          history.go(-1)
        </script>
    ");
    exit;
  }
  else
  {
    if($passwd!=$passwd_confirm)
    {
        echo("
        <script>
          window.alert('Please check re-password.')
          history.go(-1)
        </script>
            ");
        exit;
     }
        else
        {                                    // 레코드 삽입 명령을 $sql에 입력
            $salt = mt_rand(1000, 9999);
            $hashed=Hashed($passwd, $salt);

            $sql="INSERT INTO student_list (Name, Nick, Mail, HashedPW, Salt, loginCount) ";
            $sql.="values('$name', '$nick', '$email', '$hashed', '$salt', 0)";
            mysqli_query($connect,$sql);       // $sql 에 저장된 명령 실행
        }
    }
  mysqli_close($connect);                       // 데이터베이스 연결 끊기
  echo ("
  <script>
    location.href = '../index.html';
  </script>
  ");
  ?>
