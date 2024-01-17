<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "coffe_database";

$conn = mysqli_connect($servername, $username, $password, $database);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$error_message = ""; 




if (isset($_POST['send'])) {
    
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $number = mysqli_real_escape_string($conn, $_POST['number']);
   $guests = mysqli_real_escape_string($conn, $_POST['guests']);


   $checkQuery = "SELECT * FROM registration WHERE name='$name' AND number='$number' AND guests='$guests'";
   $result = mysqli_query($conn, $checkQuery);

   if (mysqli_num_rows($result) > 0) {
       $error_message = "Error: User with the same details already exists.";
   } else {
     
       $query = "INSERT INTO registration (name, number, guests) VALUES ('$name', '$number', '$guests')";

       if (mysqli_query($conn, $query)) {
           echo "Registration successful!";
       } else {
           echo "Error: " . mysqli_error($conn);
       }
   }
}






if (isset($_POST['order'])) {
   if (!isset($_SESSION['user_registered'])) {
      
      header('Location: registration.php?message=register_required');
      exit();
  }
   
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $coffeeType = mysqli_real_escape_string($conn, $_POST['coffee_type']);
   $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);


   $orderQuery = "INSERT INTO orders ( coffee_type, quantity) VALUES ( '$coffeeType', '$quantity')";

   if (mysqli_query($conn, $orderQuery)) {
       echo "Order placed successfully!";
   } else {
       echo "Error: " . mysqli_error($conn);
   }
}
  




mysqli_close($conn);


?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Coffee Shop Website</title>


   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

 
   <link rel="stylesheet" href="css/style.css">

</head>
<body>



<header class="header">

   <section class="flex">

      <a href="#home" class="logo"><img src="images/logo.png" alt=""></a>

      <nav class="navbar">
         <a href="#home">home</a>
         <a href="#about">about</a>
         <a href="#menu">menu</a>
         <a href="#gallery">gallery</a>
         <a href="#team">team</a>
         <a href="registration.php" target="_blank">registration</a>
         <a href="#contact">contact</a>
      </nav>

      <div id="menu-btn" class="fas fa-bars"></div>

   </section>

</header>



<div class="home-bg">

   <section class="home" id="home">

      <div class="content">
         <h3>coffee heaven</h3>
         <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ut officia, accusantium mollitia laudantium dolorum dolore.</p>
         <a href="#about" class="btn">about us</a>
      </div>

   </section>

</div>



<section class="about" id="about">

   <div class="image">
      <img src="images/about-img.svg" alt="">
   </div>

   <div class="content">
      <h3>A cup of coffee can complete your day</h3>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam suscipit sunt repellendus, dolorum recusandae placeat quae. Iste eaque aspernatur, animi deleniti voluptas, sunt molestias eveniet sint consectetur facere a ex.</p>
      <a href="#menu" class="btn">our menu</a>
   </div>

</section>



<section class="facility">

   <div class="heading">
      <img src="images/heading-img.png" alt="">
      <h3>our facility</h3>
   </div>

   <div class="box-container">

      <div class="box">
         <img src="images/icon-1.png" alt="">
         <h3>varieties of coffees</h3>
         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe, adipisci!</p>
      </div>

      <div class="box">
         <img src="images/icon-2.png" alt="">
         <h3>coffee beans</h3>
         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe, adipisci!</p>
      </div>

      <div class="box">
         <img src="images/icon-3.png" alt="">
         <h3>breakfast and sweets</h3>
         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe, adipisci!</p>
      </div>

      <div class="box">
         <img src="images/icon-4.png" alt="">
         <h3>read to go coffee</h3>
         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe, adipisci!</p>
      </div>

   </div>

</section>



