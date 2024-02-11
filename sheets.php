<?php
include "config.php";
require  'google-api/vendor/autoload.php';
$client = new \Google_Client();
$client->setApplicationName('Google Sheets with Primo');
$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
$client->setAccessType('offline');
$client->setAuthConfig('sqltoexcel-414007-5c2ef082b158.json');
$service = new Google_Service_Sheets($client);
function writedata($service,$values){
    $spreadsheetId = "1GOjHyosH-vZTsd0Pn8y4iaaDaB1VschXt83gsAkm66k";
    $range = "sqltoexcel";
    $body = new Google_Service_Sheets_ValueRange([
        'values' => $values
    ]);
    $params = [
        'valueInputOption' => 'RAW'
    ];
    $result = $service->spreadsheets_values->append(
        $spreadsheetId,
        $range,
        $body,
        $params
    );
    if ($result->updates->updatedRows == 1) {
       return 1;
    } else {
        return 0;
    }
}

if (isset($_POST['submit'])) {
	// echo "prem here ",exit;
	$query = "SELECT * FROM accounts";
	$result = mysqli_query($conn, $query);
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$executed=0;
			$notexecuted=0;
			$values = [
				[$row['email'], $row['image_address'], $row['Id_no'], $row['Year_Start'], $row['Year_End'], $row['year'], $row['branch'], $row['section']]
			];
			$retrunvalue=writedata($service,$values);
			if ($returnvalue == 1) {
				$executed = $executed + 1;
			} elseif ($returnvalue == 0) {
				$notexecuted = $notexecuted + 1;
			}			
		}
	}
	echo'<div class="alert alert-success mt-4" role="alert" id="successAlert" >
	Form submitted successfully! with '.$executed.' value and not executed values '.$notexecuted.'
</div>';
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Form with Bootstrap</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="mb-4">Update Form Page</h2>
                <form method="post" >
                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
