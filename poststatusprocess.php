<?php
        $validInput= true;
        //check status code
        if (isset($_POST['statusCode']))
        {
          $str= $_POST['statusCode'];
          $pattern= "/^S[0-9][0-9][0-9][0-9]$/";
          if (preg_match($pattern, $str))
          {
            echo "<p>the status code is ", $str, ".</p>";
          }
          else
          {
            echo "<p>Please enter a string start with S uppercase followed by 4 numbers.</p>";
          }
        }
        else
        {
          echo "<p>Please enter string from the input form.</p>";
        }
        //check status
        if (isset($_POST['status']))
        {
          $str= $_POST['status'];
          $str= trim($str, " ");
          $pattern= "/^[A-Za-z0-9,.!? ]+$/";
          if (preg_match($pattern, $str))
          {
            echo "<p>the status is ", $str, ".</p>";
          }
          else
          {
            echo "<p>Status can only contain alphanumeric character, spaces, comma, period, exclamation point and question mark</p>";
          }
        }
        else
        {
          echo "<p>Please enter string from the input form.</p>";
        }
?>
