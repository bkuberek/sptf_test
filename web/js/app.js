/**
 * Script written for sptf_test
 * 
 * @author Bastian Kuberek <bastian@bkuberek.com>
 */

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
                
                var valid = true;
                
                $(this).find('input[type="text"], input[type="email"], input[type="password"]').each(function() {
                    if (!this.valid) valid = false;
                });
                
                if (valid) {
                    $('#cboxLoadedContent').load('/try-premium/success', function() {
                        $.colorbox.resize();
                    });
                } else {
                    alert('Please correct the errors and try again');
                }

                return false;
            });
            
            // could do some form field validation here...
            $('#colorbox form input').bind('blur', function(event) { $(this).trigger('keyup'); });
            $('#colorbox form input').bind('keyup', function(event) {
                var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
                var mediumRegex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
                var weakRegex = new RegExp("(?=.{6,}).*", "g");
                var input = this, value = input.value, id = input.id;
                
                if (value.length < 3) {
                    input.valid = false;
                    $(input).next('.notification').text(value.length == 0 ? 'Required' : 'Too short. Minimum 3 characters');
                    $(input).next('.notification').addClass('error');
                    return;
                }
                
                switch (id) {
                    case 'user_username':
                    case 'user_email':
                        $.ajax({
                            url: "/user/validate",
                            type: 'get',
                            dataType: 'json',
                            data: {
                                field: id, 
                                value: value
                            },
                            success: function(data){
                                if (data.valid) {
                                    input.valid = true;
                                    $(input).next('.notification').removeClass('error');
                                    $(input).next('.notification').addClass('valid');
                                } else {
                                    input.valid = false;
                                    $(input).next('.notification').removeClass('valid');
                                    $(input).next('.notification').addClass('error');
                                }
                                
                                if (data.message) {
                                    $(input).next('.notification').text(data.message);
                                }
                            }
                        });
                        break;
                        
                    case 'user_password':
                        if (false == weakRegex.test(value)) {
                            input.valid = true;
                            $(input).next('.notification').removeClass('error');
                            $(input).next('.notification').addClass('valid');
                            $(input).next('.notification').text('Weak');
                        } else if (strongRegex.test(value)) {
                            input.valid = true;
                            $(input).next('.notification').removeClass('error');
                            $(input).next('.notification').addClass('valid');
                            $(input).next('.notification').text('Strong!');
                        } else if (mediumRegex.test(value)) {
                            input.valid = true;
                            $(input).next('.notification').removeClass('error');
                            $(input).next('.notification').addClass('valid');
                            $(input).next('.notification').text('Medium');
                        }
                        break;
                        
                    case 'user_password_again':
                        if (value == $('#user_password').attr('value')) {
                            input.valid = true;
                            $(input).next('.notification').removeClass('error');
                            $(input).next('.notification').addClass('valid');
                            $(input).next('.notification').text('Match');
                        } else {
                            input.valid = false;
                            $(input).next('.notification').removeClass('valid');
                            $(input).next('.notification').addClass('error');
                            $(input).next('.notification').text('Does not match');
                        }
                        break;
                }
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
