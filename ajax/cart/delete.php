<?php
    session_start();
    require '../../connection.php';
    
    $message = null;
    $Buy = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    $PostFilters = array_map("strip_tags", $Buy);


    foreach($PostFilters as $index => $value){}

    usleep(500000);
    
    if(!$_SESSION['cart'] || empty($_SESSION['cart'])) {
            $message = [
                     "message"=> " Não foi possivel excluir este produto!!",
                    "status"=> 'error',
                    "redirect"=> ''
                    ];
                    echo json_encode($message);
                    return;
    }


    $Cart = $pdo->prepare("SELECT cart_id, cart_session, cart_quantity, cart_status, product_id FROM cart_temporary WHERE cart_session = :session AND cart_status = :cart_status AND cart_id = :cart_id");
    $Cart->bindValue('session', $_SESSION['cart']);
    $Cart->bindValue('cart_status', 1);
    $Cart->bindValue('cart_id', $index);
    $Cart->execute();
    

    foreach($Cart as $Sh){}

    $prodId = strip_tags($Sh['product_id']);
    $quantity = strip_tags($Sh['cart_quantity']);


    $Product = $pdo->prepare("SELECT product_id, product_stock,product_status FROM products WHERE product_id = :product_id AND product_status = :product_status");
    $Product->bindValue('product_id', $prodId);
    $Product->bindValue('product_status', 1);
    $Product->execute();
    

    foreach($Product as $Show){}

    $productId = strip_tags($Show['product_id']);
    $productStock = strip_tags($Show['product_stock']);
    $stock = $productStock + $quantity;

    //update no estoque deste produto

    $Update = $pdo->prepare("UPDATE products SET product_stock = :stock WHERE product_id = :pid");
    $Update->bindValue(':stock', $stock);
    $Update->bindValue(':pid', $productId);
    $Update->execute();

    $Delete = $pdo->prepare("DELETE FROM cart_temporary WHERE cart_id = :cart_id");
    $Delete->bindValue(':cart_id', $index);
    $Delete->execute();


    if($Update){
        $message = [
                    'message'=> " O produto foi removido do carrinho!!",
                    'status'=> 'success',
                    'redirect'=> ' '
                    ];
    }else{
        $message = [
                    'message'=> "Não foi possivel remover o produto do carrinho!!",
                    'status'=> 'error',
                    'redirect'=> ' '
                    ];
    }
    
    echo json_encode($message);
    // header('location: delete.php');
    
?>