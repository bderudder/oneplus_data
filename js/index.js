$("#login-button").click(function (event) {
    event.preventDefault();

    $('form').fadeOut(500);
    $('.wrapper').addClass('form-success');
});

Ladda.bind('.refresh-users-rank button', {
    callback: function( instance ) {
        //Start refreshing users rank:
        $.get("update_user_stats.php");

        //Fetching progress and displaying it
        var prevProgress = 0;
        var interval = setInterval(function() {
            $.get("update_user_stats.php?action=getprogress", function(data, status){
                var progressSplit = data.split('/');
                if(progressSplit.length == 2) {
                    if(prevProgress != (progressSplit[0] / progressSplit[1])) {
                        prevProgress = (progressSplit[0] / progressSplit[1]);
                        instance.setProgress(prevProgress);
                    }
                } else {
                    instance.stop();
                    clearInterval(interval);
                }
            });
        }, 300);
    }
});