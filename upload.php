<?php
    if(isset($_POST['submit']) && isset($_FILES['my_image'])){
        $conn = mysqli_connect("localhost", "root", "", "greentea_db");
        
        $img_name = $_FILES['my_image']['name'];
        $img_size = $_FILES['my_image']['size'];
        $tmp_name = $_FILES['my_image']['tmp_name'];
        $error = $_FILES['my_image']['error'];

        if($error === 0){
            if($img_size > 1250000){
                $em = "Sorry, your file is too large.";
                header("Location: upload.php?error=$em");
            }else{
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);

                $allowed_exs = array("jpg", "jpeg", "png", "jfif", "webp");

                if(in_array($img_ex_lc, $allowed_exs)){
                    $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
                    $img_upload_path = 'image/'.$new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);

                    // Insert into Database
                    $sql = "INSERT INTO products(image) VALUES('$new_img_name')";
                    mysqli_query($conn, $sql);
                    header("Location: upload.php?success=Image uploaded successfully");
                }else{
                    $em = "You can't upload files of this type";
                    header("Location: upload.php?error=$em");
                }
            }
        }else{
            $em = "unknown error occurred!";
            header("Location: upload.php?error=$em");
        }
      
    }
?>