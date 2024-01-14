<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\RawSql;

class PlaylistController extends BaseController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $playlistModel = model('Playlist');
        $data['playlist']  = $playlistModel->where('user_id', auth()->id())->orderBy('created_at', 'DESC')->findAll();
        return view('playlist_section/index', $data);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $playlistModel = model('Playlist');

        // Join versi query builder
        $playlistModel
            ->select('musics.*, playlist_items.song_id')
            ->join('playlist_items', 'playlists.id = playlist_items.playlist_id', 'inner')
            ->join('liked_songs', 'playlist_items.song_id = liked_songs.id', 'inner')
            ->join('musics', 'liked_songs.song_id = musics.id_music', 'inner')
            ->where('playlists.user_id', auth()->id())
            ->where('playlists.id', $id)
            ->groupBy('musics.title');

        $data = [
            'data' => $playlistModel->paginate(25),
            'pager' => $playlistModel->pager,
            'playlist' => $playlistModel->where('user_id', auth()->id())->find($id),
        ];

        // echo '<pre>';
        // print_r($data['data']);
        // echo '</pre>';
        return view('playlist_section/show', $data);
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        return view('playlist_section/create');
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function store()
    {
        $modelPlaylist =  model('Playlist');
        $modelPlaylistItems =  model('PlaylistItems');

        $songIds = $this->request->getPost('song-id');
        $titlePlaylist = $this->request->getPost('title-playlist', FILTER_SANITIZE_STRING);
        $imagePlaylist = $this->request->getPost('image-playlist');
        $descriptionPlaylist = $this->request->getPost('description-playlist');

        $dataPlaylist = [
            'user_id'       => auth()->id(),
            'name'          => $titlePlaylist,
            'description'   => $descriptionPlaylist,
            'image'         => $imagePlaylist,
        ];

        $isPlaylistCreated = $modelPlaylist->insert($dataPlaylist, false); // return true at success

        if ($isPlaylistCreated) {
            foreach ($songIds as $songId) {
                $dataPlaylistItems = [
                    'playlist_id' => $modelPlaylist->getInsertID(),
                    'song_id'     => $songId,
                ];
                $modelPlaylistItems->insert($dataPlaylistItems);
            }
        }

        return redirect()->to('playlist');
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update()
    {
        $playlistModel = model('Playlist');

        $playlistId = $this->request->getPost('playlist-id');
        $playlistName = $this->request->getPost('playlist_name');
        $playlistImageUrl = $this->request->getPost('playlist_image_url');
        $playlistDescription = $this->request->getPost('playlist_description');

        $playlistNewData = [
            'name'          => $playlistName,
            'description'   => $playlistDescription,
            'image'         => $playlistImageUrl,
        ];

        $isPlaylistUpdated = $playlistModel->update($playlistId, $playlistNewData, false); // return true at success

        if ($isPlaylistUpdated) return redirect()->to('playlist/show/' . $playlistId);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete()
    {
        $playlistModel = model('Playlist');
        $playlistId = $this->request->getPost('playlist-id');

        $isPlaylistDeleted = $playlistModel->delete($playlistId); // return true at success
        if ($isPlaylistDeleted) return redirect()->to('playlist');
    }

    function addItem()
    {

        $songIds = $this->request->getPost('song-id');
        $playlistId = $this->request->getPost('playlist-id');

        $modelPlaylistItems =  model('PlaylistItems');

        foreach ($songIds as $songId) {
            $dataPlaylistItems = [
                'playlist_id' => $playlistId,
                'song_id'     => $songId,
            ];
            $modelPlaylistItems->insert($dataPlaylistItems);
        }

        $modelPlaylistItems->insert($dataPlaylistItems, true);

        return redirect()->to('playlist/show/' . $playlistId);
    }

    public function deleteItem()
    {
        $songId = $this->request->getPost('songId');
        $playlistId = $this->request->getPost('playlistId');
        $playlistItemsModel = model('PlaylistItems');

        $playlistItemsModel->where('playlist_id', $playlistId)->where('song_id', $songId)->delete();

        $response['status'] = true;
        $response['csrf_new_token'] = csrf_hash();

        return $this->response->setJson($response);
    }

    public function requestDataLikedSong()
    {
        // Post Data
        $playlistId = ($this->request->getPost('playlistId') != null) ? $this->request->getPost('playlistId') : false;
        //Declare Model
        $likedsongsModel = model('LikedSongs');
        $playlistItemsModel = model('PlaylistItems');
        // Query
        $listLikedSong = $likedsongsModel->join('musics', 'musics.id_music = liked_songs.song_id', 'left')->where('user_id', auth()->id());

        if ($playlistId) $likedsongsModel->whereNotIn('liked_songs.id', $playlistItemsModel->where('playlist_id', $playlistId)->findColumn('song_id'));

        //create response
        $response['data'] = $listLikedSong->findAll();
        $response['status'] = true;
        $response['csrf_new_token'] = csrf_hash();

        return $this->response->setJSON($response);
    }
}
