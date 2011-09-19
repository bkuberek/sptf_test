/**
 * Script written for sptf_test
 * 
 * @author Bastian Kuberek <bastian@bkuberek.com>
 */

var User = User || {};

User.validate = function(key, value) {
    var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
    var mediumRegex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
    var weakRegex = new RegExp("(?=.{6,}).*", "g");
    
    var response = {};
    
    // this is not working. I can't figure this out at the moment. Perhaps another time.'
    switch (key) {
        case 'user_username':
        case 'user_email':
            $.ajax({
                url: "/user/validate",
                type: 'get',
                dataType: 'json',
                data: {field: key, value: value},
                success: function(data){
                    console.log('ajax', data)
                    response = data;
                }
            });
            break;
        case 'user_password':
            if (false == weakRegex.test(value)) {
                response.valid = true;
                response.message = 'Weak!'
            } else if (strongRegex.test(value)) {
                response.valid = true;
                response.message = 'Strong!'
            } else if (mediumRegex.test(value)) {
                response.valid = true;
                response.message = 'Medium!'
            }
            break;
    }
    return response;
};

$(document).ready(function() {
    
    var decache = Math.random() * 999999999999;
    /**
     * Try Spotify Premium
     */
    $('.spotify-free-try-btn').colorbox({
        inline: false,
        opacity: 0.8,
        innerWidth: '645px',
        scrolling: false,
        href: '/try-premium?null='+decache,
        onComplete: function() {
            // could do some form validation here
            $('#colorbox form').bind('submit', function(event) {
                event.preventDefault();
                
                
                return false;
            });
            
            // could do some form field validation here...
            $('#colorbox form input').bind('keyup', function(event) {
                if (this.value.length < 3) {
                    this.valid = false;
                    return;
                }
                var response = User.validate(this.id, this.value);
                var msg;
                if (response.valid) {
                    msg = 'ok.'
                } else {
                    msg = 'bad.'
                }
                
                if (response.message) {
                    msg += ' '+ response.message;
                }
                
                $(this).next('.notification').text(msg)
            });
        }
    });
   
    // IMDB filter by range form
    $('#filter-range').bind('submit', function(event) {
        event.preventDefault();
        var url = $(this).attr('data-action');
        var start = this.start.value;
        var end = this.end.value;
       
        if (url.substring(-1) != '/') {
            url += '/';
        }
       
        if (!(!isNaN(parseFloat(start)) && isFinite(start))) {
            alert('Invalid starting year');
            return false;
        } else if (start.length != 4) {
            alert('Starting year must have 4 digits');
            return false;
        }
       
        url += start;
       
        if (end) {
            if (!(!isNaN(parseFloat(end)) && isFinite(end))) {
                alert('Invalid ending year');
                return false;
            } else if (end.length != 4) {
                alert('Ending year must have 4 digits');
                return false;
            }
            url += '-' + end;
        }
 
        window.location.href = url;

        return false;
    })
});