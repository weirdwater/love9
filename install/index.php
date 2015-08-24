<?php
require '../includes/settings.php';
$connectionFail = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $db = new PDO('mysql:host='.DB_HOST.';port='.'7777'.';dbname='.DB_NAME, DB_USER, DB_PASS);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, True);
        $db->exec('SET NAMES \'utf8\'');
    }
    catch (PDOException $e) {
        $connectionFail = true;
    }

    if ($_POST['insert'] == 'basic' || $_POST['insert'] == 'dump') {
        require $_POST['insert'] . '.sql.php';
    }
}



?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Install Love9</title>
    <link rel="stylesheet" href="install.css"/>
</head>
<body>
<section class="container">
    <h1>Love<sup>9</sup> SQL Generator</h1>
<?php if ($_SERVER['REQUEST_METHOD'] != 'POST'): ?>
    <p>This tool will help you import the correct sql into your database. It will generate a string of sql that you can import. The tool needs your database's credentials to generate this sql, mainly so the database names match up.</p>
    <p>To make sure that the installer has the right credentials view the table below. If the credentials are incorrect, please correct them in <code>/includes/settings.php</code>.</p>
    <h4>Current database settings:</h4>
    <table cellspacing="0" cellpadding="0">
        <tr>
            <td>Host:</td>
            <td><?= DB_HOST ?></td>
        </tr>
        <tr>
            <td>Port:</td>
            <td><?= DB_PORT ?></td>
        </tr>
        <tr>
            <td>Database name:</td>
            <td><?= DB_NAME ?></td>
        </tr>
        <tr>
            <td>Username:</td>
            <td><?= DB_USER ?></td>
        </tr>
        <tr>
            <td>Password:</td>
            <td><?= DB_PASS ?></td>
        </tr>
    </table>
    <h1>Generator preferences:</h1>
    <form action="<?= BASE_URL ?>install/" method="post">
        <h4>Insert</h4>
        <p>If you want to use Love<sup>9</sup> yourself, choose <code>Basic</code>. It will just come with the data you'll need to get your users going. Which includes basic hair & eye colors and a list of states/countries.</p>
        <p>If you want to see how a used version of Love<sup>9</sup> looks like, select <code>All</code>. It includes 32 personas and their actions.</p>
        <div class="form-group">
            <label for="insertAll">
                <input type="radio" name="insert" value="dump" id="insertAll"/> <span>All</span> -  Data dump of our test version.
            </label>
            <label for="insertBasic">
                <input type="radio" name="insert" value="basic" id="insertBasic" checked/> <span>Basic</span> -  Just what's needed to get you started.
            </label>
        </div>
        <div class="form-group">
            <input type="submit" class="submit" value="Install"/>
        </div>
    </form>
<?php else: ?>
    <?php if ($connectionFail): ?>
        <div class="alert danger"><span>Couldn't connect to the database:</span> Please check your database credentials in <code>/includes/settings.php</code> or that the database is running.</div>
    <?php endif ?>
    <?php if (!$connectionFail): ?>
        <div class="alert success"><span>Connected to the database!</span> The supplied credentials work on your database!</div>
    <?php endif ?>
    <h4>Generated SQL</h4>
    <p>Import the following SQL into your database.</p>
    <div class="alert warning"><span>Please don't forget:</span> Delete the <code>/install</code> directory before deployment.</div>
    <div class="sql-container">
        <textarea readonly >
            <?= $sql ?>
        </textarea>
    </div>
<?php endif ?>
</section>
</body>
</html>