<?php 
   $error=[];
   $name="";
   $price="";
   $note="";

   
   if($_SERVER["REQUEST_METHOD"] == "POST"){
      // echo var_dump($_FILES['img']);
      
   
   //1-Create Connection
   require("connection.php");
   //2-Prepare Statement
   $name = $_REQUEST["name"];
   $price = $_REQUEST["price"];
   $note = $_REQUEST["note"];
   //Validation
   
   if(!$name){
      $error[] = "Name is required";
   }
   if(!$price){
      $error[] = "Price is required";
   }
   if(empty($error)){
      //Import Globle
      require_once("globle_Function.php");
      //Upload pic
      $img=$_FILES['img'] ?? null;
      $imgPath="";
      if($img){
         // $imgPath="img/".randomString(8).$img['name'];
         $imgPath="img/".date("YYDDhhmm").$img['name'];
         move_uploaded_file($img["tmp_name"],$imgPath);
         
      }
      

      $statement = $pdo->prepare("INSERT INTO product(name,price,note,img) VALUES(:name,:price,:note,:img)");

      $statement->bindValue(':name',$name);
      $statement->bindValue(':price',$price);
      $statement->bindValue(':note',$note);
      $statement->bindValue(':img',$imgPath);
      
      //3-Execute
      $statement->execute();
   
      header("Location: index.php");
      //4-Fetch Data
      // $productList = $statement->fetchAll(PDO::FETCH_ASSOC);
      }
   }

  
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>

   <div class="container">
      <h1>Add New Product</h1>
      <!-- show message error -->
      <?php require('error.php')?>
      
      <form action="" method="post" enctype="multipart/form-data">
         <div class="mb-3 row">
            <label for="proName" class="form-label col-md-3">Product Name </label>
            <div class="col-md-9">
               <input value="<?php echo $name ?>" type="text" id="proName" class="form-control" name="name" />
            </div>
         </div>
         <div class="mb-3 row">
            <label for="proPrice" class="form-label col-md-3">Price </label>
            <div class="col-md-9">
               <input value="<?php echo $price ?>" type="number" id="proPrice" class="form-control" name="price" />
            </div>
         </div>
         <div class="mb-3 row">
            <label for="proNote" class="form-label col-md-3">Note </label>
            <div class="col-md-9">
               <input value="<?php echo $note ?>" type="text" id="proNote" class="form-control" name="note" />
            </div>
         </div>
         <div class="mb-3 row">
            <label for="proImg" class="form-label col-md-3">Photo </label>
            <div class="col-md-9">
               <input type="file" id="proImg" class="form-control" name="img" />
            </div>
         </div>
         <button class="btn btn-success" style="float:right;">Save</button>
      </form>
   </div>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>