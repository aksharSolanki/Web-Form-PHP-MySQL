    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "studentsDB";

    //Making connection to create the database if it dosen't exist
    $conn = mysqli_connect($servername, $username, $password);
    $sql = "create database studentsDB";
    mysqli_query($conn, $sql);
    mysqli_close($conn);

    //Creating a new connection with the database created
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    //Table created
    $sql = "create table students(
        student_number VARCHAR(9) PRIMARY KEY,
        firstname VARCHAR(30),
        lastname VARCHAR(30),
        email VARCHAR(50),
        program VARCHAR(50)
    )";
    mysqli_query($conn, $sql);

    //Inserting sample rows
    $sql = "insert into students (student_number, firstname, lastname, email, program)
    values('N01298820', 'Alex', 'Carry', 'alexcarry@gmail.com', 'Software Engineering');";

    $sql .= "insert into students (student_number, firstname, lastname, email, program)
    values('N01298821', 'Bill', 'Wright', 'billwright@gmail.com', 'DB Programming');";

    $sql .= "insert into students (student_number, firstname, lastname, email, program)
    values('N01298822', 'Michael', 'Smith', 'michaelsmith@gmail.com', 'Accounting');";

    $sql .= "insert into students (student_number, firstname, lastname, email, program)
    values('N01298823', 'Maria', 'Garcia', 'mariagarcia@gmail.com', 'Business');";

    $sql .= "insert into students (student_number, firstname, lastname, email, program)
    values('N01298824', 'Will', 'Brown', 'willbrown@gmail.com', 'Architecture');";

    $sql .= "insert into students (student_number, firstname, lastname, email, program)
    values('N01298825', 'George', 'Wilson', 'georgewilson@gmail.com', 'Economics');";

    $sql .= "insert into students (student_number, firstname, lastname, email, program)
    values('N01298826', 'Thomas', 'Cook', 'thomascook@gmail.com', 'Electronics');";

    $sql .= "insert into students (student_number, firstname, lastname, email, program)
    values('N01298827', 'Angel', 'Khan', 'angelkhan@hotmail.com', 'Management');";
    mysqli_multi_query($conn, $sql);
    ?>
    <html>

    <head>
        <title>Student Form</title>
        <style>
            body {
                background-color: #5CDB95;
            }

            form {
                margin-left: 80px;
                margin-top: 50px;
            }

            h2 {
                margin-top: 20px;
                text-align: center;
                font-size: 5em;
                color: white;
            }

            label {
                width: 200px;
                display: inline-block;
                margin: 20px;
                font-size: 25px;
                font-weight: bold;
                color: white;
            }

            input {
                font-size: 25px;
                color: #476b6b;
            }

            #userInput {
                width: 350px;
                border-radius: 10px;
                border: 0px solid #5CDB95;
            }

            #button {
                background-color: darkturquoise;
                color: white;
                padding: 6px;
                border-radius: 12px;
                margin: 10px;
            }

            #error {
                color: red;
                font-size: 2em;
                margin-top: 20px;
                padding: 10px;
                font-weight: bold;
            }

            #message {
                color: green;
                font-size: 2em;
                margin-top: 20px;
                padding: 10px;
            }
        </style>
    </head>

    <body>
        <?php
        $studentNumber = "";
        $fname = "";
        $lname = "";
        $email = "";
        $program = "";
        $errorBox = "";
        $messageBox = "";

        //Search Button functionality
        if (isset($_POST['btnSearch'])) {
            //Connection created
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            $flagNum = false;

            //Checks if any required field is left empty before searching data
            if (empty($_POST["studentNumber"])) {
                $errorBox = "Student Number cannot be empty";
            } else {
                $studentNumber = $_POST["studentNumber"];
                $flagNum = true;
            }
            if ($flagNum == true) {
                //sql query
                $sql = "select firstname, lastname, email, program from students where student_number = '$studentNumber'";
                $results = mysqli_query($conn, $sql);

                if (mysqli_num_rows($results) > 0) {
                    while ($rows = mysqli_fetch_assoc($results)) {
                        $fname = $rows["firstname"];
                        $lname = $rows["lastname"];
                        $email = $rows["email"];
                        $program = $rows["program"];
                    }
                    $messageBox = "Record found.";
                } else {
                    $errorBox = "NO SUCH STUDENT EXISTS";
                }
            }

            mysqli_close($conn);
        }

        //Insert button functionality
        if (isset($_POST['btnInsert'])) {
            $flagNum = false;
            $flagMail = false;
            //Connection created
            $conn = mysqli_connect($servername, $username, $password, $dbname);

            //Checks if any required field is left empty before inserting data
            if (empty($_POST["studentNumber"])) {
                $errorBox = "Student Number & Email cannot be empty";
            } else {
                $studentNumber = $_POST["studentNumber"];
                $flagNum = true;
            }
            $fname = $_POST["fname"];
            $lname = $_POST["lname"];
            if (empty($_POST["email"])) {
                $errorBox = "Student Number & Email cannot be empty";
            } else {
                $email = $_POST["email"];
                $flagMail = true;
            }
            $program = $_POST["program"];
            if ($flagNum == true && $flagMail == true) {
                $sql = "insert into students (student_number, firstname, lastname, email, program)
                values('$studentNumber', '$fname', '$lname', '$email', '$program');";

                if (mysqli_query($conn, $sql)) {
                    $messageBox = "Successfully inserted the student record.";
                } else {
                    $errorBox = "Error while inserting the student record: " . mysqli_error($conn);
                }
            }
            mysqli_close($conn);
        }

        //Update button functionality
        if (isset($_POST['btnUpdate'])) {
            //Connection created
            $conn = mysqli_connect($servername, $username, $password, $dbname);

            $flagNum = false;
            $flagMail = false;

            //Checks if any required field is left empty before updating data
            if (empty($_POST["studentNumber"])) {
                $errorBox = "Student Number & Email cannot be empty";
            } else {
                $studentNumber = $_POST["studentNumber"];
                $flagNum = true;
            }
            $fname = $_POST["fname"];
            $lname = $_POST["lname"];
            if (empty($_POST["email"])) {
                $errorBox = "Student Number & Email cannot be empty";
            } else {
                $email = $_POST["email"];
                $flagMail = true;
            }
            $program = $_POST["program"];

            if ($flagNum == true && $flagNum == true) {
                $sql = "update students set firstname = '$fname',
                     lastname = '$lname',
                     email = '$email',
                     program = '$program'
                    where student_number = '$studentNumber'";
                if (mysqli_query($conn, $sql)) {
                    $messageBox = "Successfully updated the student records.";
                } else {
                    $errorBox = "Error while updating the student records: " . mysqli_error($conn);
                }
            }
            mysqli_close($conn);
        }

        //Delete button functionality
        if (isset($_POST['btnDelete'])) {
            //Connection created
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            $flagNum = false;
            //Checks if any required field is left empty before updating data
            if (empty($_POST["studentNumber"])) {
                $errorBox = "Student Number cannot be empty";
            } else {
                $studentNumber = $_POST["studentNumber"];
                $flagNum = true;
            }
            if ($flagNum == true) {
                $sql = "delete from students where student_number = '$studentNumber'";

                if (mysqli_query($conn, $sql)) {
                    $messageBox = "Successfully deleted the student record.";
                } else {
                    $errorBox = "Error while deleting the student record: " . mysqli_error($conn);
                }
            }
            mysqli_close($conn);
        }

        ?>
        <h2>Student Account Access</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label>Student Number:</label>
            <input type="text" name="studentNumber" value="<?php echo $studentNumber; ?>" id="userInput" />
            <input type="submit" name="btnSearch" value="Search" id="button" />
            <br>
            <label>First Name:</label>
            <input type="text" name="fname" value="<?php echo $fname; ?>" id="userInput" />
            <br>
            <label>Last Name:</label>
            <input type="text" name="lname" value="<?php echo $lname; ?>" id="userInput" />
            <br>
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $email; ?>" id="userInput" />
            <br>
            <label>Program:</label>
            <input type="text" name="program" value="<?php echo $program; ?>" id="userInput" />
            <br><br>
            <input type="submit" name="btnInsert" value="Insert" id="button" />
            <input type="submit" name="btnUpdate" value="Update" id="button" />
            <input type="submit" name="btnDelete" value="Delete" id="button" />
            <br><br>
            <span id="message"><?php echo $messageBox; ?></span>
            <span id="error"><?php echo $errorBox; ?></span>
        </form>
    </body>

    </html>
    <?php
    mysqli_close($conn);
    ?>
