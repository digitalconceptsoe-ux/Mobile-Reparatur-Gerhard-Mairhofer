<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Daten aus dem Formular abfangen und säubern
    $name = strip_tags(trim($_POST['kunden_name'] ?? ''));
    // Das ?? '' verhindert die Warnung, falls das Feld im HTML falsch benannt ist
    $telefon = strip_tags(trim($_POST['kunden_telefon'] ?? '')); 
    $email = filter_var(trim($_POST['kunden_email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $betreff_auswahl = $_POST['kunden_betreff'] ?? 'Allgemeine Anfrage';
    $nachricht = trim($_POST['kunden_nachricht'] ?? '');

    // 2. Empfänger-Adresse (Die Ziel-Adresse für die Anfragen)
    $empfaenger = "samuel.mayrhofer7a@gmail.com";
    
    // 3. E-Mail-Inhalt für das Postfach zusammenbauen
    $betreff = "Neue Website-Anfrage: " . $betreff_auswahl;
    
    $email_inhalt = "Du hast eine neue Anfrage über das Kontaktformular erhalten:\n\n";
    $email_inhalt .= "Name: $name\n";
    $email_inhalt .= "Telefon: $telefon\n";
    $email_inhalt .= "E-Mail: " . ($email ? $email : "Nicht angegeben") . "\n\n";
    $email_inhalt .= "Beschreibung des Anliegens:\n$nachricht\n";

    // 4. E-Mail-Header (Wichtig, damit die Mail nicht im Spam landet)
    $header = "From: website@mobile-reparatur.at" . "\r\n" .
              "Reply-To: " . ($email ? $email : $empfaenger) . "\r\n" .
              "Content-Type: text/plain; charset=UTF-8";

    // Styling für die Rückmeldung auf dem Bildschirm
    echo "<!DOCTYPE html>";
    echo "<html lang='de'>";
    echo "<head><meta charset='UTF-8'><title>Versand-Status</title></head>";
    echo "<body style='background: #0f172a; color: white; font-family: sans-serif; padding: 40px;'>";

    // 5. Der echte Sende-Befehl
    if (mail($empfaenger, $betreff, $email_inhalt, $header)) {
        
        // Wenn der Server die Mail erfolgreich an den Postausgang übergibt:
        echo "<h1 style='color: #22c55e;'>✔ Code perfekt! E-Mail wurde versendet.</h1>";
        echo "<p>Die Nachricht wurde erfolgreich verarbeitet.</p>";
        
    } else {
        
        // Wenn wir lokal auf XAMPP testen und kein Mail-Ausgang eingerichtet ist:
        echo "<h1 style='color: #ef4444;'>❌ Daten verarbeitet, aber lokaler Mail-Versand fehlgeschlagen</h1>";

    }

    echo "<br><a href='index.html' style='color: #3b82f6; text-decoration: none;'>← Zurück zum Formular</a>";
    echo "</body>";
    echo "</html>";

} else {
    echo "Bitte nutzen Sie das Kontaktformular.";
}
?>