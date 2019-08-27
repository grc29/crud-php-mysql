<?php
  require('database.php');

  // Create new user
  if($_GET["show"] == "all") {
    try {
      $statement = $pdo->prepare(
        'SELECT * FROM users;'
      );
      $statement->execute();
      $results = $statement->fetchAll(PDO::FETCH_OBJ);

      echo "Read from table users<br>";

    } catch(PDOException $e) {
      echo "<h4 style='color: red;'>".$e->getMessage()."</h4>";
    }
  } else if($_GET["show"] == "one" && isset($_GET["id"])) {
    $id = $_GET["id"];

    try {
      $statement = $pdo->prepare(
        'SELECT * FROM users WHERE id = :id;'
      );
      $statement->execute(["id"=>$id]);
      $results = $statement->fetchAll(PDO::FETCH_OBJ);

      echo "Read from table users<br>";
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
    <table>
      <tr>
        <th>id</th>
        <th>first_name</th>
        <th>last_name</th>
        <th>age</th>
        <th>edit</th>
        <th>delete</th>
      </tr>
      <?php foreach($results as $user) { ?>
        <tr>
          <td><?php echo $user->id; ?></td>
          <td><?php echo $user->first_name; ?></td>
          <td><?php echo $user->last_name; ?></td>
          <td><?php echo $user->age; ?></td>
          <td><a href="/update.php?id=<?php echo $user->id ?>">Edit</a></td>
          <td><a href="/delete.php?id=<?php echo $user->id ?>" onClick="confirm()">Delete</a></td>
        </tr>
      <?php } ?>
    </table>
  </body>
</html>