// CUSTOM GLOBAL
const cl = console.log.bind(console);
const form = document.getElementById('hero-form');
let Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});
// CUSTOM GLOBALEND

// fungsi untuk melakukan request
function createRequest( url, formData, callback) {
    const xhr = new XMLHttpRequest();

    xhr.open('POST',url,true);
    xhr.timeout = 10000;
    xhr.ontimeout = () => {

        Toast.fire({
            icon: 'warning',
            title: 'Slow Network, page will be reload'
        })

        setTimeout(() => {
            window.location.reload();
        }, 2000);

    };
    xhr.onreadystatechange = function () {
        // condotion 4 (data is ready) and 200 (succes status code)
        if(xhr.readyState == 4 && xhr.status == 200) {
            const data = JSON.parse(xhr.responseText);
            callback(data);
        }
    }
    xhr.send(formData);
}// OK - handle timeout
function saveTempData(response){

    sessionStorage.removeItem('tempData');
    sessionStorage.setItem('tempData',JSON.stringify(response.datas));

    if(response.userLovedSongIDs != undefined){
    sessionStorage.removeItem('tempUserIds');
    sessionStorage.setItem('tempUserIds',JSON.stringify(response.userLovedSongIDs));
    }

    if (sessionStorage.getItem('tempData') != null) {
        redirectPage()
    }
}// OK ON
function redirectPage(){

    const originLocation = location.origin;
    document.location.href = originLocation+'/music/show';
}// OK
form.addEventListener('submit',(event)=>{
    event.preventDefault();
    const formData = new FormData(form);
    // form.reset();
    let f = form.innerHTML;
    form.innerHTML = null;
    form.innerHTML = f;
    initialize(formData);
})
function initialize(formData){
    tempSave = true;
    // Real = '../requestData'
    // Sample : '../js/musica.json'
    createRequest('../requestData', formData, saveTempData);
}//OK

