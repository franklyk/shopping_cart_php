<?php
    session_start();
    require '../../connection.php';
    
    $message = null;
    $Buy = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    $PostFilters = array_map("strip_tags", $Buy);


    foreach($PostFilters as $index => $value){}
    $product = str_replace('-', ' ', mb_strtolower($index));

    usleep(500000);
    
    if(!$_SESSION['cart'] || empty($_SESSION['cart'])){
        $_SESSION['cart'] = rand(10000, 100000000);
    }

    $Product = $pdo->prepare("SELECT product_id, product_cover, product_name, product_stock, product_price, product_link, product_status FROM products WHERE product_link = :link AND product_status = :status");
    $Product->bindValue(':link', $index);
    $Product->bindValue(':status', 1);
    $Product->execute();


    foreach($Product as $Show){}

    $product_id = strip_tags($Show['product_id']);
    $product_cover = strip_tags($Show['product_cover']);
    $product_stock = strip_tags($Show['product_stock']);
    $product_price = strip_tags($Show['product_price']);
    $product_name = strip_tags($Show['product_name']);



    //verifica se o produto tem estoque 

    if($product_stock == 0){
        $message = [
            'message'=> "Ops! Produto sem estoque!!",
            'status'=> 'error',
            'redirect'=> ' '
        ];
        echo json_encode($message);
        return;
    }

    //verifica se o produto ja foi ou não cadastrado para esta seção
    
    $Cart = $pdo->prepare("SELECT cart_id, cart_session, cart_quantity, cart_status, product_id, product_name FROM cart_temporary WHERE product_name = :pname AND cart_status = :st AND product_id = :prodId");
    $Cart->bindValue(':pname', $product_name);
    $Cart->bindValue(':prodId', $product_id);
    $Cart->bindValue(':st', 1);
    $Cart->execute();

    foreach($Cart as $Sh){}

    if($Cart ->rowCount() == 0){
        $stock = $product_stock - 1;
        
        $Create = $pdo->prepare("INSERT INTO cart_temporary(product_id, product_cover, product_name, product_stock, cart_value, cart_quantity, cart_total, cart_status, cart_session) VALUES(:product_id, :product_cover, :product_name, :product_stock, :cart_value, :cart_quantity, :cart_total, :cart_status, :cart_session)");
        $Create->bindValue(':product_id', $product_id);
        $Create->bindValue(':product_cover', $product_cover);
        $Create->bindValue(':product_name', $product_name);
        $Create->bindValue(':product_stock', $stock);
        $Create->bindValue(':cart_value', $product_price);
        $Create->bindValue(':cart_quantity', 1);
        $Create->bindValue(':cart_total', $product_price);
        $Create->bindValue(':cart_status', 1);
        $Create->bindValue(':cart_session', $_SESSION['cart']);
        $Create->execute();
        

        //update no estoque deste produto

        $Stock = $pdo->prepare("UPDATE products SET product_stock = :stock WHERE product_id = :pid");
        $Stock->bindValue(':stock', $stock);
        $Stock->bindValue(':pid', $product_id);
        $Stock->execute();

        if($Create){
            $message = [
                        'message'=> " O produto {$product} foi adicionado ao carrinho!!",
                        'status'=> 'success',
                        'redirect'=> ' '
                        ];
        }else{
            $message = [
                        'message'=> "Não foi possivel adicionar o produto{$product} ao carrinho!!",
                        'status'=> 'error',
                        'redirect'=> ' '
                        ];
        }
    }else {
        $Cart_quantity = strip_tags($Sh['cart_quantity'] + 1);
        $cart_id = strip_tags($Sh['cart_id']);
        $value = number_format($product_price * $Cart_quantity, 2 , '.', '');
        $stock = $product_stock - 1; 

        $Update = $pdo->prepare("UPDATE cart_temporary SET cart_quantity = :qtd, product_stock = :stock, cart_value = :val, cart_total = :total WHERE cart_id = :cart_id AND  product_id = :product_id");
        $Update->bindValue(':qtd', $Cart_quantity);
        $Update->bindValue(':stock', $stock);
        $Update->bindValue(':val', $product_price);
        $Update->bindValue(':total', $value);
        $Update->bindValue(':cart_id', $cart_id);
        $Update->bindValue(':product_id', $product_id);

        $Update->execute();

        //update no estoque deste produto

        $Stock = $pdo->prepare("UPDATE products SET product_stock = :stock WHERE product_id = :pid");
        $Stock->bindValue(':stock', $stock);
        $Stock->bindValue(':pid', $product_id);
        $Stock->execute();

        if($Update){
            $message = [
                        'message'=> " O produto {$product} foi atualizado ao carrinho!!",
                        'status'=> 'success',
                        'redirect'=> ' '
                        ];
        }else{
            $message = [
                        'message'=> "Não foi possivel atualizar o produto{$product} ao carrinho!!",
                        'status'=> 'error',
                        'redirect'=> ' '
                        ];
        }
        
    }


    echo json_encode($message);
    
?>