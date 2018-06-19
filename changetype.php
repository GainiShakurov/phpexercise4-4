<form action="index.php?tablename=<?php echo $_GET['tablename'] ?>" method="POST">
    <input type="hidden" name="currentName" value="<?php echo $_GET['currentName'] ?>">
    Изменить тип на:
    <p>
        <select name="dataType">
            <option disabled>Выберите тип</option>
            <option value="int" <?php if ($_GET['currentType'] == 'int') echo "selected"; ?>>INT</option>
            <option value="varchar(50)" <?php if ($_GET['currentType'] == 'varchar(50)') echo "selected"; ?> >VARCHAR(50)</option>
            <option value="timestamp" <?php if ($_GET['currentType'] == 'timestamp') echo "selected"; ?>>TIMESTAMP</option>
            <option value="float" <?php if ($_GET['currentType'] == 'float') echo "selected"; ?>>FLOAT</option>
        </select>
    </p>
    <p><input type="submit" value="Изменить"/></p>
</form>
