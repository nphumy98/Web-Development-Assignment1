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
    //function to check if input is empty
    function check_input_empty()
    {
      $status= $_GET['status'];
      if(!isset($status) || trim($status) == '')
      {
         echo "<p>You did not fill out the status field.</p>";
         return false;
      }
      return true;
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
    //connect to database
  	$conn = @mysqli_connect($sql_host,
  		$sql_user,
  		$sql_pass,
  		$sql_db
  	);

  	// Checks if connection is successful
  	if (!$conn) {
  		// Displays an error message
  		echo "<p>Database connection failure</p>";
  	}
    else
    {
  		// Upon successful connection
      //check table existed, if not create new table
       check_table_existed ($conn, $sql_tble);
      //check if the status string is null or empty
      if(check_input_empty())
      {
        // Get data from the form
        $status= $_GET['status'];

        // Set up the SQL command to retrieve the data from the table
        $query = "select * from $sql_tble where status like '%$status%'";

        // executes the query and store result into the result pointer
        $result = mysqli_query($conn, $query);
        // checks if the execuion was successful
        if(!$result)
        {
          //if excute query not sucess. tell user try another time later
          echo "<p>Due to some reasons, your status has not been added. Try again later!</p>";;
        }
        else
        {
          // Display the retrieved records
          echo "<table border=\"1\">";
          echo "<tr>\n"
             ."<th scope=\"col\">Status Code</th>\n"
             ."<th scope=\"col\">Status</th>\n"
             ."<th scope=\"col\">Share</th>\n"
             ."<th scope=\"col\">Post Date</th>\n"
             ."<th scope=\"col\">Allow Like</th>\n"
             ."<th scope=\"col\">Allow Comment</th>\n"
             ."<th scope=\"col\">Allow Share</th>\n"
             ."</tr>\n";
          //loop through database
          while ($row = mysqli_fetch_assoc($result))
          {
            //fix format for post date
            $post_date= $row["post_date"];
            $date = str_replace('-', '/', $post_date);
            $date= date('d/m/Y', strtotime($date));
            //check if share is allowed

            // if share is allowed mean not null
            $share=$row["share"];
            if ($share=="")
            {
              $share='No';
            }

            //print table row
            echo "<tr>";
            echo "<td>",$row["status_code"],"</td>";
            echo "<td>",$row["status"],"</td>";
            echo "<td>",$share,"</td>";
            echo "<td>",$date,"</td>";
            echo "<td>",$row["allow_like"],"</td>";
            echo "<td>",$row["allow_comment"],"</td>";
            echo "<td>",$row["allow_share"],"</td>";
            echo "</tr>";
          }
          echo "</table>";
          // Frees up the memory, after using the result pointer
          mysqli_free_result($result);
        }
       }
      // close the database connection
  		mysqli_close($conn);
  	}
    //link to homepage and poststatusform
    echo "<p><a href="."searchstatusform.html".">Search another Status</a>"."</p>";
    echo "<p><a href="."index.html".">Return to Home Page</a>"."</p>";
  ?>
</body>
</html>
