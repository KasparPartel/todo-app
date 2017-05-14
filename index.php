<?php

  require_once 'app/init.php';

  $itemsQuery = $db->prepare("
    SELECT id, name, done
    FROM items
    WHERE user = :user
  ");

  $itemsQuery->execute([
    'user' => $_SESSION['user_id']
  ]);

  $items = $itemsQuery->rowCount() ? $itemsQuery : [];

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDo List</title>
    <link rel="stylesheet" href="css/style.css">

    <style media="screen">
    .delete_button {
      display: inline-block;
      font-size: 0.8em;
      background-color: #ff461d;
      color: #363639;
      padding: 3px 6px;
      border: 0;
      opacity: 0.8;
      float: right;
    }

    .delete_button:hover {
      background-color: #ff461d;
    }
    </style>
  </head>
  <body>

    <div class="list">
      <h1 class="header">Tegevuskava</h1>

      <?php if(!empty($items)) : ?>
        <?php foreach($items as $item) : ?>
          <ul class="items">
            <li>
                <span class="item <?= $item['done'] ? ' done' : '' ?>"><?= $item['name']; ?></span>
              <?php if($item['done']) : ?>
                <a href="mark.php?as=notdone&item=<?= $item['id']; ?>" class="notdone_button">Mark as not done</a>
              <?php elseif(!$item['done']) : ?>
                <a href="mark.php?as=done&item=<?= $item['id']; ?>" class="done_button">Mark as done</a>
              <?php endif; ?>
              <a href="mark.php?as=delete&item=<?= $item['id']; ?>" class="delete_button">Delete</a>
            </li>
          </ul>
        <?php endforeach; ?>
      <?php else: ?>
        <p>Sul pole ühtegi tegevust plaanis.</p>
      <?php endif; ?>

      <form class='item-add' action="add.php" method="post">
        <input type="text" name="name" placeholder="Lisa uus tegevus" class="input" autocomplete="off" required>
        <input class="submit" type="submit" name="submit" value="Lisa">
      </form>

    </div>

  </body>
</html>
