<!DOCTYPE html>
<html>

<head>
    <!-- 引入 CKEditor 5 的樣式表 -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@27.4.0/build/ckeditor.css">
</head>

<body>
    <textarea name="myTextarea" id="myTextarea"></textarea>
    <script src="ckeditor.js"></script>

    <script>
        window.onload = function () {
            // 初始化 CKEditor 5
            ClassicEditor
                .create(document.querySelector('#myTextarea'), {
                    // 這裡可以設定你選擇的插件和其他配置
                    // 例如：toolbar, plugins, 以及其他選項
                    // toolbar: ['heading', '|', 'bold', 'italic', 'link']
                })
                .then(editor => {
                    console.log('CKEditor 5 初始化成功', editor);
                })
                .catch(error => {
                    console.error('CKEditor 5 初始化失敗', error);
                });
        };
    </script>
</body>

</html>