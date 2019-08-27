<?php
  require('database.php');

  // Handles POST Request
  if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_GET["id"]) && $_POST["_method"] == "PUT") {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $age = $_POST["age"];
    $id = $_GET["id"];
    
    try {
      $statement = $pdo->prepare(
        'UPDATE users SET first_name = :first_name, last_name = :last_name, age = :age where id = :id;'
      );

      $statement->execute(["first_name"=>$first_name, "last_name"=>$last_name, "age"=>$age]);
      echo "Updated your info.";

    } catch(PDOException $e) {
      echo "<h4 style='color:red;'>".$e->getMessage()."</h4>";
    }

  }

  // Handles GET Request
  if(isset($_GET["id"])) {
    $id = $_GET["id"];
    try {
      $statement = $pdo->prepare(
        'SELECT * FROM users where id = :id;'
      );

      $statement->execute(["id"=>$id]);
      $results = $statement->fetchAll(PDO::FETCH_OBJ);

    } catch(PDOException $e) {
      echo "<h4 style='color: red;'>".$e->getMessage()."</h4>";
    }
  }
?>
<html>
  <head>
    <title>Simple CRUD</title>
  </head>
  <body>
    <form action="/update.php?id=<?php echo $results[0]->id ?>" method="POST">
      <input type="hidden" name="_method" value="PUT">
      <label for="first_name">First Name</label><br>
      <input type="text" name="first_name" value="<?php echo $results[0]->first_name?>"><br>
      <label for="last_name">Last Name</label><br>
      <input type="text" name="last_name" value="<?php echo $results[0]->last_name?>"><br>
      <label for="age">Age</label><br>
      <input type="text" name="age" value="<?php echo $results[0]->age?>"><br>
      <button type="submit">Save</button>
    </form>
  </body>
</html>