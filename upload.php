<?php
if (isset($_POST['submit'])) {
    $file = $_FILES['myFile'];

    // Tiedoston tiedot
    $fileName = $_FILES['myFile']['name'];
    $fileTmpName = $_FILES['myFile']['tmp_name'];
    $fileError = $_FILES['myFile']['error'];

    // Kohdekansio (varmista, että tämä kansio on olemassa samassa polussa)
    $uploadDirectory = "ships/";

    // Tarkistetaan, ettei latauksessa tapahtunut virhettä
    if ($fileError === 0) {
        // Määritetään lopullinen tallennuspolku
        $fileDestination = $uploadDirectory . basename($fileName);

        // Siirretään tiedosto väliaikaisesta kansiosta lopulliseen kansioon
        if (move_uploaded_file($fileTmpName, $fileDestination)) {
            echo "Tiedosto " . htmlspecialchars($fileName) . " ladattiin onnistuneesti!";
        } else {
            echo "Tiedoston siirtämisessä kansion sisälle tapahtui virhe.";
        }
    } else {
        echo "Tiedoston latauksessa tapahtui virhe koodilla: " . $fileError;
    }
}
?>