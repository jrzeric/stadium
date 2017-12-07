<?php
session_id("evento");
session_start();
if(isset($_SESSION['evento']))
  session_destroy();

session_id("lista");
session_start();
if(isset($_SESSION['lista']))
  session_destroy();
?>

<form id="toIndex" action="http://localhost/stadium/webapp/" method="post">
  <input type="hidden" name="reset" value="1">
</form>
<script type="text/javascript">
    document.getElementById('toIndex').submit();
</script>
