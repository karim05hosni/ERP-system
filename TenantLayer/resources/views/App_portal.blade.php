<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Portal</title>
</head>
<body>
    <h2>App Portal</h2>
    <form id="appPortalForm">
        <select name="app" required>
            <option value="ecommerce">Ecommerce</option>
            <option value="erp">ERP</option>
        </select>
        <button type="submit">Go</button>
    </form>
    <script>
document.getElementById('appPortalForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const app = new FormData(this).get('app');
    const token = localStorage.getItem('token');
    if (!token) {
        alert('Please login first');
        return;
    }
    // fetch(`http://enterprisesoftware.root/TenantLayer/public/api/${app}`, {
    //     method: 'GET',
    //     headers: { 'Authorization': `Bearer ${token}` }
    // })
    // .then(response => {
    //     // if (response.redirected) {
    //         // window.location.href = response; // Browser handles redirect
    //     // }
    // })
    // .catch(error => {
    //     console.error('Error:', error);
    // });
    const currentHost = window.location.hostname;
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open( "GET", `http://${currentHost}/TenantLayer/public/api/${app}`, false ); // false for synchronous request
    xmlHttp.setRequestHeader('Authorization', `Bearer ${token}`)
    xmlHttp.send( null );
    window.open(xmlHttp.responseText,'_blank')
    console.log(xmlHttp.responseText);
    return xmlHttp.responseText;
});
   
   </script>
</body>
</html>
