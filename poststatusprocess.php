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
         // require_once('../../config-assign1/databaseInfo.inc.php');
          //check status code format
          function check_status_code_format($statusCode)
          {
            //check if statuscode is null
            // if (isset($statusCode))
            // {
            //   echo "<p>Please enter Status Code field</p>";
            //   return false;
            // }
            //check if it match the pattern
            $pattern= "/^S[0-9][0-9][0-9][0-9]$/";
            if (preg_match($pattern, $statusCode))
            {
              echo "<p>the status code is ", $statusCode, ".</p>";
              return true;
            }
            else
            {
              echo "<p>Please enter a string start with S uppercase followed by 4 numbers.</p>";
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
              echo "<p>the status is ", $status, ".</p>";
              return true;
            }
            else
            {
              echo "<p>Status can only contain alphanumeric character, spaces, comma, period, exclamation point and question mark</p>";
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
              echo "<p>The Status Code already in the table. Please choose another status code</p>";
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

          //check status
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
            //database infor
            $sql_host="localhost";
            $sql_user="wrk2544";
            $sql_pass="6889hong";
            $sql_db="wrk2544";
            $sql_tble="status_post";
            // connect database
            // The @ operator suppresses the display of any error messages
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
              echo "<p>Database connection failure</p>";
            }
            else
            {
              echo "<p>Database connection sucess</p>";
              //check if the table is exsit
              $query_check_table = "DESCRIBE $sql_tble";
              //if the table exist
              if(mysqli_query($conn,$query_check_table)!=false)
              {
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
                   echo "<p>Something is wrong with ",	$query_insert, "</p>";
                 } else {
                   // display an operation successful message
                   echo "<p>Success add</p>";
                 } // if successful query operation
                }
              }
              else
              {
                echo "<p>The table: ",	$sql_tble, " is not existed</p>";
              }
              // close the database connection
              mysqli_close($conn);
            }
            //link to homepage and poststatusform
            echo "<p><a href="."poststatusform.php".">Add another Status</a>"."</p>";
            echo "<p><a href="."index.html".">Return to Home Page</a>"."</p>";
          }
  ?>
</body>
</html>
