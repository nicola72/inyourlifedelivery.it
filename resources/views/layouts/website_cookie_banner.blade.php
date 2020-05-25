@if (!isset($_COOKIE['c_acceptance']) || $_COOKIE['c_acceptance'] != "yes")
<style type="text/css">
    #cookies {
        position:fixed;
        bottom: 0px;
        left:0px;
        border-top: solid 1px #ccc;
        background:#fcfcfc;
        z-index:1000000;
        padding: 10px;
        padding-left:10px;
        text-align:center;
        width:100%;
        font-size:90%;
    }
    #cookies_ok{
        background: #aaa;
        padding:3px 5px;
        color:#fff;
        text-decoration: none;
    }
    #cookies_ok:hover{
        color:#fcfcfc;
    }
</style>
<script>
    function AcceptCookies()
    {	//Se funzione singola
        $.ajax({
            url: "/clear_cookies",
            type: "post",
            success: function (data)
            {
                $("#cookies").fadeOut('slow');
            }
        });
    }
</script>
<div id="cookies" style="color:#000;" class="montserrat">
    Questo sito utilizza cookies per migliorare l'esperienza di navigazione vedi <a href="{{url('/cookies_policy')}}" style="font-weight:bold;" target="_blank">Policy</a>
    &nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;
    Continuando la navigazione, accetti l'utilizzo dei cookies <a href="javascript:void(0);" onclick="AcceptCookies();" id="cookies_ok" style="color:#fff;">OK</a>
</div>
@endif