<section class="menu" id="menu">

   <div class="heading">
      <img src="images/heading-img.png" alt="">
      <h3>popular menu</h3>
   </div>

   <div class="box-container">

      <div class="box">
         <img src="images/menu-1.png" alt="">
         <h3>love you coffee</h3>
         <form action="" method="POST">
            <input type="hidden" name="name" value="<?php echo $name; ?>">
            <input type="hidden" name="coffee_type" value="Love You Coffee">
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" required min="1" value="1">
            <input type="submit" name="order" value="Add to Cart" class="btn">
            
         </form>
      </div>

      <div class="box">
         <img src="images/menu-2.png" alt="">
         <h3>Cappuccino</h3>
         <form action="" method="POST">
            <input type="hidden" name="name" value="<?php echo $name; ?>">
            <input type="hidden" name="coffee_type" value="Capuchino">
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" required min="1" value="1">
            <input type="submit" name="order" value="Add to Cart" class="btn">
          
         </form>
      </div>

      <div class="box">
         <img src="images/menu-3.png" alt="">
         <h3>Mocha coffee</h3>
         <form action="" method="POST">
            <input type="hidden" name="name" value="<?php echo $name; ?>">
            <input type="hidden" name="coffee_type" value="Mocha Coffee">
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" required min="1" value="1">
            <input type="submit" name="order" value="Add to Cart" class="btn">
          
         </form>
      </div>

      <div class="box">
         <img src="images/menu-4.png" alt="">
         <h3>Frappuccino</h3>
         <form action="" method="POST">
            <input type="hidden" name="name" value="<?php echo $name; ?>">
            <input type="hidden" name="coffee_type" value="Frappuccino">
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" required min="1" value="1">
            <input type="submit" name="order" value="Add to Cart" class="btn">
            
         </form>
      </div>

      <div class="box">
         <img src="images/menu-5.png" alt="">
         <h3>black coffee</h3>
         <form action="" method="POST">
            <input type="hidden" name="name" value="<?php echo $name; ?>">
            <input type="hidden" name="coffee_type" value="Black Coffe">
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" required min="1" value="1">
            <input type="submit" name="order" value="Add to Cart" class="btn">
            
         </form>
      </div>

      <div class="box">
         <img src="images/menu-6.png" alt="">
         <h3>love heart coffee</h3>
         <form action="" method="POST">
            <input type="hidden" name="name" value="<?php echo $name; ?>">
            <input type="hidden" name="coffee_type" value="Love You Heart">
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" required min="1" value="1">
            <input type="submit" name="order" value="Add to Cart" class="btn">
           
         </form>
      </div>

   </div>

</section>



<section class="gallery" id="gallery">

   <div class="heading">
      <img src="images/heading-img.png" alt="">
      <h3>our gallery</h3>
   </div>

   <div class="box-container">
      <img src="images/gallery-1.webp" alt="">
      <img src="images/gallery-2.webp" alt="">
      <img src="images/gallery-3.webp" alt="">
      <img src="images/gallery-4.webp" alt="">
      <img src="images/gallery-5.webp" alt="">
      <img src="images/gallery-6.webp" alt="">
   </div>

</section>


<section class="team" id="team">

   <div class="heading">
      <img src="images/heading-img.png" alt="">
      <h3>our team</h3>
   </div>

   <div class="box-container">

      <div class="box">
         <img src="images/our-team-1.jpg" alt="">
         <h3>john deo</h3>
      </div>
      <div class="box">
         <img src="images/our-team-2.jpg" alt="">
         <h3>john deo</h3>
      </div>
      <div class="box">
         <img src="images/our-team-3.jpg" alt="">
         <h3>john deo</h3>
      </div>
      <div class="box">
         <img src="images/our-team-4.jpg" alt="">
         <h3>john deo</h3>
      </div>
      <div class="box">
         <img src="images/our-team-5.jpg" alt="">
         <h3>john deo</h3>
      </div>
      <div class="box">
         <img src="images/our-team-6.jpg" alt="">
         <h3>john deo</h3>
      </div>

   </div>

</section>



<section class="contact" id="contact">

   <div class="heading">
      <img src="images/heading-img.png" alt="coffe poto">
      <h3>contact us</h3>
   </div>
   <?php if ($error_message): ?>
    <div class="error-message">
        <p><?= $error_message; ?></p>
    </div>
<?php endif; ?>
   <div class="row">

      <div class="image">
         <img src="images/contact-img.svg" alt="">
      </div>

      <form action="" method="POST">
         <h3>book a table</h3>
         <input type="text" name="name" method="POST" required class="box" maxlength="20" placeholder="enter your name">
         <input type="number" name="number" method="POST" required class="box" maxlength="20" placeholder="enter your number" min="0" max="9999999999" >
         <input type="number" name="guests" method="POST" required class="box" maxlength="20" placeholder="how many guests" min="0" max="99">
         <input type="submit" name="send" value="send message" class="btn">
      </form>

   </div>



</section>


<section class="footer">

   <div class="box-container">

      <div class="box">
         <i class="fas fa-envelope"></i>
         <h3>our email</h3>
         <p>giorgi@gmail.com</p>
         <p>EuUni@gmail.com</p>
      </div>

      <div class="box">
         <i class="fas fa-clock"></i>
         <h3>opening hours</h3>
         <p>07:00am to 09:00pm</p>
      </div>

      <div class="box">
         <i class="fas fa-map-marker-alt"></i>
         <h3>shop location</h3>
         <p>surami, georgia  - 400104</p>
      </div>

      <div class="box">
         <i class="fas fa-phone"></i>
         <h3>our number</h3>
         <p>+123-456-7890</p>
         <p>+111-222-3333</p>
      </div>

   </div>

   <div class="credit"> &copy; copyright @ <?= date('Y'); ?> by <span>MCHEDLO</span> | all rights reserved! </div>

</section>

<script src="js/script.js"></script>

</body>
</html>                                                                                                              