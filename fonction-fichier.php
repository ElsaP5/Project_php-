
<?php
function enregistrer_image
($nom_dossier, $nom_fichier, $nom_tmp, $extensions=array("jpeg", "jpg", "png")){
    if (file_exists($nom_dossier) == false){
        mkdir ($nom_dossier,0777);
    }

    $info_fichier = pathinfo($nom_fichier);
    $fichier_extension = $info_fichier["extension"];

    if (in_array($fichier_extension,$extensions)){
        move_uploaded_file($nom_tmp,"$nom_dossier/$nom_fichier");
            return 1; 
    }
    else {
        return 0; 
    }
}
//it didn't work because i had to check if the extension existed and had to put $res def outside the loop
function dossier_en_select
($nom_dossier, $extensions = array("jpeg","jpg", "png")) {
    $fichier_dans_dossier = scandir($nom_dossier);
   
    foreach($fichier_dans_dossier as $fichier){
        $info_fichier = pathinfo($fichier);
        if (isset($info_fichier["extension"]) && in_array($info_fichier["extension"], $extensions)){
            echo "<option> $fichier </option>";
        }
    }
    
}
?>
