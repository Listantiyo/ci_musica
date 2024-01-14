    tempSave = true;
    internet = true;

    // CUSTOM GLOBAL
    const   cl = console.log.bind(console);
            form = document.getElementById('navbar-form');
            prev = document.getElementById("btn-prev");
            next = document.getElementById("btn-next");
            tbody = document.getElementById('tbody');
            navButton = document.getElementById('button-container-navbar');
            token = form.querySelector('[name=csrf_test_name]');

            elementHTML =
            `<td class="py-2 align-middle">
                <a href="TRACK" target="_blank"><span title="TOOLTIP">TITLES</span></a>
            </td>
            <td class="py-2 align-middle">ARTIST</td>
            <td class="py-2 align-middle">
                <img class="album" src="ALBUM" >
            </td>
            <td class="py-2 align-middle">
                <audio class="audio" preload="none" controls src="PREVIEW"></audio>
            </td>
            <td class="text-center">
                <button class="love-button btn btn-light border-0 rounded" onclick="doLoveStore(this)" data-id="ID">
                    <i class="far fa-heart"></i>
                </button>
            </td>`;

    let Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    let {nextUrl,prevUrl,loveButton} = {};
    // CUSTOM GLOBALEND

    function createRequest( url,formData ,callback) {

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
    }
    function createMusicElement(response, newRequest = true) {
        //store to temp data, for reuse
        const dataJson = JSON.parse((newRequest) ? saveTempData(response) : response);
        disableNextPrevButton(dataJson);
        if (newRequest) token.value = dataJson.csrf_new_token;
        if (newRequest) tbody.innerHTML = null;
        // iteration dataJson
        for (let i = 0; i < dataJson.data.length; i++) {
            const elementData = dataJson.data[i];
            // replace value template table with value data
            const replacedElementHTML = elementHTML
            .replace('TRACK', elementData.link)
            .replace('TITLES', elementData.title.substr(0,35))
            .replace('TOOLTIP', elementData.title)
            .replace('ARTIST', elementData.artist.name)
            .replace('ALBUM', elementData.album.cover_small)
            .replace('PREVIEW', elementData.preview)
            .replace('ID', elementData.id);
            // remove loading button
            if (newRequest) elementLoadingButton(document.getElementById('loadingForm'));
            // create new elemet table row
            const tableRow = document.createElement('tr');
            tableRow.innerHTML = replacedElementHTML;
            tbody.append(tableRow);
            // handle jika url audio error
            const audioElement = tableRow.querySelector('.audio');
            const albumElement = tableRow.querySelector('.album');

            albumElement.addEventListener('error', ()=> {
                cl('image error');
            })
            audioElement.addEventListener('play', ()=> {
                this.addEventListener('loadeddata', ()=> {
                    this.play();
                });
                this.addEventListener('error', ()=> {
                    console.warn('Do Error Handling, loading audio file for', element.title);
                    audioElement.load();
                });
            });
        }

    }
    function disableNextPrevButton(dataJson) {
        if (typeof dataJson.next != undefined) nextUrl = dataJson.next;
        if (nextUrl == undefined) next.setAttribute('disabled','true');
        if (nextUrl != undefined) next.removeAttribute('disabled');

        if (typeof dataJson.prev != undefined) prevUrl = dataJson.prev;
        if (prevUrl == undefined) prev.setAttribute('disabled','true');
        if (prevUrl != undefined) prev.removeAttribute('disabled');
    }
    function elementLoadingButton(removeButton = undefined){
        if (removeButton != undefined){
            removeButton.remove();
        }else{
            const button = document.createElement('button');
            button.setAttribute('id','loadingForm');
            button.classList.add('btn','btn-navbar');
            button.innerHTML = `<div class="fa-spin"><i class="fa fa-sync"></i></div>`
            navButton.prepend(button);
        }
    }
    function triggerRequestNextPrev (isNext) {
        const url = (isNext) ? nextUrl : prevUrl;
        const formData =  new FormData();
            formData.append('url',url);
            formData.append('csrf_test_name',token.value);
        createRequest('../requestDataNextPrev', formData, createMusicElement);
    }
    prev.addEventListener("click",()=>{
        cl('prevUrl : triggered');
        triggerRequestNextPrev(false);
        elementLoadingButton();
    });
    next.addEventListener("click",()=>{
        cl('nextUrl : triggered');
        triggerRequestNextPrev(true);
        elementLoadingButton();
    });
    form.addEventListener('submit',(event)=>{ // => CAN BE REPAIR
        event.preventDefault();
        const formData =  new FormData(form);
        cl('submit');
        elementLoadingButton();
        form.reset();
        initialize(formData);
    })
    function initialize(formData = null){ // => CAN BE REPAIR

        const tempData = sessionStorage.tempData;
        const url = (internet) ? '../requestData' : '../js/musica.json';

        if( formData != null) cl('new request...') + createRequest (url, formData, createMusicElement);
        if( tempData != null && formData == null) cl('temp data...') + createMusicElement(tempData, false);
        if( tempData == null && formData == null) cl('no data');

    }

    // only nologin can do default
    function doLoveStore(element) {
        Toast.fire({
            icon: 'info',
            title: 'You must login first'
        })

    }
    function saveTempData(response){
        sessionStorage.removeItem('tempData');
        sessionStorage.setItem('tempData',JSON.stringify(response.datas));
    return sessionStorage.getItem('tempData');
    }

    document.addEventListener('DOMContentLoaded',initialize())

