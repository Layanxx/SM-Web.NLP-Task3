<?php

$servername = "localhost:3306";
$username = " root";
$password = "";
$dbname = "converter";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['transcript'])) {
    $transcript = $_POST['transcript'];

    $sql = "INSERT INTO voicetotext (TheText) VALUES ('$transcript')";

    if ($conn->query($sql) === TRUE) {
        echo "Text registered.";
    } else {
        echo "Text not registered: " . $sql . "<br>" . $conn->error;
    }
}

$sql = "SELECT * FROM voicetotext";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

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

        .VoiceToText{
            width: 600px;
            text-align: center;
        }

        #convert{
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
    <form method="POST" action="">
    <div class="VoiceToText">
        <h1>Voice to Text Converter</h1>
        <textarea id="convert" name="convert"></textarea>
        <button id="ClickToConvert" name="ClickToConvert">Convert</button>
    </div>
    <script>

ClickToConvert.addEventListener('click',function(){
   var speech = true;
   window.SpeechRecognition = window.webkitSpeechRecognition;

   const recognition = new SpeechRecognition();
   recognition.interimResults = true;

   recognition.addEventListener('result', e => {
       const transcript = Array.from(e.results)
           .map(result => result[0])
           .map(result => result.transcript)
           .join('')

       document.getElementById("convert").innerHTML = transcript;
       console.log(transcript);
   });
   
   if (speech == true) {
       recognition.start();
   }
})
    </script>
</form>
</body>
</html>