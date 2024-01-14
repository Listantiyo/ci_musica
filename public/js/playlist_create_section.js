    tempSave = true;
    // CUSTOM GLOBAL
    const cl = console.log.bind(console);
    const elementTbody = document.getElementById('tbody');
    // CUSTOM GLOBALEND
    async function initialize(){

        const formData =  new FormData();
        formData.append('csrf_test_name', csrfToken());
        const response = await makeRequest('/requestDataLikedSong', formData);

        if(response.status){
            csrfToken(response.csrf_new_token);
            createElement(response.data);
        }

    }

    function makeRequest(url, formData){
        return new Promise ( function ( success ){
            const xhr = new XMLHttpRequest();
            xhr.open('POST',url,true);
            xhr.onreadystatechange =
                function () {
                    if (this.readyState === 4 && this.status === 200) {
                        success(JSON.parse(this.responseText));
                    }
                }
            xhr.send(formData);
        })
    }

    function csrfToken(newToken = undefined){
        const token = document.getElementById('create-playlist-form').querySelector('[name="csrf_test_name"]');
        if (newToken != undefined) token.value = newToken;
        return token.value;
    }

    function createElement(response){
        const elementTabelData =
        `
        <td class="py-2 align-middle">
            <input name="song-id[]" class="" type="checkbox" value=ID>
        </td>
        <td class="py-2 align-middle">
            <a ><span title="TOOLTIP">TITLE</span></a>
        </td>
        <td class="py-2 align-middle">ARTIST</td>
        <td class="py-2 align-middle">
            <img class="album" src="ALBUM" data-medium-album="ALBUM_MEDIUM" title="copy url">
        </td>
        <td class="py-2 align-middle">
            <audio class="audio" preload="none" controls src="PREVIEW"></audio>
        </td>
        `;

        for (let index = 0; index < response.length; index++) {
            const value = response[index];
            const replaceElementTabelData = elementTabelData
            .replace('ID',value.id)
            .replace('TOOLTIP', value.title)
            .replace('TITLE', value.title)
            .replace('ARTIST',value.artist)
            .replace('ALBUM',value.cover_small)
            .replace('ALBUM_MEDIUM',value.cover_medium)
            .replace('PREVIEW',value.preview);

            const elementTabelRow = document.createElement('tr');
            elementTabelRow.innerHTML = replaceElementTabelData;
            elementTbody.append(elementTabelRow);

            const album = elementTabelRow.querySelector('.album');
            album.addEventListener('click', function(){
                navigator.clipboard.writeText(album.getAttribute('data-medium-album'));
            })
        }


    }

    document.addEventListener("DOMContentLoaded",initialize());

