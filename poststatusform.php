<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en" >
<head>
  <title>Post Status</title>
</head>

<body>
  <h1>Status Posting System</h1>
  <?php
    date_default_timezone_set('NZ');
    $today = date('Y-m-d');
  ?>
  <form method="post" action="poststatusprocess.php">
    <p>Status Code (required) :<input type="text" name="statusCode" maxlength="5"></p>
    <p>Status (required)      :<input type="text" name="status"></p>

      <input type="radio" name="share" value="Public" checked> Public
      <input type="radio" name="share" value="Friends"> Friends
      <input type="radio" name="share" value="Only Me"> Only Me

    <p>Date :  <input type="date" value="<?php echo $today;?>"></p>

      <input type="checkbox" name="allowLike" value="Allow Like">Allow Like
      <input type="checkbox" name="allowComment" value="Allow Comment">Allow Comment
      <input type="checkbox" name="allowShare" value="Allow Share">Allow Share

    <input type="submit" value="Post"/>
    <input type="reset" value="Reset"/>
  </form>
  <p><a href="index.html">Return to Home Page</a></p>
</body>
</html>
