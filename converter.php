<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "converter";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['transcript'])) {
        $transcript = $_POST['transcript'];
        $sql = "INSERT INTO voicetotext (TheText) VALUES ('$transcript')";
        if ($conn->query($sql) === TRUE) {
            echo "Text registered.";
        } else {
            echo "Text not registered: " . $sql . "<br>" . $conn->error;
        }
        exit;
    }
}

$sql = "SELECT * FROM voicetotext";
$result = $conn->query($sql);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Converter</title>
    <style>
      
      body{
            font-family: Arial, Helvetica, sans-serif;
            font-size: 16px;
            margin: 0%;
            background:linear-gradient(to right bottom, #CE7777,#2B3A55);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh
        }

        h1{
            font-size: 50px;
            color: whitesmoke;
        }

.voice_to_text{
  width: 600px;
  text-align: center;
}




#convert_text{
  width: 100%;
  height: 200px;
  border-radius: 10px;
  resize: none;
  padding: 10px;
  font-size: 20px;
  margin-bottom: 10px;

}



button{
  padding: 12px 20px;
  background: #33425B;
  border: 0;
  border-radius: 5px;
  cursor: pointer;
  color: whitesmoke;
}

button:hover {
    background-color: #F2E5E5;
            }

</style>
</head>
<body>

<div class="voice_to_text">
    <h1 id="text">Voice to Text Converter</h1>
    <textarea id="convert_text" dir="ltr"></textarea>
    <button id="click_to_convert">Convert</button>
</div>

<script>
    const convertBtn = document.getElementById("click_to_convert");
    const convertTextArea = document.getElementById("convert_text");

    convertBtn.addEventListener('click', function() {
        const recognition = new (webkitSpeechRecognition || SpeechRecognition)();
        recognition.interimResults = true;

        recognition.addEventListener('result', e => {
            const transcript = Array.from(e.results)
                .map(result => result[0])
                .map(result => result.transcript)
                .join('');

            convertTextArea.innerHTML = transcript;
        });

        recognition.start();
    });
    convertTextArea.addEventListener('input', function() {
        const textToSave = convertTextArea.value;
        if (textToSave.length > 0) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText);
                }
            };
            xhr.send('transcript=' + encodeURIComponent(textToSave));
        } else {
            alert('No text to save.');
        }
    });
</script>

</body>
</html>