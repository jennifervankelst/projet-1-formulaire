
<?php

if(isset($_POST['valider'])) {

    // MODIFIER LES 2 LIGNES CI-DESSOUS COMME REQUIS
    $email_to = "jennifer.vankelst@gmail.com";
    $email_subject ="Hackers Poulette";

    function died ($error) {
        // CODE D ERREUR PEUT ALLER ICI 
        //echo "vous n avez pas bien rempli le formulaire<br /><br />";
        echo $error."<br /><br />";
        die ();

    }
    print_r($_POST);
    // LA VALIDATION DES DONNEES ATTENDUES EXISTES

    if(!isset($_POST['nom']) ||
    
        !isset($_POST['message'])) {
        
        died('Desoler il y a un souci avec le formulaire que vous avez envoyes');
        
    }

    $nom = $_POST['nom']; // required
    $email = $_POST['email']; // required
    $pays = $_POST['pays']; // required
    $genre = $_POST['genre']; // required
    $sujet = $_POST['sujet']; // required
    $objet = $_POST['objet']; // required
    $message = $_POST['message']; // required
    
    $error_message = "";
    $email_exp = '#^[\w.-]+@[\w.-]+\.[a-z]{2,6}$#i';

    if (!preg_match($email_exp,$email)) {
        $error_message = 'L adresse email que vous avez rentré n est pas valide.';
    }

    $string_exp = "/^[A-Za-z .'-]+$/";

    if (!preg_match($string_exp,$nom)) {    
        $error_message = 'votre nom ou prenom ne semble pas valide.';
            
    }

    if (!preg_match($string_exp,$pays)) {    
        $error_message = 'votre pays ne semble pas etre valider.';

    }
    
    if (!preg_match($string_exp,$genre)) {
        $error_message = 'votre genre ne semble pas etre valider.';

    }
    
    if(!preg_match($string_exp,$sujet)) {
        $error_message = 'votre sujet ne semble pas etre valide.';

    }
    
    if(!preg_match($string_exp,$objet)) {
        $error_message = 'votre objet ne semble pas etre valide.';
    }
 
 
    if(strlen($message) < 2) {
        $error_message = 'votre message ne semble pas etre valide';
    }

    if(strlen($error_message) > 0) {
        died($error_message);
    }
 
    $options = array(
      'nom' => FILTER_SANITIZE_STRING,
      'email' => FILTER_SANITIZE_STRING,
      'pays' => FILTER_SANITIZE_STRING,
      'genre' => FILTER_SANITIZE_STRING,
      'sujet' => FILTER_SANITIZE_STRING,
      'objet' => FILTER_SANITIZE_STRING,
      'message' => FILTER_SANITIZE_STRING);

      $result = filter_input_array(INPUT_POST, $options);  

    $email_message = "Détails du formulaire ci-dessous.\n\n";

    function clean_string($string) {
        $bad = array("content-type","bcc:","to:","cc:","href");
        return str_replace($bad,"",$string);
      }
      
    $email_message = "nom: " . clean_string($nom)."\n";
    $email_message = "email: " . clean_string($email)."\n";
    $email_message = "pays: " . clean_string($pays)."\n";
    $email_message = "genre: " . clean_string($genre)."\n";
    $email_message = "sujet: " . clean_string($sujet)."\n";
    $email_message = "objet: " . clean_string($objet)."\n";
    $email_message = "message: " . clean_string($message)."\n";

    // CREER DES EN-TETES DE MESSAGERIE

    $headers = 'From: ' .$email_from."\r\n".
    'Reply-To: ' .$email_from."\r\n" .
    'X-Mailer: PHP/' . phpversion();
    mail($email_to, $email_subject, $email_message, $headers);
    
    var_dump ($nom, $email, $pays, $genre, $sujet, $objet, $message);

}

?>