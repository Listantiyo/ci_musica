    tempSave = true;
    internet = true;

    // CUSTOM GLOBAL
    const cl = console.log.bind(console);
    const playlistId = document.querySelector('section[data-playlist]').getAttribute('data-playlist');
    const addSongButton = document.getElementById('addSongButton');
    const editDetailPlaylistButton = document.getElementById('editDetailPlaylistButton');
    const deletePlaylistButton = document.getElementById('deletePlaylistButton');
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

})

    // when click Item Delete Button
    async function deletePlaylistSongButton(element){
        const deleteButtons = document.getElementsByClassName(element.getAttribute('class'));
        onEventDisableButton(deleteButtons);
        const songId = element.getAttribute('data-id');

        const formData =  new FormData();
        formData.append('playlistId', playlistId);
        formData.append('songId', songId);
        formData.append('csrf_test_name', csrfToken());
        const response = await makeRequest('/playlistItemDelete', formData);

        if(response.status){
            csrfToken(response.csrf_new_token);
            onEventDisableButton(deleteButtons);
            element.parentElement.parentElement.remove();
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
        const token = document.getElementById('modal-form').querySelector('[name="csrf_test_name"]');
        if (newToken != undefined) token.value = newToken;
        return token.value;
    }

    function onEventDisableButton (element) {

        const object = element;
        for (const element of object) {
            element.toggleAttribute('disabled');
        }

    }








    playlistShowBackButton.addEventListener('click',function(){
        location.href = '/playlist'
    })
    deletePlaylistButton.addEventListener('click',function(){
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.setAttribute('action','/playlist/delete');
                form.submit();
            }
        })
    })
    editDetailPlaylistButton.addEventListener('click', function(){
        form.setAttribute('action','/playlist/update');
        modal.children[0].classList.remove('modal-xl');
        modal.querySelector('.modal-body').innerHTML = null
        modal.querySelector('button[type="submit"]').disabled = true;
        modal.querySelector('.modal-title').innerHTML = 'Edit Detail'
        modal.querySelector('button[type="submit"]').innerHTML = 'Save Changes';
        const playlistName =  document.querySelector('#playlist-name').children[0].innerHTML;
        const playlistImage =  document.querySelector('#playlist-image').children[0].getAttribute('src');
        const playlistDescription =  document.querySelector('#playlist-description').children[0].innerHTML;

        const elementFormInput =
        `
            <div class="my-2">
                <input name="playlist_name" class="form-control form-control-sm" type="text" placeholder="Playlist Name" value="` + playlistName + `">
            </div>
            <div class="my-2">
            <input name="playlist_image_url" class="form-control form-control-sm" type="text" placeholder="Image Url" value="` + playlistImage + `">
            </div>
            <div class="my-2">
                <textarea name="playlist_description" class="form-control form-control-sm" rows="3" placeholder="Description...">` + playlistDescription + `</textarea>
            </div>
        `

        const elementFormInputContainer = document.createElement('div');
        elementFormInputContainer.innerHTML = elementFormInput;
        modal.querySelector('.modal-body').append(elementFormInputContainer);

        $('#modal-default').modal('toggle');

        const formInputTriggerChange = () => {
            cl('ok')
            const formInputPlaylistName = modal.querySelector('.modal-body').getElementsByClassName('form-control')['playlist_name'];
            const formInputPlaylistImageUrl= modal.querySelector('.modal-body').getElementsByClassName('form-control')['playlist_image_url'];
            const formInputPlaylistDescription= modal.querySelector('.modal-body').getElementsByClassName('form-control')['playlist_description'];
            formInputPlaylistName.addEventListener('keyup',()=>{
                if(
                    formInputPlaylistName.value != playlistName ||
                    formInputPlaylistImageUrl.value != playlistImage ||
                    formInputPlaylistDescription.value != playlistDescription
                ){modal.querySelector('button[type="submit"]').disabled = false;}else{modal.querySelector('button[type="submit"]').disabled = true;}
            })
            formInputPlaylistImageUrl.addEventListener('keyup',()=>{
                if(
                    formInputPlaylistName.value != playlistName ||
                    formInputPlaylistImageUrl.value != playlistImage ||
                    formInputPlaylistDescription.value != playlistDescription
                ){modal.querySelector('button[type="submit"]').disabled = false;}else{modal.querySelector('button[type="submit"]').disabled = true;}
            })
            formInputPlaylistDescription.addEventListener('keyup',()=>{
                if(
                    formInputPlaylistName.value != playlistName ||
                    formInputPlaylistImageUrl.value != playlistImage ||
                    formInputPlaylistDescription.value != playlistDescription
                ){modal.querySelector('button[type="submit"]').disabled = false;}else{modal.querySelector('button[type="submit"]').disabled = true;}
            })
        }

        formInputTriggerChange();
    })
    // when click Add Song Button
    addSongButton.addEventListener('click', function(){

        modal.querySelector('.modal-body').innerHTML = null
        modal.querySelector('button[type="submit"]').disabled = true;
        form.setAttribute('action','/playlist/itemAdd');
        const elementTableMusicLiked =
        `
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0" style="height: 29.5rem;">
                <table class="table table-head-fixed text-nowrap">
                    <thead>
                        <tr>
                            <th>*</th>
                            <th>Title</th>
                            <th>Artist</th>
                            <th>Album</th>
                            <th>Preview</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        `

        const elementTabelData =
        `
        <td class="py-2 align-middle">
            <input name="song-id[]" class="checkbox" type="checkbox" value=ID>
        </td>
        <td class="py-2 align-middle">
            <a><span title="TOOLTIP">TITLE</span></a>
        </td>
        <td class="py-2 align-middle">ARTIST</td>
        <td class="py-2 align-middle">
            <img class="album" src="ALBUM" data-medium-album="ALBUM_MEDIUM" title="copy url">
        </td>
        <td class="py-2 align-middle">
            <audio class="audio" preload="none" controls src="PREVIEW"></audio>
        </td>
        `

        const elementTabelContainer = document.createElement('div');
        elementTabelContainer.innerHTML = elementTableMusicLiked;

        modal.querySelector('.modal-body').append(elementTabelContainer);
        modal.querySelector('.modal-title').innerHTML = 'Add Music';
        modal.querySelector('button[type="submit"]').innerHTML = 'Add Selected';
        modal.children[0].classList.add('modal-xl');

        $('#modal-default').modal('toggle');

        const isElementCreated =  async () => {

            const formData =  new FormData();
            formData.append('csrf_test_name', csrfToken());
            formData.append('playlistId', playlistId);
            const response = await makeRequest('/requestDataLikedSong',formData);

            if(response.status){
                csrfToken(response.csrf_new_token);

                for (let index = 0; index < response.data.length; index++) {
                    const value = response.data[index];
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
                    document.querySelector('.modal-body #tbody').append(elementTabelRow);

                    const checkbox = elementTabelRow.querySelector('.checkbox');
                    checkbox.addEventListener('change', function(){
                        const formData =  new FormData(form);

                        for (const [index,value] of formData.entries()) {
                            let checked = index == 'song-id[]';
                            if(!checked) {
                                modal.querySelector('button[type="submit"]').disabled = true;
                            }
                            if(checked) {
                                modal.querySelector('button[type="submit"]').disabled = false;
                                break;
                            }
                        }
                    })

                    const album = elementTabelRow.querySelector('.album');
                    album.addEventListener('click', function(){
                        navigator.clipboard.writeText(album.getAttribute('data-medium-album'));
                    })
                }
            }
        }

        isElementCreated()
    })