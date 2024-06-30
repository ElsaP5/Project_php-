# Markdown du project

---

# Index.php and fonction-ficher.php

Ont commencé la page avec une  **`session_start()`** ca doit être le premier code php; 

```php

	session_start();

	$nom_dossier = "img_" . session_id();
    require 'fonction-fichier.php';
```

in this code we are:

1. starting a session
2.  and initialising our variable that we’re  going to use as our folder name  **`$nom_dossier`** 
3.  and we set the value to “img_” added to the **`session_id()`** 
4. then we require our file with our functions called **`fonction-ficher.php`** 

### What are Sessions:

 **`session_start()` sert  à :**  To start a session and be able to store info not on the users computer  
**`session_id()` représente:** to Create or get the id for the sessions.

- you can store user information with session variables
    - You set session/modify variables like this
        
        ```php
        $_SESSION["favanimal"]= "shark"
        ```
        
    - This variables last till the user closes the browser
    - stored globally and variables are reteirved when we **`session_start()`**
    - with print_r ($_SESSION) we can print all variables that it has for that
- if the user key is  match it accesses the session if not it creates a new session
- to remove the variables of a session its session_unset()
- to destroy session its session_destroy

**Links on sessions that helped me understand:** 

[PHP: session_id - Manual](https://www.php.net/manual/en/function.session-id.php)

<aside>
⌨️ **Note:** The `session_start()` function must be the very first thing in your document. Before any HTML tags.

[W3Schools.com](https://www.w3schools.com/php/php_sessions.asp)

</aside>

---

## Structure of the page

**This form is for uploading and saving a picture to this website** 

```html

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
```

## How do we do this?

by enabling the function called **enregistrer_image** that we developed in fonction-ficher  **this is the function:**  

```php
function enregistrer_image
($nom_dossier, $nom_fichier, $nom_tmp, $extensions=array("jpeg", "jpg", "png")){
    if (file_exists($nom_dossier) == false){
        mkdir ($nom_dossier);
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
```

<aside>
⌨️ this function takes  **$nom_dossier, $nom_fichier, $nom_tmp, $extensions=array("jpeg", "jpg", "png"**

1. Checks if a file exists with the name **nom_dossier** that we initialised  in the begging 
2. if it doesn’t we create it in our computer with mkdir 
3. then we create the variable **$info_fichier**  that through **pathinfo** gives us the info of **$nom_ficher** 
4. then we create the variable $fichier_extension that takes **$info_fichier** and looks at the extension in the file
5. then we check if the extension is in our array of allowed extensions 
    1. if it is we move the uploaded file to the folder we created for the session  and we return 1 
    2. if not it just returns 0

</aside>

### We call the function here:

```php
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
```

1. We create a variable called $extensions = with the array of the allowed extensions
2.  then we check if the file with the name image-added exits (normally we would use $_POST but it doesnt work for me )     
    1. if it does then we put that in a variable called $fichier 
3. and then  set a variable for the result called $res where we call the function with what it takes 
    
    <aside>
    ⌨️ at first i made a variable for each parameter but that messed up my code it wasnt working now it takes diff parts of ficher
    
    </aside>
    
4. then we check if res (meaning if the picture was saved ) 
    1. if it was we say that it was with echo 
    2. and if not then we say that too. 
    

**this form takes the uploaded picture and puts it in the drop down menu and should let you display it** 

```php
 
 <td>
        <div class = "form" id = "display-image">
            <form action="" method ="post">
               <?php
               echo dossier_en_select($nom_dossier);
               ?> 
            <input type = "submit" value = "Affiche Images" name ="Display_button"id ="display-button"></input>

            </form>
        </div>
    </td>
    </table>
    </div>
```

## How do we do this?

by enabling the function called  **dossier_en_select** that we developed in **fonction-ficher**  and we call above 

### **This is the function:**

```php
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
```

This function takes the parameters **$nom_dossier,$extensions**

1. we create the variable  **$fichier_dans_dossier** and use **scandir** that scans the directory  to look through **$nom_dossier**  and what its looked through is stored in **$fichier_dans_dossier**
2. then for each file in the folder as a file we take the info on that file and and put it in a variable called **$info_ficher** 
3. and if  in **$info_ficher**  the **extensions**  exists and its in the allowed array of extensions then we put in in the select as an option  

## Displaying the image

---

```php
 if (isset($_POST["file_selected"])){
        $image = $_POST["file_selected"];
        echo "image affiche"; 
        echo "<img src = '$nom_dossier/$image'/>";
    }
        else {
            echo "no image shown"; 
        }
      
    
```

here we check if our file exists 

Then we store what we get from it in image 

that we use to echo the path to the src so our pic is displayed 

## Bibliographie

---

https://www.w3schools.com/php/func_directory_scandir.asp

[https://www.php.net/manual/en/directoryiterator.getextension.php#:~:text=Another way of getting the,->getFilename()%2C PATHINFO_EXTENSION](https://www.php.net/manual/en/directoryiterator.getextension.php#:~:text=Another%20way%20of%20getting%20the,%2D%3EgetFilename()%2C%20PATHINFO_EXTENSION))%3B

[https://www.simplilearn.com/tutorials/php-tutorial/undefined-index-in-php#:~:text=You can fix it using,ignore it or fix it](https://www.simplilearn.com/tutorials/php-tutorial/undefined-index-in-php#:~:text=You%20can%20fix%20it%20using,ignore%20it%20or%20fix%20it).