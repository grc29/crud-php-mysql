<?php
  require('database.php');

  if(isset($_GET["show"]) && isset($_GET["id"])) {
    $id = $_GET["id"];

    try {
      $statement = $pdo->prepare(
        'SELECT * FROM users WHERE id = :id;'
      );
      $statement->execute(["id"=>$id]);
      $results = $statement->fetchAll(PDO::FETCH_OBJ);
    } catch(PDOException $e) {
      echo "<h4 style='color: red;'>".$e->getMessage()."</h4>";
    }
  } else {
    echo "<script>location.href='/'</script>";
    die();
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
      <a href="/">Go back</a>
  </body>
</html>