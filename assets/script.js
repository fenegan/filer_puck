window.onload = function() {
var errors = document.querySelector('#result');
var area = document.querySelector('textarea');
var btn = document.querySelector('#btn');
btn.addEventListener('click',function(){
    var content = area.value;
    var xmlhttp;
    var fileName = area.getAttribute('data-name');
    var fileId = area.getAttribute('data-id');
    var infos = {
        'name' : fileName,
        'id' : fileId,
        'content' : content
    }
    json_data = JSON.stringify(infos);
    
    if (window.XMLHttpRequest)
    {
         xmlhttp=new XMLHttpRequest();
    }
    else
    {
         xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.open("POST","?action=save",true);
    xmlhttp.setRequestHeader("Content-type","application/json");
    xmlhttp.onload = function () {
        if (xmlhttp.status === 200) {
            var data = JSON.parse(xmlhttp.responseText);
            errors.innerHTML = data['result'];
            if(data['status'] == "ok"){
                errors.classList.add('alert-success');
                errors.classList.remove('alert-danger');
            } else{
                errors.classList.add('alert-danger');
                errors.classList.remove('alert-success');
            }
        }
    };
    xmlhttp.send(json_data); // json_data is simple json
});
};
