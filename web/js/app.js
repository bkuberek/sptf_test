
$(document).ready(function() {
   
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