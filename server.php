<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $encryptedPassword = $_POST["encryptedPassword"];
    $key = $_POST["encryptionKey"];

    echo $encryptedPassword;

    // Derivar la clave usando SHA-256
    $derivedKey = hash('sha256', $key, true);

    // Decodificar el mensaje Base64
    $encryptedData = base64_decode($encryptedPassword);

    // Extraer el IV (los primeros 16 bytes)
    $iv = substr($encryptedData, 0, 16);
    
    // Extraer el ciphertext (el resto de los bytes)
    $ciphertext = substr($encryptedData, 16);

    // Descifrar el mensaje con OpenSSL
    $decryptedPassword = openssl_decrypt($ciphertext, 'aes-256-cbc', $derivedKey, OPENSSL_RAW_DATA, $iv);

    
    // Mostrar la contraseña descifrada
    if ($decryptedPassword === false) {
        echo "Error al descifrar la contraseña.";
        } else {
        echo "Contraseña original descifrada: " . htmlspecialchars($decryptedPassword);
    }
    } else {
        echo "No se ha enviado ninguna contraseña cifrada.";
    }
?>    
