$(document).ready(function() {
    //atualiza o icone do carrinho
    var atualizar = setInterval(function(){
        $('#counter').load("index.php #counter");
    }, 1000);
    //atualiza o icone do carrinho
    var atualizar = setInterval(function(){
        $('#loader').load("cart.php #loader");
    }, 500);

    //comprar produto 
    $('body').on('click', '.buy', function(e){
        e.preventDefault();

        var form = $(this).attr('data-value');
        var url = "ajax/cart/buy.php";

        $.ajax({
            url: url,
            type: 'POST',
            data: form,
            dataType: 'JSON',

            success: function (data, textStatus, jqXHR) {
                if(data['status'] == 'success') {
                    $('.result').text('');
                    $('.result').prepend('<div class="status-top-right text-center" id="status-container"><div class="status status-'+data['status']+'"><div class="status-message"><p><span class="fa fa-check-circle">'+data['message']+'</span></p></div></div></div>');

                } else if(data['status'] == 'info') {
                    $('.result').prepend('<div class="status-top-right text-center" id="status-container"><div class="status status-'+data['status']+'"><div class="status-message"><p><span class="fa fa-info-circle">'+data['message']+'</span></p></div></div></div>');

                } else if(data['status'] == 'warning') {
                    $('.result').prepend('<div class="status-top-right text-center" id="status-container"><div class="status status-'+data['status']+'"><div class="status-message"><p><span class="fa fa-exclamation-triangle">'+data['message']+'</span></p></div></div></div>');
                } else {
                    $('.result').prepend('<div class="status-top-right text-center" id="status-container"><div class="status status-'+data['status']+'"><div class="status-message"><p><span class="fa fa-times-circle">'+data['message']+'</span></p></div></div></div>');
                }

                setTimeout(function() {
                    $('#status-container').hide();

                    if (data['redirect'] != '') {
                        window.location.href = data['redirect'];
                    }
                }, 900);
            }

        });
        
    });

     //excluir produto 
     $('body').on('click', '.delete', function(e){
        e.preventDefault();

        var form = $(this).attr('data-id');
        var url = "ajax/cart/delete.php";

        $.ajax({
            url: url,
            type: 'POST',
            data: form,
            dataType: 'JSON',

            success: function (data, textStatus, jqXHR) {
                if(data['status'] == 'success') {
                    $('.result').text('');
                    $('.result').prepend('<div class="status-top-right text-center" id="status-container"><div class="status status-'+data['status']+'"><div class="status-message"><p><span class="fa fa-check-circle">'+data['message']+'</span></p></div></div></div>');

                } else if(data['status'] == 'info') {
                    $('.result').prepend('<div class="status-top-right text-center" id="status-container"><div class="status status-'+data['status']+'"><div class="status-message"><p><span class="fa fa-info-circle">'+data['message']+'</span></p></div></div></div>');

                } else if(data['status'] == 'warning') {
                    $('.result').prepend('<div class="status-top-right text-center" id="status-container"><div class="status status-'+data['status']+'"><div class="status-message"><p><span class="fa fa-exclamation-triangle">'+data['message']+'</span></p></div></div></div>');
                } else {
                    $('.result').prepend('<div class="status-top-right text-center" id="status-container"><div class="status status-'+data['status']+'"><div class="status-message"><p><span class="fa fa-times-circle">'+data['message']+'</span></p></div></div></div>');
                }

                setTimeout(function() {
                    $('#status-container').hide();

                    if (data['redirect'] != '') {
                        window.location.href = data['redirect'];
                    }
                }, 900);
            }

        });
        
    });


     //alterar a quantidade do produto [plus]
     $('body').on('click', '.plus', function(e){
        e.preventDefault();

        var form = $(this).attr('data-id');
        var val = $('.quantity').change().val();
        var url = "ajax/cart/quantity.php?plus="+val;


        $.ajax({
            url: url,
            type: 'POST',
            data: form,
            dataType: 'JSON',

            success: function (data, textStatus, jqXHR) {
                if(data['status'] == 'success') {
                    $('.result').text('');
                    $('.result').prepend('<div class="status-top-right text-center" id="status-container"><div class="status status-'+data['status']+'"><div class="status-message"><p><span class="fa fa-check-circle">'+data['message']+'</span></p></div></div></div>');

                } else if(data['status'] == 'info') {
                    $('.result').prepend('<div class="status-top-right text-center" id="status-container"><div class="status status-'+data['status']+'"><div class="status-message"><p><span class="fa fa-info-circle">'+data['message']+'</span></p></div></div></div>');

                } else if(data['status'] == 'warning') {
                    $('.result').prepend('<div class="status-top-right text-center" id="status-container"><div class="status status-'+data['status']+'"><div class="status-message"><p><span class="fa fa-exclamation-triangle">'+data['message']+'</span></p></div></div></div>');
                } else {
                    $('.result').prepend('<div class="status-top-right text-center" id="status-container"><div class="status status-'+data['status']+'"><div class="status-message"><p><span class="fa fa-times-circle">'+data['message']+'</span></p></div></div></div>');
                }

                setTimeout(function() {
                    $('#status-container').hide();

                    if (data['redirect'] != '') {
                        window.location.href = data['redirect'];
                    }
                }, 900);
            }

        });
        
    });


     //alterar a quantidade do produto [minus]
     $('body').on('click', '.minus', function(e){
        e.preventDefault();

        var form = $(this).attr('data-id');
        var val = $('.quantity').change().val();
        var url = "ajax/cart/quantity.php?minus="+val;


        $.ajax({
            url: url,
            type: 'POST',
            data: form,
            dataType: 'JSON',

            success: function (data, textStatus, jqXHR) {
                if(data['status'] == 'success') {
                    $('.result').text('');
                    $('.result').prepend('<div class="status-top-right text-center" id="status-container"><div class="status status-'+data['status']+'"><div class="status-message"><p><span class="fa fa-check-circle">'+data['message']+'</span></p></div></div></div>');

                } else if(data['status'] == 'info') {
                    $('.result').prepend('<div class="status-top-right text-center" id="status-container"><div class="status status-'+data['status']+'"><div class="status-message"><p><span class="fa fa-info-circle">'+data['message']+'</span></p></div></div></div>');

                } else if(data['status'] == 'warning') {
                    $('.result').prepend('<div class="status-top-right text-center" id="status-container"><div class="status status-'+data['status']+'"><div class="status-message"><p><span class="fa fa-exclamation-triangle">'+data['message']+'</span></p></div></div></div>');
                } else {
                    $('.result').prepend('<div class="status-top-right text-center" id="status-container"><div class="status status-'+data['status']+'"><div class="status-message"><p><span class="fa fa-times-circle">'+data['message']+'</span></p></div></div></div>');
                }

                setTimeout(function() {
                    $('#status-container').hide();

                    if (data['redirect'] != '') {
                        window.location.href = data['redirect'];
                    }
                }, 900);
            }

        });
        
    });

});