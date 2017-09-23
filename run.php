<pre  size="2">Please fill specify invoice file. Simple name is <b>invoice_o321</b></pre>



    <form action="run.php" method="post" style="font-size: 12px; font-family: 'Lucida Console'">
        Invoice:
        <select name="invoice">
            <option value="gndex_inv0000001">Invoice #1</option>
            <option value="gndex_inv0000002">Invoice #2</option>
            <option value="gndex_inv0000003">Invoice #3</option>
        </select>

        <input type="submit" value="Generate" style="font-family: 'Lucida Console'; font-size: 12px">
    </form>

<?php


if (isset($_POST['invoice'])) {

    $command = escapeshellcmd('python3 generate.py invoices/' . $_POST['invoice'] . '.json');
    $output = shell_exec($command);

//    $inv = fopen($_POST['filename'].'.json', 'r') or die('Unable to open file!');

    echo "<b>Invoice: ".$_POST['invoice']."</b><br>";
    echo "<img src=\"https://chart.googleapis.com/chart?chs=400x400&chld=Q&cht=qr&chl=".$output."\">";
    echo "<br><br>Your <a href='" . $output . "'>link</a>";

    echo "<hr style='color: grey'>";
//    echo "<pre style='color: grey'>" . fread($inv, filesize($_POST['filename'].'.json')) . "</pre><br>";
//    fclose($inv);
}

?>