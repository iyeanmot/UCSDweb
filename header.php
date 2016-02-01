<?session_start();?>
<?
   if(!$userid)
   {
?> 

<li class="dropdown">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
    Login <b class="caret"></b>
  </a>
  <ul class="dropdown-menu">
    <li>
      <li>
        <a href="./login.html">login</a>
      </li>
      <li>
        <a href="./signUp.html">sign up</a>
      </li>
    </li>
  </ul>
</li>

  
<?
}
else
{
?>                
<li>
  <a> "Hello!  
  <?
    echo($usernick);
  ?>"
  </a>
</li>
<li class="dropdown">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
    Member <b class="caret"></b>
  </a>
  <ul class="dropdown-menu">
    <li>
      <li>
        <a href="#" onclick="window.open('./changePW.html','','width=400,height=200')" title="Change Password">changePW</a>
      </li>
      <li>
        <a href="./logout.php">logout</a>
      </li>
    </li>
  </ul>
</li>
 <?
 }
?>
</div>