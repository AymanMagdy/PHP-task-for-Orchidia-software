<?php

// The php file of connecting to the google api and getting the needed google sheet to start processing..

require __DIR__ . '/vendor/autoload.php';
putenv('GOOGLE_APPLICATION_CREDENTIALS=' . __DIR__ . '/client_secret.json');        // The directory of the .json file
use Google\Spreadsheet\DefaultServiceRequest;
use Google\Spreadsheet\ServiceRequestFactory;

// Creating a new Google client and put the default credentials, project name and the scopes..
$GLOBALS['client'] = new Google_Client;
$client = $GLOBALS['client'];
$client->useApplicationDefaultCredentials();
$client->setApplicationName("User");
$client->setScopes(['https://www.googleapis.com/auth/drive','https://spreadsheets.google.com/feeds']);

// Check the access token..
if ($client->isAccessTokenExpired()) {
    $client->refreshTokenWithAssertion();
}

// Put the default service request
$accessToken = $client->fetchAccessTokenWithAssertion()["access_token"];
ServiceRequestFactory::setInstance(
    new DefaultServiceRequest($accessToken)
);


// Connecting to the sheet by connecting to the sheet itself directly..





class queries{

     // Function update, the condition is the email of the user..
    function update($email,$ID,$username,$Email,$create,$modify){

        // The connection is establishing to the sheet directly by using its id
        $service = new Google_Service_Sheets($GLOBALS['client']);
        $spreadsheetId = '1DsS-6N5ncPMSEaRY1Dv1i0Hl87jgdPdI_MvndvobRfE';
        $valueRange = new Google_Service_Sheets_ValueRange();
        $range = "QUERY(A:E,\"SELECT* WHERE C =$email\")"; //Using the Google query language, by passing the conditions in the ID and Email
        $valueRange->setValues(["values" => [$ID,$username, $Email,$create,$modify]]);   // set values by the new data..
        $conf = ["valueInputOption" => "RAW"]; // The way of inserting the data to the sheet
        $edit = $service->spreadsheets_values->update($spreadsheetId, $range, $valueRange, $conf); // The update process
        if($edit == true) // Confirming the data has updated..
            echo 'The data updated';

    }

    // Function delete to delete the data by the user's email
    function delete($email){

        // The connection is establishing to the sheet directly by using its id
        $service = new Google_Service_Sheets($GLOBALS['client']);
        $spreadsheetId = '1DsS-6N5ncPMSEaRY1Dv1i0Hl87jgdPdI_MvndvobRfE';
        $value = new Google_Service_Sheets_ClearValuesRequest();
        $range = "QUERY(A:E,\"SELECT* where C = $email\")"; //Using the Google query language, by passing the condition email
        $response = $service->spreadsheets_values->clear($spreadsheetId, $range, $value);
        if($response == true) // Confirming the data has deleted..
            echo 'The data deleted';
    }

    // Function insert which works on insert the data to the spreadsheet
    function insert($ID,$username,$Email,$create,$modify){

        // The connection is establishing to the sheet directly by using its id
        $service = new Google_Service_Sheets($GLOBALS['client']);
        $spreadsheetId = '1DsS-6N5ncPMSEaRY1Dv1i0Hl87jgdPdI_MvndvobRfE';
        $valueRange = new Google_Service_Sheets_ValueRange();
        $range = "INDEX( SORT( A:E , ROW(A:E) , FALSE ),1)";
        $valueRange->setValues(["values" => [$ID, $username,$Email,$create,$modify]]);   // set values by the new data..
        $conf = ["valueInputOption" => "RAW"]; // The way of inserting the data to the sheet
        $insert = $service->spreadsheets_values->append($spreadsheetId,$range,$valueRange,$conf); // The update process
        if($insert == true) // Confirming the data has inserted..
            echo 'The data inserted';
    }


}



/*
// Get our spreadsheet
$spreadsheet = (new Google\Spreadsheet\SpreadsheetService)
    ->getSpreadsheetFeed()
    ->getByTitle('Copy of User');

// Get the first worksheet in a new variable
$worksheets = $spreadsheet->getWorksheetFeed()->getEntries();
$worksheet = $worksheets[0];

// Get what inside the sheet
$listFeed = $worksheet -> getListFeed();

// Put the content of the sheet in an array and getting its values
foreach ($listFeed->getEntries() as $entry) {
    $representative = $entry->getValues();
}

// Getting the cell feed and put it in array, and getting the list feed
$cellFeed = $worksheet->getCellFeed();
$rows = $cellFeed->toArray();
$cellFeed = $worksheet->getCellFeed();
$listFeed = $worksheet->getListFeed();
*/


?>
