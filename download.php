<html>
<head>
    <title>Download</title>
    <meta charset="utf-8">
</head>

<body>

<h1>The download</h1>

<?php
$url = "";
$pass = "";

if (isset($_POST["filename"])) {
    $url = $_POST["filename"];
} else {
    die("<p>No file specified</p>");
}

if (isset($_POST["pass"])) {
    $pass = $_POST["pass"];
} else {
    $pass = "1234";
}

$file_name = basename($url);
    
if (file_put_contents("downloads/" . $file_name, file_get_contents($url)))
{
    echo "File downloaded successfully:<br/>";

    $zip = new ZipArchive;
    $res = $zip->open("downloads/" . $file_name . ".zip", ZipArchive::CREATE);
    
    //Add your file name
    if ($res === TRUE) {
        $zip->addFile('downloads/' . $file_name, $file_name);
        
        //Add your file name
        $result = $zip->setEncryptionName($file_name, ZipArchive::EM_AES_128, $pass); //Add file name and password dynamically
        $zip->close();

        //generate link
        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $actual_link = str_replace("download.php", "downloads/" . $file_name . ".zip", $actual_link);

        unlink("downloads/" . $file_name);
        
        echo "<a href=\"". $actual_link . "\">" .  $actual_link . "</a>";
    } else {
        echo '<p>failed to zip file</p>';
    }
}
else
{
    echo "<p>File downloading failed.</p>";
}
?>

</body>
</html>