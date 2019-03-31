<?php
  function check_input_empty()
  {
    $status= $_GET['status'];
    if(!isset($status) || trim($status) == '')
    {
       echo "You did not fill out the status field.";
    }
  }


  $sql_host="cmslamp14.aut.ac.nz";
  $sql_user="wrk2544";
  $sql_pass="6889hong";
  $sql_db="wrk2544";
  $sql_tble="status_post";
  // The @ operator suppresses the display of any error messages
	// mysqli_connect returns false if connection failed, otherwise a connection value
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
    //check if table exist
    $query_check_table = "DESCRIBE $sql_tble";
    //if the table exist
    if(mysqli_query($conn,$query_check_table)!=false)
    {
      //check if the status string is null or empty
      check_input_empty();
      // Get data from the form
      $status= $_GET['status'];

      // Set up the SQL command to retrieve the data from the table
      // % symbol represent a wildcard to match any characters
      // like is a compairson operator
      $query = "select * from $sql_tble where status like '%$status%'";

      // executes the query and store result into the result pointer
      $result = mysqli_query($conn, $query);
      // checks if the execuion was successful
      if(!$result) {
        echo "<p>Something is wrong with ",	$query, "</p>";
      } else {
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
        // retrieve current record pointed by the result pointer
        // Note the = is used to assign the record value to variable $row, this is not an error
        // the ($row = mysqli_fetch_assoc($result)) operation results to false if no record was retrieved
        // _assoc is used instead of _row, so field name can be used
        while ($row = mysqli_fetch_assoc($result)){
          //fix format for post date
          $post_date= $row["post_date"];
          $date = str_replace('-', '/', $post_date);
          $date= date('d/m/Y', strtotime($date));
          //print table row
          echo "<tr>";
          echo "<td>",$row["status_code"],"</td>";
          echo "<td>",$row["status"],"</td>";
          echo "<td>",$row["share"],"</td>";
          echo "<td>",$date,"</td>";
          echo "<td>",$row["allow_like"],"</td>";
          echo "<td>",$row["allow_comment"],"</td>";
          echo "<td>",$row["allow_share"],"</td>";
          echo "</tr>";
        }
        echo "</table>";
        // Frees up the memory, after using the result pointer
        mysqli_free_result($result);
      } // if successful query operation
    }
    else
    {
      echo "<p>The table: ",	$sql_tble, " is not existed</p>";
    }
    // close the database connection
		mysqli_close($conn);
	} // if successful database connection
  //link to homepage and poststatusform
  echo "<p><a href="."searchstatusform.html".">Search another Status</a>"."</p>";
  echo "<p><a href="."index.html".">Return to Home Page</a>"."</p>";
?>
