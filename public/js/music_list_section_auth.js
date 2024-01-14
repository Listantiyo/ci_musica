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
                <a href="TRACK" target="_blank"><span title="TOOLTIP">TITLE</span></a>
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
                    <i class="far fa-heart" style="color: red;"></i>
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
            .replace('TITLE', elementData.title.substr(0,31))
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

        doToggleStoredLoveButton()

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

    // only login can do auth
    function onEventDisableLoveButton () {

        const object = document.getElementsByClassName('love-button');
        for (const element of object) {
            element.toggleAttribute('disabled');
        }

    }
    function doLoveStore(element) {
        onEventDisableLoveButton();

        loveButton = element.querySelector('i'); // store as global variable
        const songId = element.getAttribute('data-id'); // store as global variable
        const isAdd = loveButton.getAttribute('class') == 'far fa-heart'; //true if do like
        const tempData = JSON.parse(sessionStorage.tempData);

        const formData =  new FormData();
            formData.append('songId', songId);
            formData.append('csrf_test_name',token.value);
            formData.append('save',isAdd);

        if(isAdd){
            for (let index in tempData.data) {
                if (tempData.data[index].id == songId) {
                    let objMusic = tempData.data[index];
                        formData.append('objMusic', JSON.stringify(objMusic));
                }
            }
        }

        createRequest('../storeLove', formData, doToggleLoveButton);
    }
    function doToggleLoveButton(response = undefined){

        updateTempUserIds(response.status,response.song_id);
        token.value = response.csrf_new_token;
        if (!response.status) {
            loveButton.removeAttribute('class');
            loveButton.setAttribute('class','far fa-heart');
        }else{
            loveButton.removeAttribute('class');
            loveButton.setAttribute('class','fa fa-heart');
        }

        onEventDisableLoveButton();
        loveButton = false;
    }
    function doToggleStoredLoveButton () {
        const userIds = JSON.parse(sessionStorage.tempUserIds);
        const object = document.getElementsByClassName('love-button');
        if(userIds === null) return false
        for (const element of object) {
            for (const userId of userIds) {
                if (element.getAttribute('data-id') == userId) {
                    element.querySelector('i').removeAttribute('class');
                    element.querySelector('i').setAttribute('class','fa fa-heart');
                }
            }
        }

    }
    function updateTempUserIds (isSave,songId) {
        const tempUserIds = JSON.parse(sessionStorage.tempUserIds);
        if(isSave){
            tempUserIds.push(songId);
            sessionStorage.setItem('tempUserIds',JSON.stringify(tempUserIds));
        }else{
            const getIdIndex = tempUserIds.indexOf(songId);
            tempUserIds.splice(getIdIndex,1);
            sessionStorage.setItem('tempUserIds',JSON.stringify(tempUserIds));
        }
    }
    function saveTempData(response){
        sessionStorage.removeItem('tempData');
        sessionStorage.setItem('tempData',JSON.stringify(response.datas));

        sessionStorage.removeItem('tempUserIds');
        sessionStorage.setItem('tempUserIds',JSON.stringify(response.userLovedSongIDs));

    return sessionStorage.getItem('tempData');
    }

    document.addEventListener('DOMContentLoaded',initialize())

