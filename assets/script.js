window.onload = () => {
    let classes = ['btn-primary', 'btn-danger', 'btn-success'];
    let btn = document.querySelector('#viewer button');
    let logs = document.querySelector('span#logs');
    btn.addEventListener('click', () => {
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
        http.onload = () => {
            if (http.readyState == 4 && http.status == 200) {
                data = JSON.parse(http.response);
                logs.innerHTML = data.message;
                btn.classList.remove(...classes);
                btn.classList.add(`btn-${data.status}`);
                setTimeout(() => {
                    btn.classList.remove(...classes);
                    btn.classList.add('btn-primary')
                    logs.innerHTML = '';
                }, 3000);
            }
        };
        let req = JSON.stringify(obj)
        http.send(req);
    })
}