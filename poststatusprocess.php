<?php
        //get config file for database
       // require_once('../../config-assign1/databaseInfo.inc.php');
        //check status code format
        function check_status_code_format($statusCode)
        {
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
          $status= trim($status, " ");
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
        function is_status_code_unique($statusCode)
        {

        }

        //check status
        $statusCode= $_POST['statusCode'];
        $status= $_POST['status'];
        $share= $_POST['share'];
        $post_date = $_POST['date'];
        $allowLike= $_POST['allowLike'];
        $allowComment= $_POST['allowComment'];
        $allowShare= $_POST['allowShare'];
        if ($allowLike != "Allow Like")
        {
          $allowLike=0;
        }
        else
        {
          $allowLike=1;
        }

        if ($allowComment != "Allow Comment")
        {
          $allowComment=0;
        }
        else
        {
          $allowComment=1;
        }

        if ($allowShare != "Allow Share")
        {
          $allowShare=0;
        }
        else
        {
          $allowShare=1;
        }

        check_status_code_format($statusCode);
        check_status_format($status);

        $sql_host="cmslamp14.aut.ac.nz";
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
      		// Set up the SQL command to add the data into the table
      		$query = "insert into $sql_tble"
      						."(status_code, status, share, post_date, allow_like, allow_comment, allow_share)"
      					. "values"
      						."('$statusCode','$status','$share', '$post_date',$allowLike,$allowComment,$allowShare)";
        echo $query;
      		// executes the query
      		$result = mysqli_query($conn, $query);
      		// checks if the execution was successful
      		if(!$result) {
      			echo "<p>Something is wrong with ",	$query, "</p>";
      		} else {
      			// display an operation successful message
      			echo "<p>Success add</p>";
      		} // if successful query operation
          //link to homepage and poststatusform
          echo "<p><a href="."poststatusform.php".">Add another Status</a>"."</p>";
          echo "<p><a href="."index.html".">Return to Home Page</a>"."</p>";
      		// close the database connection
      		mysqli_close($conn);



        }
?>
