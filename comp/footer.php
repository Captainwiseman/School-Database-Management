<?php
// Setting the power level according to the role of the user
if (isset($_SESSION['logged'])) {
  echo "<input type='hidden' id='SessionData' data-id= {$_SESSION['logged']['adminid']} data-session= {$_SESSION['logged']['role']}>";
}
?>
<script src="handlers/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<?php
for($i=0;$i<count($this->js);$i++) {
      echo "<script src=\"{$this->js[$i]}\"></script>";
    }
?>
</body>
</html>