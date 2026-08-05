<?php
// Target API URL
$apiUrl = 'http://localhost/filipino-cookbook-api-crisostomo/public/api/foods.php'; 

$foods = [];
$apiError = false;

// Attempt to fetch data from API
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 3);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($response && $httpCode === 200) {
    $data = json_decode($response, true);
    $foods = $data['data'] ?? $data ?? [];
}

// Fallback recipe dataset with full ingredients and instructions
if (empty($foods)) {
    $apiError = true;
    $foods = [
        [
            'id' => 1,
            'title' => 'Chicken Adobo',
            'category' => 'Main Dish',
            'description' => 'Savoury chicken stew cooked in soy sauce, vinegar, garlic, and bay leaves.',
            'origin' => 'Luzon',
            'cooking_time' => '45 mins',
            'ingredients' => [
                '1 kg chicken cut into serving pieces',
                '1/2 cup soy sauce',
                '1/3 cup white vinegar',
                '1 head garlic, crushed',
                '1 tsp whole black peppercorns',
                '3-4 dried bay leaves',
                '1 cup water',
                '2 tbsp cooking oil'
            ],
            'instructions' => [
                'In a large bowl, combine chicken, soy sauce, and crushed garlic. Marinate for at least 30 minutes.',
                'Heat oil in a pan over medium heat. Remove chicken from marinade and sear until lightly browned on all sides.',
                'Pour in the remaining marinade, water, bay leaves, and whole peppercorns. Bring to a boil.',
                'Lower heat, cover, and simmer for 25-30 minutes until chicken is tender.',
                'Pour in white vinegar and simmer uncovered for 10 minutes without stirring to cook off the raw acid taste.',
                'Serve hot over steamed white rice.'
            ]
        ],
        [
            'id' => 2,
            'title' => 'Pork Sinigang',
            'category' => 'Soup / Stew',
            'description' => 'Tamarind-based sour soup with pork ribs and fresh vegetables.',
            'origin' => 'Luzon',
            'cooking_time' => '50 mins',
            'ingredients' => [
                '1 kg pork belly or ribs, cut into chunks',
                '1 pack (40g) tamarind soup base (Sinigang mix)',
                '1 bunch kangkong (water spinach)',
                '1 cup radish, sliced',
                '1 cup taro (gabi), quartered',
                '1 cup eggplant, sliced',
                '1 cup string beans (sitaw), cut into 2-inch pieces',
                '2 medium tomatoes, quartered',
                '1 medium onion, quartered',
                '2 pieces long green chili (siling haba)',
                '8 cups water',
                'Fish sauce (patis) and salt to taste'
            ],
            'instructions' => [
                'In a large pot, bring water to a boil. Add onions, tomatoes, and pork pieces.',
                'Lower heat, cover, and simmer for 30–40 minutes until pork is tender.',
                'Add taro (gabi) and radish, then cook for another 8-10 minutes until softened.',
                'Stir in tamarind soup base mix and green chilis.',
                'Add eggplant and string beans, cooking for 3 minutes.',
                'Turn off heat, stir in kangkong leaves, cover for 2 minutes, then season with fish sauce to taste.'
            ]
        ],
        [
            'id' => 3,
            'title' => 'Halo-Halo',
            'category' => 'Dessert',
            'description' => 'Layered shaved ice dessert topped with sweet beans, jelly, leche flan, and ube.',
            'origin' => 'Nationwide',
            'cooking_time' => '15 mins',
            'ingredients' => [
                '2 cups shaved ice',
                '1/2 cup evaporated milk',
                '2 tbsp sweetened red beans',
                '2 tbsp sweet chickpeas (garbanzos)',
                '2 tbsp coconut gel (nata de coco)',
                '2 tbsp sugar palm fruit (kaong)',
                '2 tbsp sweetened saba bananas',
                '1 slice leche flan',
                '1 scoop ube halaya or ube ice cream',
                '1 tbsp toasted pinipig (optional)'
            ],
            'instructions' => [
                'In a tall glass or bowl, add 1-2 tablespoons of each sweet ingredient (beans, garbanzos, kaong, nata de coco, and bananas).',
                'Fill the glass to the top with finely shaved ice.',
                'Pour evaporated milk evenly over the shaved ice.',
                'Top with a slice of leche flan, a scoop of ube halaya or ube ice cream, and toasted pinipig.',
                'Serve immediately with a long spoon.'
            ]
        ]
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filipino Cookbook Client</title>
    <style>
        :root {
            --primary: #c0392b;
            --secondary: #f39c12;
            --bg: #f8f9fa;
            --card-bg: #ffffff;
            --text: #2c3e50;
            --border: #e2e8f0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg);
            color: var(--text);
            margin: 0;
            padding: 0;
        }

        header {
            background: linear-gradient(135deg, #c0392b, #8e44ad);
            color: white;
            padding: 2.5rem 1rem;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        header h1 {
            margin: 0;
            font-size: 2.5rem;
            font-weight: 700;
        }

        header p {
            margin-top: 0.5rem;
            opacity: 0.9;
            font-size: 1.1rem;
        }

        .container {
            max-width: 1100px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .status-alert {
            background-color: #fff3cd;
            color: #856404;
            padding: 0.75rem 1.25rem;
            border: 1px solid #ffeeba;
            border-radius: 8px;
            margin-bottom: 2rem;
            font-size: 0.95rem;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .card {
            background: var(--card-bg);
            border-radius: 12px;
            border: 1px solid var(--border);
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            padding: 1.5rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            cursor: pointer;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            border-color: var(--primary);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.75rem;
        }

        .card-title {
            font-size: 1.35rem;
            margin: 0;
            color: #1a202c;
        }

        .badge {
            background-color: #edf2f7;
            color: #4a5568;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.6rem;
            border-radius: 20px;
            text-transform: uppercase;
        }

        .card-body {
            font-size: 0.95rem;
            color: #4a5568;
            line-height: 1.5;
            margin-bottom: 1rem;
        }

        .card-footer {
            border-top: 1px solid var(--border);
            padding-top: 0.75rem;
            font-size: 0.85rem;
            color: #718096;
            display: flex;
            justify-content: space-between;
        }

        .click-hint {
            display: block;
            margin-top: 0.5rem;
            font-size: 0.8rem;
            color: var(--primary);
            font-weight: 600;
            text-align: right;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.6);
            overflow: auto;
            padding: 2rem 1rem;
            box-sizing: border-box;
        }

        .modal-content {
            background-color: #fff;
            margin: auto;
            padding: 2rem;
            border-radius: 12px;
            max-width: 650px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            position: relative;
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .close-btn {
            position: absolute;
            top: 1rem;
            right: 1.5rem;
            font-size: 1.8rem;
            font-weight: bold;
            color: #a0aec0;
            cursor: pointer;
        }

        .close-btn:hover {
            color: #2d3748;
        }

        .modal h2 {
            margin-top: 0;
            color: var(--primary);
        }

        .modal h3 {
            border-bottom: 2px solid var(--border);
            padding-bottom: 0.4rem;
            margin-top: 1.5rem;
            color: #2d3748;
        }

        .modal ul, .modal ol {
            padding-left: 1.2rem;
            line-height: 1.6;
        }

        .modal li {
            margin-bottom: 0.5rem;
            color: #4a5568;
        }

        footer {
            text-align: center;
            padding: 2rem 1rem;
            margin-top: 3rem;
            font-size: 0.9rem;
            color: #718096;
            border-top: 1px solid var(--border);
        }
    </style>
</head>
<body>

    <header>
        <h1>Filipino Cookbook</h1>
        <p>Explore traditional and modern Filipino dishes</p>
    </header>

    <div class="container">
        <?php if ($apiError): ?>
            <div class="status-alert">
                <span>⚠️ <strong>Notice:</strong> Displaying cached dish catalog with recipe procedures.</span>
            </div>
        <?php endif; ?>

        <div class="grid">
            <?php foreach ($foods as $index => $food): ?>
                <div class="card" onclick="openRecipe(<?= $index ?>)">
                    <div>
                        <div class="card-header">
                            <h2 class="card-title"><?= htmlspecialchars($food['title'] ?? 'Untitled Dish') ?></h2>
                            <span class="badge"><?= htmlspecialchars($food['category'] ?? 'General') ?></span>
                        </div>
                        <p class="card-body">
                            <?= htmlspecialchars($food['description'] ?? 'No description provided.') ?>
                        </p>
                    </div>
                    <div>
                        <div class="card-footer">
                            <span>📍 <?= htmlspecialchars($food['origin'] ?? 'Philippines') ?></span>
                            <span>⏱️ <?= htmlspecialchars($food['cooking_time'] ?? 'N/A') ?></span>
                        </div>
                        <span class="click-hint">Click for Ingredients & Recipe &rarr;</span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Recipe Modal -->
    <div id="recipeModal" class="modal" onclick="closeOnOutsideClick(event)">
        <div class="modal-content">
            <span class="close-btn" onclick="closeRecipe()">&times;</span>
            <h2 id="modalTitle">Dish Title</h2>
            <p id="modalCategory" style="color: #718096; font-size: 0.9rem; margin-top: -0.5rem;"></p>
            <p id="modalDescription" style="line-height: 1.5; color: #4a5568;"></p>

            <h3>🛒 Ingredients</h3>
            <ul id="modalIngredients"></ul>

            <h3>👨‍🍳 Cooking Instructions</h3>
            <ol id="modalInstructions"></ol>
        </div>
    </div>

    <footer>
        <p>Filipino Cookbook Client Application &bull; Powered by REST API Integration</p>
    </footer>

    <script>
        const recipes = <?= json_encode($foods) ?>;

        function openRecipe(index) {
            const recipe = recipes[index];
            if (!recipe) return;

            document.getElementById('modalTitle').textContent = recipe.title || 'Untitled Dish';
            document.getElementById('modalCategory').textContent = (recipe.category || 'General') + ' • ' + (recipe.origin || 'Philippines') + ' • ' + (recipe.cooking_time || '');
            document.getElementById('modalDescription').textContent = recipe.description || '';

            // Render Ingredients
            const ingList = document.getElementById('modalIngredients');
            ingList.innerHTML = '';
            if (recipe.ingredients && Array.isArray(recipe.ingredients)) {
                recipe.ingredients.forEach(item => {
                    const li = document.createElement('li');
                    li.textContent = item;
                    ingList.appendChild(li);
                });
            } else {
                ingList.innerHTML = '<li>Ingredients details available in main database export.</li>';
            }

            // Render Instructions
            const instList = document.getElementById('modalInstructions');
            instList.innerHTML = '';
            if (recipe.instructions && Array.isArray(recipe.instructions)) {
                recipe.instructions.forEach(step => {
                    const li = document.createElement('li');
                    li.textContent = step;
                    instList.appendChild(li);
                });
            } else {
                instList.innerHTML = '<li>Cooking steps available in main database export.</li>';
            }

            document.getElementById('recipeModal').style.display = 'block';
        }

        function closeRecipe() {
            document.getElementById('recipeModal').style.display = 'none';
        }

        function closeOnOutsideClick(event) {
            if (event.target.id === 'recipeModal') {
                closeRecipe();
            }
        }
    </script>

</body>
</html>