<?php
	session_start();

	$nom_dossier = "img_" . session_id();
    require 'fonction-fichier.php';
?>

<html>
<head> 
        <meta charset = "utf-8 ">
        <title> Image Library </title >
        <link rel="styleSheet" href="style.css" />
    </head>
<body>
    <h1>Image Library : </h1>
    <div class = "forms">
        <table>
            <td>
        <div class = "form" id="image-send">
            <form action="" method ="post" enctype= "multipart/form-data">
                <label for = "image-added">Add an image:</label>
                <input type ="file" name = "image-added" ></input>
                <input type ="submit" value ="Send" name ="send" id = "send-button"></input>
            </form>
</td>
        </div>
         <!--Php here : -->
        <?php
        $extensions = array("jpeg", "jpg", "png");
    //need to see if it exists before we try to set values
        

            if(isset($_FILES["image-added"])){
                $fichier = $_FILES["image-added"];
                $res = enregistrer_image($nom_dossier, $fichier["name"], $fichier["tmp_name"]);

                if ($res) {
                    echo "enregistrement réussi";
                } else {
                    echo "enregistrement échoué";
                }
            }
       
        ?>
        <td>
        <div class = "form" id = "display-image">
            <form action="" method ="post">
                <select name = "file_selected">
               <?php
               echo dossier_en_select($nom_dossier);
               ?> 
            <input type = "submit" value = "Affiche Images" name ="Display_button"id ="display-button"></input>
            </form>
        </select>
        </div>
    </td>
    </table>
    </div>
    <div id = "image">
        
    <!--here is where we gonna affiche our image-->
    <?php
   //post didnt work in the other functions but it worked here  
    if (isset($_POST["file_selected"])){
        $image = $_POST["file_selected"];
        echo "image affiche"; 
        echo "<img src = '$nom_dossier/$image'/>";
    }
        else {
            echo "no image shown"; 
        }
        ?>
    
    </div>
    
</body>
</html>