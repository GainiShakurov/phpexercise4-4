<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Список дел</title>
</head>
<style>
    table {
        border-spacing: 0;
        border-collapse: collapse;
    }

    table td, table th {
        border: 1px solid #ccc;
        padding: 5px;
    }

    table th {
        background: #eee;
    }
</style>
<body>

<?php
require "config.php";

$createTableProductQuery = "CREATE TABLE IF NOT EXISTS products (
                id int(11) AUTO_INCREMENT PRIMARY KEY,
                title varchar(30) NOT NULL,
                description varchar(200) NOT NULL)";

$createTableProduct = $connect->exec($createTableProductQuery);

$createTableThingsQuery = "CREATE TABLE IF NOT EXISTS things (
                id int(11) AUTO_INCREMENT PRIMARY KEY,
                title varchar(30) NOT NULL,
                date TIMESTAMP NOT NULL)";

$createTableThings = $connect->exec($createTableThingsQuery);

if (($createTableProduct !== false) and ($createTableThings !== false)) {
    echo "Таблицы созданы<br/>";
} else {
    echo "Ошибка при создании таблиц<br/>";
}

$sql = "SHOW TABLES";

$statement = $connect->prepare($sql);
$statement->execute();
$tables = $statement->fetchAll(PDO::FETCH_NUM);

echo '<ul>';
foreach ($tables as $table) {
    echo '<li><a href="?tablename=' . $table[0] . '">' . $table[0] . '</a></li>';
}
echo '</ul>';

if (!empty($_GET['tablename'])) {

    if (!empty($_GET['delete'])) {
        $q = $connect->prepare('ALTER TABLE '. addslashes($_GET['tablename']) .' DROP COLUMN ' . addslashes($_GET['delete']));
        $q->execute();
        $table_fields = $q->fetchAll();
    }

    if (!empty($_POST['name'])) {
        $query = $connect->prepare('ALTER TABLE '. addslashes($_GET['tablename']) .' CHANGE ' . addslashes($_POST['currentName']) .' '. addslashes($_POST['name']). ' VARCHAR(50)');
        $query->execute();
    }

    if (!empty($_POST['dataType'])) {
        $query = $connect->prepare('ALTER TABLE '. addslashes($_GET['tablename']) .' MODIFY ' . addslashes($_POST['currentName']) .' '. addslashes(strtoupper($_POST['dataType'])). ' NOT NULL');
        $query->execute();
    }

    $q = $connect->prepare("DESCRIBE " . addslashes($_GET['tablename']));
    $q->execute();
    $table_fields = $q->fetchAll();

    echo '<table style="border: 1px;">';
    echo '<thead><th>Поле</th><th>Тип данных</th><th>Удалить поле</th><th>Изменить название</th><th>Изменить тип</th></thead>';
    echo '<tbody>';

    foreach ($table_fields as $table_field) {
        echo '<tr>';

        echo '<td>';
        echo $table_field['Field'];
        echo '</td>';

        echo '<td>';
        echo $table_field['Type'];
        echo '</td>';

        echo '<td>';
        echo '<a href="?tablename=' . addslashes($_GET['tablename']) . '&delete=' . $table_field['Field'] . '">Удалить поле</a>';
        echo '</td>';
        echo '<td>';
        echo '<a href="changename.php?currentName=' . $table_field['Field'] . '&tablename=' . addslashes($_GET['tablename']) . '">Изменить название</a>';
        echo '</td>';
        echo '<td>';
        echo '<a href="changetype.php?currentType=' . $table_field['Type'] . '&tablename=' . addslashes($_GET['tablename']) . '&currentName=' . $table_field['Field'] . '">Изменить тип</a>';
        echo '</td>';

        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';

if (!empty($_GET['title'])) {
    $changeTitleQuery = 'ALTER TABLE ' . addslashes($_GET['tablename']) . ' CHANGE title newtitle VARCHAR(50);';
    $changeTitle = $connect->prepare($changeTitleQuery);
    $changeTitle->execute();
    $table_fields = $q->fetchAll();
}

}

?>
</body>
</html>
