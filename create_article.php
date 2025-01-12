<?php
session_start();
if (!isset($_SESSION['idUser'])) {
    header('Location: index.php');
    exit();
}

require("conn.php");
require("Articles.php");
require("Themes.php");

$database = new Database();
$db = $database->getConnection();
$articleObj = new Article($db);
$themeObj = new Theme($db);

$themes = $themeObj->getAllThemes();
$tags = $articleObj->getAllTags();
// In your form processing:
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'] ?? '';
        $contents = $_POST['contents'] ?? '';
        $theme_id = $_POST['theme_id'] ?? '';
        $img = $_POST['img'] ?? null;
        
        // Process tags - filter out empty values and validate
        $selectedTags = [];
        if (!empty($_POST['selected_tags'])) {
            $selectedTags = array_filter(
                explode(',', $_POST['selected_tags']),
                function($tag) { return is_numeric($tag) && $tag > 0; }
            );
        }
    
        $article_id = $articleObj->createArticle(
            $title,
            $contents,
            $_SESSION['idUser'],
            $theme_id,
            $selectedTags,
            $img
        );
    
        if ($article_id) {
            header('Location: blogger.php');
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Article - Car Blog</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">Create New Article</h1>
        
        <form action="" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-lg p-6">
            <div class="mb-4">
                <label class="block text-gray-700 mb-2" for="title">Title</label>
                <input type="text" id="title" name="title" required
                       class="w-full px-4 py-2 border rounded-lg">
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2" for="contents">Content</label>
                <textarea id="contents" name="contents" required rows="6"
                          class="w-full px-4 py-2 border rounded-lg"></textarea>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2" for="theme_id">Theme</label>
                <select id="theme_id" name="theme_id" required
                        class="w-full px-4 py-2 border rounded-lg">
                    <?php foreach($themes as $theme): ?>
                        <option value="<?php echo $theme['theme_id']; ?>">
                            <?php echo htmlspecialchars($theme['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="tag-selection mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Tags</label>
                <div class="selected-tags flex flex-wrap gap-2 mb-2" id="selectedTags">
                </div>
                <div class="flex gap-2">
                    <select id="tagSelect" class="flex-1 px-4 py-2 border rounded-lg">
                        <option value="">Select tags...</option>
                        <?php foreach($articleObj->getAllTags() as $tag): ?>
                            <option value="<?php echo $tag['tag_id']; ?>"><?php echo htmlspecialchars($tag['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="button" onclick="addTag()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Add Tag
                    </button>
                </div>
                <input type="hidden" name="selected_tags" id="selectedTagsInput" value="">
            </div>

            <!-- Image URL Section -->
            <div class="mb-6">
                <label class="block text-gray-700 mb-2" for="img">Image URL</label>
                <input type="text" id="img" name="img" placeholder="Enter image URL"
                       class="w-full px-4 py-2 border rounded-lg">
            </div>
            
            <div class="flex justify-between">
                <a href="blogger.php" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Create Article
                </button>
            </div>
        </form>
    </div>

    <script>
        function addTag() {
    let tagSelect = document.getElementById('tagSelect');
    let selectedTagsContainer = document.getElementById('selectedTags');
    let selectedTagsInput = document.getElementById('selectedTagsInput');

    let selectedOption = tagSelect.options[tagSelect.selectedIndex];
    let tagValue = selectedOption.value;
    
    if (tagValue && tagValue.trim() !== '' && !document.getElementById(`tag-${tagValue}`)) {
        let tagText = selectedOption.text;
        
        let tagElement = document.createElement('div');
        tagElement.id = `tag-${tagValue}`;
        tagElement.className = 'bg-gray-200 px-3 py-1 rounded-lg';
        tagElement.innerHTML = `${tagText} <button type="button" onclick="removeTag(${tagValue})" class="ml-2 text-red-600">&times;</button>`;
        selectedTagsContainer.appendChild(tagElement);

        let selectedTags = Array.from(selectedTagsContainer.querySelectorAll('div'))
            .map(tag => tag.id.replace('tag-', ''))
            .filter(id => id && id.trim() !== '');
            
        selectedTagsInput.value = selectedTags.join(',');
    }
}

        function removeTag(tagId) {
            let tagElement = document.getElementById(`tag-${tagId}`);
            if (tagElement) {
                tagElement.remove();

                let selectedTags = Array.from(document.querySelectorAll('#selectedTags div')).map(tag => tag.id.replace('tag-', ''));
                document.getElementById('selectedTagsInput').value = selectedTags.join(',');
            }
        }

    </script>
</body>
</html>
