/**
 * Created by Bhanuka on 4/15/2018.
 */

$(function(){
    $("#status").change(function() {
        var status = this.value;
        if (status == 1 || status == 3) {
            document.getElementById('company').setAttribute('required', true);
        }
        if (status == 2) {
            document.getElementById('company').removeAttribute('required');
        }
    });

});