<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Game Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
</head>
<body>
    <?php
    //entry code
    //how did we get here?
    //on submit process the data
    //validate and write to a file
    $dir = ".";
    $saveFileName = "./TheGamers.txt";
    $saveString = "";
    $dataArray = array();

    function displayAlert($message) {
        echo "<script>alert(\"$message\")</script>";
    }
    
    if (is_dir($dir)) {
        if (isset($_POST['save'])) {
            if (empty($_POST['userName'])) {
                displayAlert("Unknown User");
            }
            else {
                $dataArray[] = stripslashes($_POST['userName']);
                $dataArray[] = md5(stripslashes($_POST['password']));
                $dataArray[] = stripslashes($_POST['fullName']);
                $dataArray[] = stripslashes($_POST['email']);
                $dataArray[] = stripslashes($_POST['age']);
                $dataArray[] = stripslashes($_POST['screenName']);
                $dataArray[] = stripslashes($_POST['comments']);
                $saveString = implode();
                $saveString .= "\n";
                //debug
                echo "\saveString = $saveString<br>";
                $fileHandle = fopen($saveFileName, "ab");
                if ($fileHandle === false) {
                    displayAlert("There was an error creating $saveFileName");
                }
                else {
                    if (flock($fileHandle, LOCK_EX)) {
                        if (fwrite($fileHandle,$saveString) > 0) {
                            displayAlert("Successfully wrote to file $saveFileName.");
                        }
                        else {
                            displayAlert("There was an error writing to $saveFileName.");
                        }
                        flock($fileHandle, LOCK_UN);

                    }
                    else {
                        displayAlert("There was an error locking file $saveFileName for writing.");
                    }
                    fclose($fileHandle);
                }
            }
        }
    }
    ?>
    <!--  HTML FORM -->
    <h1>Register For The Game</h1>
    <form action="TheGame.html" method="POST">
        Username<br> <input type="text" name="UserName"><br>
        Password<br> <input type="password" name="password"><br>
        Full Name<br> <input type="text" name="fullName"><br>
        E-mail<br> <input type="email" name="email"><br>
        Age<br> <input type="number" name="age"><br>
        Screen Name<br> <input type="text" name="screenName"><br>
        Comments<br> <textarea name="comments" cols="40"></textarea><br>
        <input type="submit" name="save" value="Submit Your Registration"><br>
    </form>
    <?php 
    //display code
    //read the file and display the data
    ?>
</body>
</html>