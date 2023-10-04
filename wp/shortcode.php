<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>
        form
    </h1>
    <form action="/" method="get">
        <label for="name">Name</label>
        <input type="text" name="name" id="name">
        <label for="email">Email</label>
        <input type="email" name="email" id="email">
    </form>
    <?php
    $name =$_GET['name'];   
    $email = $_GET['email'];
    echo "Hi $name <br> Your Email address is $email";
    ?>

</body>
</html>