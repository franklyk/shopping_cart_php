<?php
    ob_start();
    session_start();
    require 'connection.php';
?>

<html lang="pt-br">
    <head>
        <meta charset="utf8">
        <title>Carrinho de Compras</title>
        <link rel="stylesheet" href="css/cart.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@400;700&display=swap" rel="stylesheet">
    </head>

    <body>
        <div class="result"></div>
        <?php
        $status = 1;
        $Read = $pdo->prepare("SELECT product_id, product_cover, product_name, product_headline, product_link, product_price, product_stock, product_status FROM products WHERE product_status = :status");
        $Read->bindValue(':status', $status);
        $Read->execute();


        $Reader = $pdo->prepare("SELECT product_id, product_cover, product_name, product_headline, product_link, product_price, product_stock, product_status FROM products WHERE product_status = :status");
        $Reader->bindValue(':status', $status);
        $Reader->execute();
        

        foreach($Reader as $Vle){

            $Prod_id = strip_tags($Vle['product_id']);
            $prod_cover = strip_tags($Vle['product_cover']);
            $Prod_name = strip_tags($Vle['product_name']);
     
            $session = strip_tags($_SESSION['cart']);
            $Cart = $pdo->prepare("SELECT cart_id, cart_value, cart_session, cart_quantity, cart_status, product_id, cart_total, product_stock, product_cover, product_name FROM cart_temporary WHERE cart_session = :session AND cart_status = :stat");
            $Cart->bindValue(':session', $_SESSION['cart']);
            $Cart->bindValue(':stat', 1);
            $Cart->execute();
        }
            $Count = $Cart->rowCount();
            // var_dump($Count);
        ?>

        <article class="container_top">
            <p class="container_top_paragraph" id="counter"><a href="cart.php"><span class="fa fa-shopping-cart"></span><span class="qtd"> <?= $Count ?> </span></a></p>
        </article>

        <article class="container_main">
            <?php
                foreach($Read as $Show):
            ?>
		
            <section class="container_products">
                <img src="images/<?= strip_tags($Show['product_cover']) ?>" title="Produto: <?= strip_tags($Show['product_name']) ?> " alt="Produto: <?= strip_tags($Show['product_name']) ?>">
                <h1><?= strip_tags($Show['product_name']) ?></h1>
                <p><?= strip_tags($Show['product_headline']) ?></p>

                <p class="price">R$ <?= strip_tags(number_format($Show['product_price'], 2, ',', '.')) ?></p>

                <p><br>
                    <a title="Ver mais informações sobre este produto" class="buy" data-value="<?= strip_tags($Show['product_link']) ?>" data-id="<?= strip_tags($Show['product_id']) ?>">
                        <span class="fa fa-shopping-cart"></span> Adicionar ao Carrinho</a>
                </p>
            </section>
            <?php endforeach; ?>
        </article>

        <div class="clear"></div>

    <script src="js/jquery.js"></script>
    <script src="ajax/cart.js"></script>
    </body>
</html>