/**
 * Created by Bhanuka on 3/12/2018.
 */
var List = [];

//$("#questionForm").validate().element("[name=radio.activeinactive.select]");
$('form').bootstrap3Validate(function(e, data) {
    e.preventDefault();

    alert(JSON.stringify(data));
});
/*$('[name=next]').on('click', function(e){
    e.preventDefault();
    let q = $('[name=question]').val();

    if(q){
        list.push({q});
        $('[name=question]').val("");
    }
    $('[name=question]').focus();
    console.log(list)
});


$('[name=submit]').on('click', function(e){
    e.preventDefault();
    list = [];
    console.log(list)
});*/
