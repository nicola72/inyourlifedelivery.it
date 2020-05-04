function showPreloader()
{
    $('#loader-box').show();
}

function hidePreloader()
{
    $('#loader-box').hide();
}

function get_modal(url)
{
    $.ajax({
        type: "GET",
        url: url,
        dataType: "html",
        success: function (data)
        {
            $('#myModal').html(data)
            .modal('show');

        },
        error: function ()
        {
            alert("Si è verificato un errore! Riprova!");
        }
    });
}
