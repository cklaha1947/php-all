<?php 

$conn = mysqli_connect("localhost","root","","pap2");
$search_term = $_POST['name'];
$sql = "SELECT distinct(name) FROM students WHERE name LIKE '%{$search_term}%'";
$result = mysqli_query($conn, $sql);
$output = "<ul>";
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $output .= "<li>{$row['name']}</li>";
    }

}else{
    $output .= "<li><h1>Result not Found...</h1></li>";
}
$output .= "</ul>";
echo $output;



?>