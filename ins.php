<?php 
$conn = mysqli_connect("localhost","root","","pap2");
$name = $_POST["name"];
$gender = $_POST["gender"];
$stream = $_POST["stream"];
$subject = isset($_POST["sub"]) ? implode(",", $_POST["sub"]) :"";

$fileName = $_FILES["simg"]["name"];
$extension = pathinfo($fileName, PATHINFO_EXTENSION);
$validExtension = array("jpg","jpeg","png","gif");
$newName = "";
if (in_array($extension, $validExtension)) {
    $newName .= time() .".". $extension;
    $filePath = "image_folder/". $newName;
    move_uploaded_file($_FILES["simg"]["tmp_name"], $filePath);

}

$sql = "INSERT INTO students(name,gender,stream,subject,stdimg) VALUES ('{$name}','{$gender}','{$stream}','{$subject}','{$newName}')";
if (mysqli_query($conn, $sql)) {
    echo 1;
} else {
    echo 0;
}




?>