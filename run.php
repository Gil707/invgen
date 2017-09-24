<pre  size="2">Please fill specify invoice data.</b></pre>


   <h3>Generate from template</h3>
    <form action="run.php" method="post" style="font-size: 12px; font-family: 'Lucida Console'">
        Invoice:
        <select name="invoice">
            <option value="gndex_inv0000001">Invoice #1</option>
            <option value="gndex_inv0000002">Invoice #2</option>
            <option value="gndex_inv0000003">Invoice #3</option>
        </select>
        <input type="submit" value="Generate" style="font-family: 'Lucida Console'; font-size: 12px">
    </form>
<hr>
<h3>Generate from selected products</h3>

    <form action="run.php" method="post" style="font-size: 12px; font-family: 'Lucida Console'">
    Products:<br>
        <input type="checkbox" name="products[]" value="Acorn Building"><b>Acorn Building</b>&nbsp Цена: 10 (руб)<br>
        <input type="checkbox" name="products[]" value="Brown Hall"><b>Brown Hall</b>&nbsp Цена: 67 (руб)<br>
        <input type="checkbox" name="products[]" value="Carnegie Complex"><b>Carnegie Complex</b>&nbsp Цена: 2 (руб)<br>
        <input type="checkbox" name="products[]" value="Drake Commons"><b>Drake Commons</b>&nbsp Цена: 8 (руб)<br>
        <input type="checkbox" name="products[]" value="Elliot House"><b>Elliot House</b>&nbsp Цена: 15 (руб)<br>

    <input type="submit" value="Generate" style="font-family: 'Lucida Console'; font-size: 12px">
</form>

<?php


if (isset($_POST['invoice'])) {

    $command = escapeshellcmd('python3 generate.py invoices/' . $_POST['invoice'] . '.json');
    $output = shell_exec($command);

    $inv = fopen('invoices/'.$_POST['invoice'].'.json', 'r') or die('Unable to open file!');

    echo "<b>Invoice: " . $_POST['invoice'] . "</b>";
    echo "<h3>Your result:</h3><img src=\"https://chart.googleapis.com/chart?chs=400x400&chld=Q&cht=qr&chl=" . $output . "\" align=\"left\">";
    echo "<br>Your <a href='" . $output . "' target='_blank'>link</a>";
    echo "<br><code>".fread($inv, filesize('invoices/'.$_POST['invoice'].'.json'))."</code>";
    fclose($inv);

}

if (isset($_POST['products'])) {

    $products = $_POST['products'];
    $prices = [
            'Acorn Building' => '10',
            'Brown Hall' => '67',
            'Carnegie Complex' => '2',
            'Drake Commons' => '8',
            'Elliot House' => '15',
    ];

    echo "Your buy <ul>";
    foreach ($products as $product) {
        echo "<li><code>" . $product . " (" . $prices[$product] . " RUB)</code>";
    };


    $N = count($products);

    $ful_pr = array();

    for($i=0; $i < $N; $i++)
    {
        array_push($ful_pr, [
            'label' => $products[$i],
            'quantity' => '1',
            'price' => $prices[$products[$i]]
        ]);
    }

    $arr = [
        'to' => 'gurondex-cny',
        'to_label' => 'GuronDEX',
        'currency' => 'RUBLE',
        'memo' => 'Invoice #0000001',
        'fee_id' => '1.3.1325',
        'line_items' =>
//            [
               $ful_pr,
//            [
//            'label' => 'T-shirt (M) color:yellow #532',
//            'quantity' => 2,
//            'price' => '1.00'
//            ],
//            [
//            'label' => 'Glasses (aviator)black SKU#3548',
//            'quantity' => 1,
//            'price' => '0.50'
//            ]
//            ],
        'note' => 'Payment for order #1',
        'callback' => 'https://market.gurondex.io/complete'
    ];

    $fp = fopen('results.json', 'w');
    fwrite($fp, json_encode($arr));
    fclose($fp);

    $command2 = escapeshellcmd('python3 generate.py results.json');
    $output2 = shell_exec($command2);


    echo "<h3>Your result:</h3><img src=\"https://chart.googleapis.com/chart?chs=400x400&chld=Q&cht=qr&chl=" . $output2 . "\" align=\"left\"><br>";

    echo "<br>Your <a href='" . $output2 . "' target='_blank'>link</a>";

    echo "<br><code>".json_encode($arr)."</code>";

}
?>