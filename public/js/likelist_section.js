    tempSave = true;
    internet = true;

    // CUSTOM GLOBAL
    const cl = console.log.bind(console);
    const playlistShowBackButton = document.querySelector('.back-button');
    let Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    let {modal,form} = {};
document.addEventListener('DOMContentLoaded',()=>{

    modal = document.getElementById('modal-default');
    form = document.getElementById('modal-form');

    const nodeElementAudio  = document.querySelectorAll('audio');

    for (const elementAudio of nodeElementAudio) {
        elementAudio.addEventListener('play',()=>{
            const elementParentTableRow =  elementAudio.parentElement.parentElement;
            const audioTitle = elementParentTableRow.querySelector('.title').innerHTML;
            const audioArtist  = elementParentTableRow.querySelector('.artist').innerHTML;
            const audioCover = elementParentTableRow.querySelector('.album').getAttribute('data-cover-medium');

            let randomColor;
            if (randomColor == undefined) {
                randomColor = Math.floor(Math.random() * 16777215).toString(16);
            }
            const cardContainer = document.querySelector('.card-second');
            cardContainer.querySelector("#image-preview").setAttribute('src',audioCover);
            cardContainer.querySelector("#title-preview").innerHTML = '<marquee style="color:#'+randomColor+'">'+audioArtist+' ~ '+audioTitle+'<marquee>'
            cardContainer.style.background = '#'+randomColor+17
            elementAudio.addEventListener('loadeddata', ()=> {
                elementAudio.play();
            });
            elementAudio.addEventListener('error', ()=> {
                console.warn('Do Error Handling, loading audio file for');
                elementAudio.load();
            });
        });
    }

})
    playlistShowBackButton.addEventListener('click',function(){
        location.href = '/music/show'
    })
    // CUSTOM GLOBALEND
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
    function onEventDisableButton (element) {

        const object = element;
        for (const element of object) {
            element.toggleAttribute('disabled');
        }

    }
    function csrfToken(newToken = undefined){
        const token = document.getElementById('modal-form').querySelector('[name="csrf_test_name"]');
        if (newToken != undefined) token.value = newToken;
        return token.value;
    }
    async function deleteSongButton(element){
        const deleteButtons = document.getElementsByClassName(element.getAttribute('class'));
        onEventDisableButton(deleteButtons);
        const songId = element.getAttribute('data-id');

        const formData =  new FormData();
        formData.append('songId', songId);
        formData.append('csrf_test_name', csrfToken());
        const response = await makeRequest('/likelistDeleteSong', formData);

        if(response.status){
            let countedSong = document.querySelector('#counted-song');
            countedSong.innerHTML = countedSong.innerHTML - 1;
            csrfToken(response.csrf_new_token);
            onEventDisableButton(deleteButtons);
            element.parentElement.parentElement.remove();
        }

    }
    async function addToPlaylistButton(element){

        form.reset();
        form.querySelector('select').innerHTML = null
        const elementSelectedOption = document.createElement('option')
        elementSelectedOption.innerHTML = '~ Playlist ~'
        elementSelectedOption.setAttribute('selected','disabled')
        form.querySelector('select').append(elementSelectedOption)

        const songId = element.getAttribute('data-id');
        const formData =  new FormData();
        formData.append('songId', songId);
        formData.append('csrf_test_name', csrfToken());
        const response = await makeRequest('/requestPlaylist',formData);

        if(response.status){
            csrfToken(response.csrf_new_token);

            for (const value of response.data) {
                const elementOption = document.createElement('option');
                elementOption.innerHTML = value.name
                elementOption.value = value.id

                form.querySelector('select').append(elementOption);
            }
        }

        $('#modal-default').modal('toggle');

        form.addEventListener('submit',(event)=>{
            event.preventDefault();
            const formData = new FormData(form);
            formData.append('songId', songId);

            const addToPlaylist = async function () {
                const response = await makeRequest('/addToPlaylist',formData);

                if (response.status) {
                    csrfToken(response.csrf_new_token);
                    Toast.fire({
                        icon: 'success',
                        title: 'Song added to playlist'
                    })
                }

                $('#modal-default').modal('toggle');
            }

            addToPlaylist();
        })

    }

