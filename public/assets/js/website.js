function showPreloader()
{
    $('#inner-preloader').show();
    $('body').addClass('preloader-site');
}

function hidePreloader()
{
    $('.preloader-wrapper').fadeOut();
    $('#inner-preloader').hide();
    $('body').removeClass('preloader-site');
}

function show_products(category_id)
{
    showPreloader();
    $.ajax({
        type: "GET",
        url: "/category/"+category_id,
        dataType: "json",
        success: function (data){
            $('#main-page').html(data.html);
            hidePreloader();
        },
        error: function (){
            hidePreloader();
            alert("Si è verificato un errore! Riprova!");
        }
    });
}

function remove_from_cart(cart_id,reload)
{
    showPreloader();
    $.ajax({
        type: "GET",
        url: "/remove_from_cart/"+cart_id,
        dataType: "json",
        success: function (data){
            if(reload === 1)
            {
                alert('reload');
                location.reload();
            }
            else
            {
                $('#cart-menu-list').html(data.cart);
                $('#cart_count').html(data.cart_count);
                $('#cart_count2').html(data.cart_count);
            }

            hidePreloader();
        },
        error: function (){
            hidePreloader();
            alert("Si è verificato un errore! Riprova!");
        }
    });
}