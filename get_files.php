<?php
// Asetetaan vastauksen tyypiksi JSON ja sallitaan haku muista osoitteista (CORS)
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

$directory = "ships/";
$fileList = [];

if (is_dir($directory)) {
    if ($handle = opendir($directory)) {
        while (($file = readdir($handle)) !== false) {
            // Ohitetaan piilotiedostot ja hakemistoviitteet
            if ($file != "." && $file != "..") {
                $fileList[] = [
                    "filename" => $file,
                    "download_url" => "http://" . $_SERVER['HTTP_HOST'] . "/" . $directory . $file,
                    "size_bytes" => filesize($directory . $file)
                ];
            }
        }
        closedir($handle);
        
        // Palautetaan data ja HTTP 200 OK
        http_response_code(200);
        echo json_encode($fileList, JSON_PRETTY_PRINT);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Kansiota ei voitu avata."]);
    }
} else {
    http_response_code(404);
    echo json_encode(["error" => "Kansiota ei löydy."]);
}
?>