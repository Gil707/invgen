<pre  size="2">Please fill specify invoice file. Simple name is <b>invoice_o321</b></pre>



    <form action="run.php" method="post" style="font-size: 12px; font-family: 'Lucida Console'">
        Invoice: <input type="text" name="filename"><br><br>
        <input type="submit" value="Generate" style="font-family: 'Lucida Console'; font-size: 12px">
    </form>

<?php


if (isset($_POST['filename'])) {

    $command = escapeshellcmd('python3 generate.py ' . $_POST['filename'] . '.json');
    $output = shell_exec($command);

    $inv = fopen($_POST['filename'].'.json', 'r') or die('Unable to open file!');
    echo "<hr>";
    echo "<pre>" . fread($inv, filesize($_POST['filename'].'.json')) . "</pre><br>";
    fclose($inv);

    echo "Your <a href='" . $output . "'>link</a>";
}

?>