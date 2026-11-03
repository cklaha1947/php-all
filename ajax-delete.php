<?php  
$studentId = $_POST["id"];
$conn = mysqli_connect("localhost", "root", "", "pap2");
$sql = "SELECT * FROM students WHERE id='{$studentId}'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_array($result);
    //delete the existing image from the folder:-
    $image_file_path = 'image_folder/'.$row["stdimg"];
    if(file_exists($image_file_path)){
        unlink($image_file_path);
    }
}
$sql1 = "DELETE FROM students WHERE id='{$studentId}'";
if (mysqli_query($conn, $sql1)) {
    echo 1;
} else {
    echo 0;
}


?>