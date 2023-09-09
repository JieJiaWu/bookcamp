<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">


<?php
require_once "Sql_Login.php";
require_once "cdn.php";
?>

<?php
session_start();
if (isset($_SESSION['username'], $_SESSION['id'])) {
    $username = $_SESSION['username'];
    $id = $_SESSION['id'];
} else {
?>
    <script>
        window.location.href = "login.php"
    </script>
<?php
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/css.css">
    <style>
        .no-resize {
            resize: none;
        }
    </style>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"> -->


</head>


<body>
    <div class="container">
        <div class="sidebar">
            <h4 class="mb-4 text-dark">
                <i class="fa-brands fa-gofore fs-3 mt-3 ps-4" style="color:red"></i>
                FORUM MANAGE
            </h4>
            <ul class="nav flex-column">
                <li class="nav-item ">
                    <a class="nav-link" href="login.php ">
                        Front Page
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="Sql_Select.php">
                        Member
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="page_insert.php">
                        New Page
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="page_Select.php">
                        PManage

                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php?logout=true">
                        Logout
                    </a>
                </li>
                <li class="nav-item">
                    <a class="">
                        <?php
                        if (isset($_SESSION['username'], $_SESSION['id'])) {
                            $username = $_SESSION['username'];
                            $id = $_SESSION['id'];
                        ?><a class="animated-text ms-3">
                                <?php echo "歡迎：" . $username . "#" . $id . "<br>"; ?>
                            </a>
                        <?php } else {
                            echo "未登入";
                        }
                        ?>
                    </a>
                </li>

            </ul>
        </div>
        <div class="content">
            <!-- 內容區 -->

            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <form action="insert.php" method="post">
                            <div class="mb-3">
                                <label for="title" class="form-label pt-3">標題</label>
                                <input type="text" class="form-control w-25" id="title" name="title">
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label pt-3">姓名</label>
                                <input type="hidden" class="form-control w-25" id="username" name="id" value="<?= $id ?>" readonly>
                                <!-- <?= $id ?> -->
                                <input type="text" class="form-control w-25" id="username" name="" value="<?php echo $username ?>" readonly>
                                <!-- <? ?> -->
                            </div>
                            <div class="mb-3">
                                <label for="category" class="form-label">主題</label>
                                <select class="form-select w-25" name="category" id="category">
                                    <option value="1">國文</option>
                                    <option value="2">英文</option>
                                    <option value="3">數學</option>
                                    <option value="4">電子</option>
                                    <option value="5">軟體</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control no-resize" name="content" rows="8" id="editor">123</textarea>
                            </div>
                            <button type="button" class="btn btn-primary" onclick="confirmSubmit()">新增</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
    <script src="https://unpkg.com/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

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
    <script>
        function confirmSubmit() {
            Swal.fire({
                title: '確認',
                text: '確定要新增嗎？',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: '確定',
                cancelButtonText: '取消'
            }).then((result) => {
                if (result.isConfirmed) {
                    // 使用者點擊了確定按鈕，手動提交表單
                    document.querySelector('form').submit();
                }
            });
        }
    </script>
</body>

</html>