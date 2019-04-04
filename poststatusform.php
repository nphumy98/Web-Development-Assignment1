<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en" >
<head>
  <title>Post Status</title>
  <link rel="stylesheet" type="text/css" href="style.css" >
</head>

<body>
  <div id="container">
    <div id="header">
      <h1>Status Posting System</h1>
    </div>

    <?php
    //set the date default to NZ
      date_default_timezone_set('NZ');
      $today = date('Y-m-d');
    ?>

    <div class="form">
      <form method="post" action="poststatusprocess.php">
        <label for ="status">Status Code</label>
        <input type="text" name="statusCode" maxlength="5" required>

        <label for ="status">Status</label>
        <input type="text" name="status" required>
        <p></p>

          <input type="radio" name="share" value="Public"> Public
          <input type="radio" name="share" value="Friends"> Friends
          <input type="radio" name="share" value="Only Me"> Only Me

        <label for ="status">Date</label>
        <input type="date" name="date" value="<?php echo $today;?>">
        <p></p>
          <input type="checkbox" name="allowLike" value="Yes">Allow Like
          <input type="checkbox" name="allowComment" value="Yes">Allow Comment
          <input type="checkbox" name="allowShare" value="Yes">Allow Share
          <br /><br />
        <input id="submit_button" type="submit" value="Post"/>
        <input id="reset_button" type="reset" value="Reset"/>
        <p><a href="index.html">Return to Home Page</a></p>
      </form>
    </div>
  </div>

</body>
</html>
