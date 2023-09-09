<?php
require_once "Sql_Login.php";
require_once "cdn.php";
session_start();

// 檢查用戶是否已登入，否則導向登入頁面
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// 檢查是否有傳遞資料ID
if (!isset($_GET['id'])) {
    echo "缺少資料ID1";
    exit;
}

// 獲取要編輯的資料ID
$id = $_GET['id'];

// 檢查表單是否已提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 從POST請求中獲取修改後的值
    $title = $_POST['new_title'];
    $content = $_POST['new_content'];
    $user_id = $_POST['user_id'];
    $category_id = $_POST['category'];
    // 更新資料庫中的資料
    $sql = "UPDATE post SET title = :title, content = :content,category_id = :category_id WHERE user_id = :id AND id=:post_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':content', $content);
    $stmt->bindParam(':id', $user_id);
    $stmt->bindParam(':post_id', $id);
    $stmt->bindParam(':category_id', $category_id);
    if ($stmt->execute()) {
        echo "資料更新成功";
?>
        <script>
            window.location.href = "page_Select.php"
        </script>
<?php
    } else {
        echo "更新失敗";
    }
    exit;
}

// SQL撈編輯的資料
$sql = "SELECT * FROM post WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// 檢查是否有編輯的資料
if (!$result) {
    echo "找不到該資料";
    exit;
}

// 提取編輯前的值
$currenttitle = $result['title'];
$currentcontent = $result['content'];
$currentuserid = $result['user_id'];
$currentcategory = $result['category_id'];
?>

<!-- 編輯表單 -->
<div class="container">
    <h2 class="mt-5 text-primary">編輯資料</h2>
    <form method="POST" action="">
        <input type="hidden" name="user_id" value="<?php echo $currentuserid; ?>">
        <div class="mb-3">
            <label for="new_username" class="form-label">標題：</label>
            <input type="text" name="new_title" class="form-control" value="<?php echo $currenttitle; ?>">
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">類別</label>

            <select class="form-select w-25" name="category" id="category">
                <option value="1" <?php if ($currentcategory == 1)
                                        echo "selected"; ?>>國文</option>
                <option value="2" <?php if ($currentcategory == 2)
                                        echo "selected"; ?>>英文</option>
                <option value="3" <?php if ($currentcategory == 3)
                                        echo "selected"; ?>>數學</option>
                <option value="4" <?php if ($currentcategory == 4)
                                        echo "selected"; ?>>電子</option>
                <option value="5" <?php if ($currentcategory == 5)
                                        echo "selected"; ?>>軟體</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="new_email" class="form-label">內容：</label>

            <textarea id="editor" name="new_content">
        <?php echo $currentcontent; ?>
        </textarea>
        </div>
        <button type="submit" class="btn btn-primary">保存</button>
    </form>
</div>
<div id="container">

</div>
<script src="https://cdn.ckeditor.com/ckeditor5/38.1.0/super-build/ckeditor.js"></script>
<script>
    CKEDITOR.ClassicEditor.create(document.getElementById("editor"), {
        toolbar: {
            items: [
                'exportPDF', 'exportWord', '|',
                'findAndReplace', 'selectAll', '|',
                'heading', '|',
                'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
                'bulletedList', 'numberedList', 'todoList', '|',
                'outdent', 'indent', '|',
                'undo', 'redo',
                '-',
                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                'alignment', '|',
                'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
                'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                'textPartLanguage', '|',
                'sourceEditing'
            ],
            shouldNotGroupWhenFull: true
        },
        list: {
            properties: {
                styles: true,
                startIndex: true,
                reversed: true
            }
        },
        heading: {
            options: [{
                    model: 'paragraph',
                    title: 'Paragraph',
                    class: 'ck-heading_paragraph'
                },
                {
                    model: 'heading1',
                    view: 'h1',
                    title: 'Heading 1',
                    class: 'ck-heading_heading1'
                },
                {
                    model: 'heading2',
                    view: 'h2',
                    title: 'Heading 2',
                    class: 'ck-heading_heading2'
                },
                {
                    model: 'heading3',
                    view: 'h3',
                    title: 'Heading 3',
                    class: 'ck-heading_heading3'
                },
                {
                    model: 'heading4',
                    view: 'h4',
                    title: 'Heading 4',
                    class: 'ck-heading_heading4'
                },
                {
                    model: 'heading5',
                    view: 'h5',
                    title: 'Heading 5',
                    class: 'ck-heading_heading5'
                },
                {
                    model: 'heading6',
                    view: 'h6',
                    title: 'Heading 6',
                    class: 'ck-heading_heading6'
                }
            ]
        },
        placeholder: 'Welcome to CKEditor 5!',
        fontFamily: {
            options: [
                'default',
                'Arial, Helvetica, sans-serif',
                'Courier New, Courier, monospace',
                'Georgia, serif',
                'Lucida Sans Unicode, Lucida Grande, sans-serif',
                'Tahoma, Geneva, sans-serif',
                'Times New Roman, Times, serif',
                'Trebuchet MS, Helvetica, sans-serif',
                'Verdana, Geneva, sans-serif'
            ],
            supportAllValues: true
        },
        fontSize: {
            options: [10, 12, 14, 'default', 18, 20, 22],
            supportAllValues: true
        },
        htmlSupport: {
            allow: [{
                name: /.*/,
                attributes: true,
                classes: true,
                styles: true
            }]
        },
        htmlEmbed: {
            showPreviews: true
        },
        link: {
            decorators: {
                addTargetToExternalLinks: true,
                defaultProtocol: 'https://',
                toggleDownloadable: {
                    mode: 'manual',
                    label: 'Downloadable',
                    attributes: {
                        download: 'file'
                    }
                }
            }
        },
        mention: {
            feeds: [{
                marker: '@',
                feed: [
                    '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                    '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                    '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                    '@sugar', '@sweet', '@topping', '@wafer'
                ],
                minimumCharacters: 1
            }]
        },
        removePlugins: [
            'CKBox',
            'CKFinder',
            'EasyImage',
            'RealTimeCollaborativeComments',
            'RealTimeCollaborativeTrackChanges',
            'RealTimeCollaborativeRevisionHistory',
            'PresenceList',
            'Comments',
            'TrackChanges',
            'TrackChangesData',
            'RevisionHistory',
            'Pagination',
            'WProofreader',
            'MathType',
            'SlashCommand',
            'Template',
            'DocumentOutline',
            'FormatPainter',
            'TableOfContents'
        ]
    });
</script>