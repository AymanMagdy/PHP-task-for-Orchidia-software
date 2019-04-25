<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <title>User form</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"> <!-- Calling the CSS bootstrap file -->

</head>

<body background="bg.jpg" >
<div>
    <!-- The user form with its own styles with calling of some bootstrap classes, the names is to use it with the php code-->
    <form action="<?php $_SERVER["PHP_SELF"]?>" method="post" style="margin: 10%; margin-bottom: 10px;">
        <h3 style="color:whitesmoke ">ID:</h3>
            <input type="number" name="id" placeholder="Enter the ID.." class="form-control">
            <br>
            <h3 style="color: whitesmoke">First name:</h3>
            <input type="text" name="username" placeholder="Enter the first name.." class="form-control">
            <br>
            <h3 style="color: whitesmoke">Email:</h3>
            <input type="email" name="Email" placeholder="Enter the Email.." class="form-control">
        <h3 style="color: whitesmoke">Created:</h3>
        <input type="text" name="create" placeholder="Created.." class="form-control">
        <h3 style="color: whitesmoke">Modified:</h3>
        <input type="text" name="mod" placeholder="Modified.." class="form-control">
            <br>
        <!-- The drop down list to select what is the needed process, with its name and values -->
            <select name="select" class="btn btn-outline-primary custom-select-sm">
                <option selected="selected" value="null">Select</option>
                <option value="insert">Insert</option>
                <option value="modify">Modify</option>
                <option value="delete">Delete</option>
            </select>

            <input type="submit" value="Submit" name="submit" class="btn btn-outline-primary">
    </form>

</div>
</body>
</html>


<!-- The php code to  -->
<?php

if(isset($_POST["submit"])) {

    // connecting to the sheet once the user click submit
    include_once('connect.php');

    // Getting the data from the html form
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['Email'];
    $create = $_POST['create'];
    $modify = $_POST['mod'];
    $select = $_POST['select'];

    // If all of the fields are not null, the php code will start to work as well to insert, modify and delete data from the google sheet
    if ($id != null && $username != null && $email != null && $select != null) {



        // Switch case
        switch ($select){
            case 'modify':
                $modify = new queries();
                $modify-> update($email, $id, $username, $email, $create, $modify);
                break;

            case 'insert':
                $insert = new queries();
                $insert-> insert($id, $username,$email,$create,$modify);
                break;

            case 'delete':
                $delete = new queries();
                $delete-> delete($email,$id,$username,$email,$create,$modify);
                break;

            default :
               echo "No selected option..";
            }

        /*
                // Switch case to check what does the user of the form wanna do..
                switch ($select) {

                    case 'insert': // Case inserting the data, then printout an echo to tell th user everything is done..
                        //Inserting the id, username, and the email..
                        $listFeed->insert([
                            'id' => $id,
                            'username' => $username,
                            'email' => $email
                        ]);
                        echo "<h1 style=\"color: whitesmoke\">The data entered to the sheet..</h1>";
                        break;

                    case 'modify':  // Updating the data  by getting the id, username, and the email

                        $listFeed = $worksheet->getListFeed();

                        foreach ($listFeed->getEntries() as $entry) {
                            if ($entry->getValues()['id'] === $id) { // Getting the values by the id to start the updating..
                                // Take the entry and update just its `username, email` property
                                $entry->update(array_merge($entry->getValues(), ['username' => $username], ['email' => $email]));
                                echo "<h1 style=\"color: whitesmoke\">The data updated..</h1>";
                                break;
                            }
                        }
                        break;

                    case 'delete': // The case of deleting the data by using the id
                        $listFeed = $worksheet->getListFeed();

                        foreach ($listFeed->getEntries() as $entry) {
                            if ($entry->getValues()['id'] === $id) { // Getting the values by the id
                                $entry->delete(); // The process of deleting
                                echo "<h1 style=\"color: whitesmoke\">The data deleted from the sheet..</h1>";
                                break;
                            }
                        }
                }
            } // else if there's a null value got from the users
            else echo "<h1 style=\"color: whitesmoke\">No data processed, there's a null value..</h1>";
        */


    }

}
?>