console.log('TIEN');
// console.log('window.location.hostname\n', window.location.hostname);
// console.log('document.location\n', document.location);
var is_message_load = 0;
if (is_message_load==0 && window.location.href.match(/\/products\//gim)) {
    is_message_load++;
    console.log('is_message_load', is_message_load);
    // let script1 = document.querySelectorAll('script[src*=message]');
    let url = `https://7c77834b.ngrok.io`;
    // script1.forEach(function (val, key) {
    //     url = val.getAttribute('src').replace(/\/js\/.+?$/gim, '');
    // });
    let product = meta.product;
    console.log('product', product);
    fetch(`${url}/message/?shopify_id=${product.id}`)
        .then((response) => {
            return response.json();
        })
        .then(function (data) {
            let html = ``;
            data.forEach(function (val, key) {
                html += `<li>${val.content} - ${val.created_at}</li>`;
            });
            html = `<ul style="background:red;color:white;" style1="style1">${html}</ul>`;
            insertAfter(html, document.querySelectorAll('[name="add"]'));
        });

    function insertBefore(html, nodes){
        nodes.forEach(function (node, key){
            let parentNode = node.parentNode;
            let htmlTagName = html.match(/^<(\w+)/i)[1];
            let htmlNode = document.createElement(htmlTagName);

            let htmlAtribute = html.replace(/^(<.+?>).*?$/gim, '$1');
            let re = /(\w+)=([^>| ]+)/gi;
            let m;
            while(m = re.exec(htmlAtribute)){
                htmlNode.setAttribute(m[1], m[2].replace(/"/g, ''));
            }
            re = new RegExp(`^<${htmlTagName}[^>]+>|<\/${htmlTagName}>`, 'g');
            htmlNode.innerHTML = html.replace(re, '');
            parentNode.insertBefore(htmlNode, node);
        });
    }

    function insertAfter(html, nodes){
        nodes.forEach(function (node, key){
            let parentNode = node.parentNode;
            let htmlTagName = html.match(/^<(\w+)/i)[1];
            let htmlNode = document.createElement(htmlTagName);

            let htmlAtribute = html.replace(/^(<.+?>).*?$/gim, '$1');
            let re = /(\w+)=([^>| ]+)/gi;
            let m;
            while(m = re.exec(htmlAtribute)){
                htmlNode.setAttribute(m[1], m[2].replace(/"/g, ''));
            }

            re = new RegExp(`^<${htmlTagName}[^>]+>|<\/${htmlTagName}>`, 'g');
            htmlNode.innerHTML = html.replace(re, '');
            parentNode.insertBefore(htmlNode, node.nextSibling);
        });
    }
}
