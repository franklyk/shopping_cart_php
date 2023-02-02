<article class="container_main" id="loader">
    <?php
        

        $Cart = $pdo->prepare("SELECT cart_id, cart_value, cart_session, cart_quantity, cart_status, product_id, cart_total, product_stock, product_cover, product_name FROM cart_temporary WHERE cart_session = :session AND cart_status = :stat");
        $Cart->bindValue(':session', $_SESSION['cart']);
        $Cart->bindValue(':stat', 1);
        $Cart->execute();

        $Lines = $Cart->rowCount();
        // var_dump($Lines);

        if($Lines == 0){
            echo '
                <div class="cart_empty">
                    <h1><span class="fa fa-shopping-cart "></span></h1>
                    <p>Seu carrinho esta vazio, compre agora!!</p>
                </div>
                 ';
        }else{
            $total = 0;
        
            
        foreach($Cart as $Show){
            $total += $Show['cart_total'];
    ?>
                <section class="container_cart">
                    <div class="cart_img">
                        <a href="index.php" title="Produto: <?= strip_tags($Show['product_name']) ?> "><img src="images/<?= strip_tags($Show['product_cover']) ?>" title="Produto: <?= strip_tags($Show['product_name']) ?>" alt="Produto: <?= strip_tags($Show['product_name']) ?>"></a>
                    </div>

                    <div class="cart_title">
                        <p><?= strip_tags(mb_strtoupper($Show['product_name'])) ?></p>
                    </div>
					
					<div class="cart_quantity">
						<p class="minus" data-id="<?= strip_tags($Show['cart_id']) ?>"><span class="fa fa-minus-circle"></span></p>
						<span><input class="quantity loader" name="quantity" type="text" value="<?= strip_tags($Show['cart_quantity']) ?>" id="quantity" class="quantity" readonly></span>
						<p class="plus" data-id="<?= strip_tags($Show['cart_id']) ?>"><span class="fa fa-plus-circle"></span></p>
					</div>

					<div class="cart_value">
						<p class="value" id="loader1">R$ <span class="price"><?= number_format($Show['cart_value'],2,',','.') ?></span></p>
					</div>

					<div class="cart_delete">
						<p><a data-id="<?= strip_tags($Show['cart_id']) ?>" class="delete" title="Remover este produto do carrinho"><span class="fa fa-times-circle"></span></a></p>
					</div>
					
                    <div class="clear"></div>
                </section>
                <?php
                    }     
                ?>
                <section class="container_cart">
                    <div class="cart_values" id="loader2">
                        <p><span class="value">VALOR TOTAL: R$ <span class="result_final"><?= number_format($total, 2, ',','.' )?> </span></span></p>
                    </div>
                </section>
                <?php
                    }
                ?>
            </article>