window.onload = () => {
    document.querySelector('#viewer button').addEventListener('click', () => {
        let  url = window.location.href;
        url = new URL(url);
        let fileID = url.searchParams.get("id");
        let filename = document.querySelector('.container h1').innerHTML;
        let content = document.querySelector('textarea').value;

        let obj = {
            "id": fileID,
            "name": filename,
            "content": content
        }
        
        let  http = new XMLHttpRequest();
        http.open("POST", '?action=saveFile', true);
        let req = JSON.stringify(obj)
        http.send(req);
    })
}