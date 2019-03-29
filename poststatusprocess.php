<?php
        //check status code format
        function check_status_code_format($str)
        {
          $pattern= "/^S[0-9][0-9][0-9][0-9]$/";
          if (preg_match($pattern, $str))
          {
            echo "<p>the status code is ", $str, ".</p>";
            return true;
          }
          else
          {
            echo "<p>Please enter a string start with S uppercase followed by 4 numbers.</p>";
            return false;
          }
        }

        //check status format
        function check_status_format($str)
        {
          $str= trim($str, " ");
          $pattern= "/^[A-Za-z0-9,.!? ]+$/";
          if (preg_match($pattern, $str))
          {
            echo "<p>the status is ", $str, ".</p>";
            return true;
          }
          else
          {
            echo "<p>Status can only contain alphanumeric character, spaces, comma, period, exclamation point and question mark</p>";
            return false;
          }
        }



        //check status
        $statusCode= $_POST['statusCode'];
        $status= $_POST['status'];
        $checkStatusCodeFormat=check_status_code_format($statusCode);
        $checkStatusFormat=check_status_format($status);
?>
