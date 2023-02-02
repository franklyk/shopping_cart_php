<?php
    session_start();
    require '../../connection.php';
    
    $message = null;


    $Post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    $Minus = filter_input(INPUT_GET, 'minus' ,FILTER_DEFAULT);
    $Plus = filter_input(INPUT_GET, 'plus' ,FILTER_DEFAULT);


    $PostFilters = array_map("strip_tags", $Post);
    

    foreach($PostFilters as $index => $value){}

    usleep(500000);
    
    if(!$_SESSION['cart'] || empty($_SESSION['cart'])) {
            $message = [
                    "message"=> " Não foi possivel atualizar este produto!!",
                    "status"=> 'error',
                    "redirect"=> ' '
                    ];
                    echo json_encode($message);
                    return;
    }


    $Cart = $pdo->prepare("SELECT cart_id, cart_session, cart_quantity, cart_status, product_id FROM cart_temporary WHERE cart_session = :session AND cart_status = :cart_status AND cart_id = :cart_id");
    $Cart->bindValue('session', $_SESSION['cart']);
    $Cart->bindValue('cart_status', 1);
    $Cart->bindValue('cart_id', $index);
    $Cart->execute();
    
    $Lines = $Cart->rowCount();

    
    if($Lines == 0){
        $message = [
                    "message"=> " Este produto já foi removido do pedido!!",
                    "status"=> 'info',
                    "redirect"=> ' '
                    ];
        echo json_encode($message);
        return;
    }else{

        foreach($Cart as $Sh){}
        $product_id = strip_tags($Sh['product_id']);
        $qtd = strip_tags($Sh['cart_quantity']);
        if(!empty($Plus)){
            $cart_quantity = $qtd + 1;
        }else{
            $cart_quantity = $qtd - 1;
            var_dump($cart_quantity);
        }

        $Product = $pdo->prepare("SELECT product_id, product_stock, product_price, product_status FROM products WHERE product_id = :product_id AND product_status = :product_status");
        $Product->bindValue(':product_id', $product_id);
        $Product->bindValue(':product_status', 1);
        $Product->execute();

        foreach($Product as $Show){}

        $product_stock = strip_tags($Show['product_stock']);
        $product_price = strip_tags($Show['product_price']);
        $value = number_format($product_price * $cart_quantity, 2, '.', '');

        if($Plus && !empty($Plus)){
            $stock = $product_stock - 1;

        }else{
            $stock = $product_stock + 1;
        }

        //Se  a quantidade dos produtos no carrinho == ZERO

        if($cart_quantity == 0){
            $Update = $pdo->prepare("UPDATE products SET product_stock = :stock WHERE product_id = :pid");
            $Update->bindValue(':stock', $stock);
            $Update->bindValue(':pid', $product_id);
            $Update->execute();

            $Delete = $pdo->prepare("DELETE FROM cart_temporary WHERE cart_id = :cart_id");
            $Delete->bindValue(':cart_id', $index);
            $Delete->execute();


            if($Delete){
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
        } 
        
        //verifica se o produto tem estoque
        if($product_stock == 0 && empty($Minus)){

            $message = [
                'message'=> "Ops!! Temos apenas {$qtd} un. deste produto !!",
                'status'=> 'info',
                'redirect'=> ' '
                ];

            echo json_encode($message); 
            return;
            
        }else{
            if($Minus && !empty($Minus)){
                $stock = $product_stock + 1;
                
        
            }else{
                $stock = $product_stock - 1;
            }
            $Update = $pdo->prepare("UPDATE cart_temporary SET cart_quantity = :qtd, product_stock = :stock, cart_value = :val, cart_total = :total WHERE cart_id = :cart_id AND product_id = :product_id AND cart_session = :cart_session");
            $Update->bindValue(':qtd', $cart_quantity);
            $Update->bindValue(':stock', $stock);
            $Update->bindValue(':val', $product_price);
            $Update->bindValue(':total', $value);
            $Update->bindValue(':cart_id', $index);
            $Update->bindValue(':product_id', $product_id);
            $Update->bindValue(':cart_session', $_SESSION['cart']);
            $Update->execute();


            $Update = $pdo->prepare("UPDATE products SET product_stock = :stock WHERE product_id = :pid");
            $Update->bindValue(':stock', $stock);
            $Update->bindValue(':pid', $product_id);
            $Update->execute();

            if(!$Update){
                $message = [
                            'message'=> "Não foi possivel atualizar o produto no carrinho!!",
                            'status'=> 'error',
                            'redirect'=> ' '
                ];
            } 
        }
    }    
    echo json_encode($message);
    
?>