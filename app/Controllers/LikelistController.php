<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class LikelistController extends BaseController
{
    public function index()
    {
        $likedsongsModel = model('LikedSongs');
        $data = $likedsongsModel->where('user_id', auth()->id())->join('musics', 'musics.id_music = liked_songs.song_id', 'left')->orderBy('musics.created_at', 'DESC');
        $data = [
            'data' => $data->paginate(25),
            'liked_music_count' => $data->countAll(false),
            'pager' => $likedsongsModel->pager,
        ];

        return view('likelist_section/index', $data);
    }

    public function delete()
    {
        $songId = $this->request->getPost('songId');

        $likedsongsModel = model('LikedSongs');
        $musicModel = model('Music');

        $likedsongsModel->where('user_id', auth()->id())->where('song_id', $songId)->delete();
        if ($likedsongsModel->where('song_id', $songId)->countAllResults() < 1) $musicModel->delete($songId);

        $response['status'] = true;
        $response['csrf_new_token'] = csrf_hash();

        return $this->response->setJson($response);
    }

    public function requestPlaylist()
    {
        $songId = $this->request->getPost('songId');
        $playlistModel = model('Playlist');
        $playlistItemsModel = model('PlaylistItems');

        $exceptionId = $playlistItemsModel->where('song_id', $songId)->findColumn('playlist_id');
        $listPlaylist = $playlistModel->select('id,name')->where('user_id', auth()->id());
        if ($exceptionId != null) $listPlaylist->whereNotIn('id', $exceptionId);

        $data['data']  = $listPlaylist->findAll();
        $data['csrf_new_token'] = csrf_hash();
        $data['status'] = true;

        return $this->response->setJSON($data);
    }

    function addToPlaylist()
    {
        $songId = $this->request->getPost('songId');
        $selectedPlaylistId = $this->request->getPost('selected-playlist-id');

        $playlistItemsModel = model('PlaylistItems');

        $response['status'] = $playlistItemsModel->insert([
            'song_id' => $songId,
            'playlist_id' => $selectedPlaylistId,
        ], false);
        $response['csrf_new_token'] = csrf_hash();

        return $this->response->setJson($response);
    }
}
