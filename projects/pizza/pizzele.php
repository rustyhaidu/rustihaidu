<?php  
mysql_connect("localhost", "root", "") or die ("Nu ma pot conecta la server");
mysql_select_db("pizza") or die ("Nu pot selecta baza de date");

// Build the sql command string 
$interogare = "SELECT * from mica";
					
$query = mysql_query($interogare) or die (mysql_error()); 
// Output the data here using a while loop, the loop will return all members 
while ($row = mysql_fetch_array($query)) { 
    // Gather all $row values into local variables for easier usage in output 
    $id = $row["id_gramaj"]; 
    $title = $row["tip"]; 
     
    
    // echo the output to browser 
    echo "Item ID = $id 
    <br />Item Title = $title
    <hr />"; 
} 
// Free the result set if it is large 
mysql_free_result($query);  
// close mysql connection 
mysql_close(); 
?>