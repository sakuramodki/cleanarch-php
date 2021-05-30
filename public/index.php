<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ja">
<head>
    <title>リリース済みのアルバム一覧</title>
</head>
<body>
<h1>リリース済みのアルバム一覧</h1>
<?php
    $pdo = new \PDO('mysql:host=mysql;dbname=sample;port=3306', 'root', 'my-secret-pw');
    $statement = $pdo->query("select * from records");
    $data = $statement->fetchAll(\PDO::FETCH_ASSOC);

    foreach ($data as $record) {
?>
<a href="<?=$record['url']?>"><?=$record['title']?></a><br/>
<?php } ?>
</body>
</html>
