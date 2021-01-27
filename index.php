<?php

require(__DIR__ . '/vendor/autoload.php');

if (file_exists(__DIR__ . '/.env')){
    $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

$pdo = new PDO($_ENV['PDO_CONNECTION_STRING']);

// $pdo = new PDO('pgsql:host=ec2-54-208-233-243.compute-1.amazonaws.com;port=5432;
//                 dbname=d19pn8ipucoqlv;user=tudyzzncbblfmc;
//                 password=d91d99e2bfe09dc191bf99c4c85b14cd40cbba150423b2a108480af692bc5865');

$sql = "
select invoices.id, invoice_date, total, first_name, last_name
from invoices
inner join customers 
on invoices.customer_id = customers.id
";

$statement = $pdo->prepare($sql);
$statement->execute();
$invoices = $statement->fetchAll(PDO::FETCH_OBJ);

// var_dump($invoices);
?>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Total</th>
            <th>Customer</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($invoices as $invoice) : ?>
            <tr>
                <td>
                    <?php echo $invoice->id ?>
                </td>
                <td>
                    <?php echo $invoice->invoice_date ?>
                </td>
                <td>
                    <?php echo $invoice->total ?>
                </td>
                <td>
                    <?php echo "{$invoice->first_name} {$invoice->last_name}" ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>