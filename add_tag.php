<?php
session_start();
require("conn.php");
require("Articles.php");

if (!isset($_SESSION['idUser'])) {
    header('Location: index.php');
    exit;
}

$database = new Database();
$db = $database->getConnection();
$articleObj = new Article($db);

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tagNames = trim($_POST['tag_names']);
    
    if (empty($tagNames)) {
        $message = "Tag names cannot be empty";
        $messageType = 'error';
    } else {
        $tags = array_map('trim', explode(',', $tagNames)); // Split tags by comma and trim any extra spaces
        $tagsAdded = 0;

        foreach ($tags as $tagName) {
            if (!empty($tagName)) {
                // Check if the tag already exists
                $stmt = $db->prepare("SELECT COUNT(*) FROM tags WHERE name = ?");
                $stmt->execute([$tagName]);
                $tagExists = $stmt->fetchColumn();

                if (!$tagExists) {
                    try {
                        // Insert new tag if it doesn't exist
                        $stmt = $db->prepare("INSERT INTO tags (name) VALUES (?)");
                        if ($stmt->execute([$tagName])) {
                            $tagsAdded++;
                        }
                    } catch (PDOException $e) {
                        $message = "Database error: " . $e->getMessage();
                        $messageType = 'error';
                        break; // Stop if there's an error
                    }
                }
            }
        }

        if ($tagsAdded > 0) {
            $message = "$tagsAdded tag(s) added successfully!";
            $messageType = 'success';
        } else {
            $message = "No new tags were added";
            $messageType = 'error';
        }
    }
}

$tags = $articleObj->getAllTags();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Tags - CarBlog</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="max-w-2xl mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-2xl font-bold mb-6">Add New Tags</h1>
            
            <?php if ($message): ?>
                <div class="mb-4 p-4 rounded-lg <?php echo $messageType === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST" class="space-y-4">
                <div>
                    <label for="tag_names" class="block text-gray-700 font-medium mb-2">Tag Names (comma separated)</label>
                    <input type="text" id="tag_names" name="tag_names" required
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div class="flex space-x-4">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                        Add Tags
                    </button>
                    <a href="blogger.php" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">
                        Cancel
                    </a>
                </div>
            </form>

            <!-- Display existing tags -->
            <div class="mt-8">
                <h2 class="text-xl font-bold mb-4">Existing Tags</h2>
                <div class="flex flex-wrap gap-2">
                    <?php foreach($tags as $tag): ?>
                        <span class="bg-gray-200 px-3 py-1 rounded-lg text-gray-700">
                            <?php echo htmlspecialchars($tag['name']); ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
