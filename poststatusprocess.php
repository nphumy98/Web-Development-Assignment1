<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en" >
<head>
  <title>Post Status</title>
  <link rel="stylesheet" type="text/css" href="style.css" >
</head>
<body>
  <div id="header">
    <h1>Status Posting System</h1>
  </div>
  <?php
          //get config file for database
          require_once('../config-assign1/databaseInfo.inc.php');
          //check status code format
          function check_status_code_format($statusCode)
          {
            //check if it match the pattern
            $pattern= "/^S[0-9][0-9][0-9][0-9]$/";
            if (preg_match($pattern, $statusCode))
            {
              return true;
            }
            else
            {
              echo "<p>$statusCode is invalid. Please enter Status Code with a string start with S uppercase followed by 4 numbers.</p>";
              return false;
            }
          }

          //check status format
          function check_status_format($status)
          {
            //check if it match the pattern
            $status= trim($status, " ");
            //check if statuscode is empty
            if (empty($status))
            {
              echo "<p>Please enter Status field</p>";
              return false;
            }
            $pattern= "/^[A-Za-z0-9,.!? ]+$/";
            if (preg_match($pattern, $status))
            {
              return true;
            }
            else
            {
              echo "<p>$status is invalid. Status can only contain alphanumeric character, spaces, comma, period, exclamation point and question mark</p>";
              return false;
            }
          }
          //check status code is unique
          function is_status_code_unique($statusCode, $sql_tble, $conn)
          {
            $query_check_status_code_unqie = "select * from $sql_tble where status_code = '$statusCode'";
            // executes the query
            $result = mysqli_query($conn, $query_check_status_code_unqie);
            $rowCount= mysqli_num_rows($result);
            //if the status code already in the table
            if ( $rowCount== 0)
            {
                return true;
            }
            else
            {
              echo "<p>$statusCode is invalid. The Status Code already in the table. Please choose another status code</p>";
              return false;
            }
          }

          //to return the string for checkbox Allow Like, Allow Comment and Allow share
          function check_boolean_value($str)
          {
            if ($str!="Yes")
            {
              $str="No";
            }
            return $str;
          }


          //function to check if the table is existed in the database, if not create new table
          function check_table_existed ($conn, $sql_tble)
          {
            //check if the table is exsit
            $query_check_table = "DESCRIBE $sql_tble";
            //if the table not exist
            if(mysqli_query($conn,$query_check_table)==false)
            {
              //create a status post table
              $query_create_table= "CREATE TABLE $sql_tble (
              status_code VARCHAR(6) NOT NULL PRIMARY KEY,
              status VARCHAR(30) NOT NULL,
              share enum('Public','Friends','Only Me'),
              post_date DATE,
              allow_like enum('Yes','No') NOT NULL DEFAULT 'No',
              allow_comment enum('Yes','No') NOT NULL DEFAULT 'No',
              allow_share enum('Yes','No') NOT NULL DEFAULT 'No'
              )";

              //execute the $query
              mysqli_query($conn, $query_create_table);
            }
          }

          //get infor from fields
          $statusCode= $_POST['statusCode'];
          $status= $_POST['status'];
          $share= $_POST['share'];
          $post_date = $_POST['date'];
          $allowLike= check_boolean_value($_POST['allowLike']);
          $allowComment= check_boolean_value($_POST['allowComment']);
          $allowShare= check_boolean_value($_POST['allowShare']);

          // check status code and status format
          $statusCodeFormat=check_status_code_format($statusCode);
          $statusFormat= check_status_format($status);

          if(($statusCodeFormat)&&($statusFormat))
          {
            // connect database
            // mysqli_connect returns false if connection failed, otherwise a connection value
            $conn = @mysqli_connect($sql_host,
              $sql_user,
              $sql_pass,
              $sql_db
            );

            // Checks if connection is successful
            if (!$conn)
            {
              // Displays an error message
              echo "<p>Database connection failure. Try another time</p>";
            }
            else
            {
              //check table existed, if not create new table
              check_table_existed ($conn, $sql_tble);

              //check the status code if it is unique
              //if status code is unique
              $is_status_code_unique=is_status_code_unique($statusCode, $sql_tble, $conn);
              if($is_status_code_unique)
              {
                // Set up the SQL command to add the data into the table
               $query_insert = "insert into $sql_tble"
                       ."(status_code, status, share, post_date, allow_like, allow_comment, allow_share)"
                     . "values"
                       ."('$statusCode','$status','$share', '$post_date','$allowLike','$allowComment','$allowShare')";
               // executes the query
               $result = mysqli_query($conn, $query_insert);
               // checks if the execution was successful
               if(!$result) {
                 //if not then tell user to try another time
                 echo "<p>Due to some reasons, your status has not been added. Try again later!</p>";
               } else {
                 // display an operation successful message
                 echo "<p>Your status with status code: $statusCode has been sucessfully added.</p>";
               } // if successful query operation
              }
              // close the database connection
              mysqli_close($conn);
            }
          }
  ?>
  <!-- link to homepage and poststatusform -->
  <p><a href="poststatusform.php">Add another Status</a></p>;
  <p><a href="index.html">Return to Home Page</a></p>;
</body>
</html>
