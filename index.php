<?php
// Fetch data from your API
$foods_json = @file_get_contents("http://localhost:8001/api/foods");
$foods = $foods_json ? json_decode($foods_json, true) : [];
?>

<!DOCTYPE html>
<html>
<head>
  <title>Filipino Cookbook Client</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 20px; background-color: #f9f9f9; }
    h1 { color: #333; }
    .food { background: white; padding: 15px; margin-bottom: 15px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    .food h2 { margin: 0; color: #444; }
    .meta { color: #777; font-size: 14px; }
  </style>
</head>
<body>
  <h1>Filipino Foods</h1>

  <?php if (!empty($foods)): ?>
    <?php foreach ($foods as $food): ?>
      <div class="food">
        <h2><?php echo htmlspecialchars($food['food_name']); ?></h2>
        <p class="meta">
          Category: <?php echo htmlspecialchars($food['category_name']); ?> |
          Origin: <?php echo htmlspecialchars($food['origin_name']); ?>
        </p>
        <p><?php echo htmlspecialchars($food['instructions']); ?></p>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <p>No foods found or API unavailable.</p>
  <?php endif; ?>

</body>
</html>
