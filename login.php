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
  
  // 이전 화면에서 이름이 입력되지 않았으면 "이름을 입력하세요."
  // 메시지 출력
  if(!$mail)
  {
    echo("
      <script>
          window.alert('아이디를 입력하세요.')
                   history.go(-1)
                 </script>
    ");
    exit;
  }

  if(!$pass)
  {
    echo("
      <script>
                   window.alert('비밀번호를 입력하세요.')
                   history.go(-1)
                 </script>
    ");
    exit;
  }
  
  //db 넣기
  
  
  //mysqli
  $connect=mysqli_connect("localhost", "root", "apmsetup", "Task");
  if (mysqli_connect_errno()) {
      die('Connect Error: '.mysqli_connect_error());
  }
  
//mail = id

   
  //i
  $sql = "select * from student_list where Mail='$mail'";
  $result = mysqli_query($connect,$sql);
  $num_match=mysqli_num_rows($result); //넘버 받아오기
  
 

  if(!$num_match) 
  {
    echo("
      <script>
                   window.alert('등록되지 않은 아이디입니다.')
                  history.go(-1)
                 </script>
    ");
  }
  else
  {
    $row=mysqli_fetch_array($result);
    
    $isLockemail = $row[isLock];
    
     if($isLockemail)
  {
      echo("
      <script>
                   window.alert('Your e-mail is Locked.')
                   history.go(-1)
                 </script>
    ");
    exit;
  }

    
    //해쉬된 패스워드 생성
    $hashedPass=Hashed($pass, $row[Salt]);
    $db_pass=$row[HashedPW];
    if($hashedPass!=$db_pass)
    {
      $tryLogin = $row[tryTologin]+1;
      $sql = "UPDATE student_list SET tryTologin = '$tryLogin' where Mail = '$mail'";
      mysqli_query($connect,$sql);
      
      //tryLogin>3인지 체크 $row[isLock] = 1;
      if($tryLogin>=3)
      {
        $isLock = 1;
        $sql = "UPDATE student_list SET isLock = '$isLock' where Mail = '$mail'";
        mysqli_query($connect,$sql);
            echo("
        <script>
                       window.alert('Wrong Password 3 Time. Your e-mail is Locked')
                       history.go(-1)
                     </script>
      ");
      exit;
      }
      else{
            echo("
        <script>
                       window.alert('Wrong Password.')
                       history.go(-1)
                     </script>
      ");
      exit;
      }

    }
    else
    {
      $userid=$row[Mail];
      $username=$row[Name];
      $usernick=$row[Nick];
      
      //로그인 횟수 증가
      $loginCnt = $row[loginCount] + 1;
      $sql = "UPDATE student_list SET loginCount = '$loginCnt' where Mail = '$userid'";
      mysqli_query($connect,$sql);
      
      //로그인 시도 횟수 초기화
      $tryLogin = 0;
      $sql = "UPDATE student_list SET tryTologin = '$tryLogin' where Mail = '$userid'";
      mysqli_query($connect,$sql);
      
      
      echo("It's your ".$loginCnt."th login");
      //echo($hashedPass);

      $_SESSION['userid']=$userid;
      $_SESSION['username']=$username;
      $_SESSION['usernick']=$usernick;

      //로그인 열번째일때 salt 및 hashedPW 변경
      if($loginCnt%10==0)
      {
        $salt = mt_rand(1000, 9999);  
        
        //$arr = array();
        //$arr[0] = $pass;
        //$arr[1] = $salt;    
        //$NEWhashedPW = implode($arr);
        //$NEWhashedPW = md5($NEWhashedPW);
        
        $NEWhashedPW = Hashed($pass, $salt);
        
        echo($salt);
        
        $sql = "UPDATE student_list SET HashedPW = '$NEWhashedPW' where Mail = '$userid'";
        mysqli_query($connect,$sql);
        
        $sql = "UPDATE student_list SET Salt = '$salt' where Mail = '$userid'";
        mysqli_query($connect,$sql);
      }

      mysqli_close($connect);                // DB 연결 끊기
      echo("
        <script>
                       location.href='./index.html';
					   window.alert('로그인 성공.')
                     </script>
      ");
    }
  } 
  

?>