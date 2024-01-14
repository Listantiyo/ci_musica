<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use function PHPUnit\Framework\isTrue;

class AJAXRequest extends BaseController
{
    public function requestData()
    {
        $likedsongsModel = model('LikedSongs');
        $param = $this->request->getPost('param');

        $options = [
            'baseURI' => env('API_BASE_URI'),
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'X-RapidAPI-Key' => env('API_KEY'),
                'X-RapidAPI-Host' => env('API_HOST'),
            ],
            'query' => ['q' => $param],
            'timeout' => 10,
        ];

        $client = \Config\Services::curlrequest($options);
        $response['datas'] = json_decode($client->get('search')->getBody(), true);
        $response['datas']['csrf_new_token'] = csrf_hash();

        if (auth()->loggedIn()) {
            $songIDs = array();
            foreach ($response['datas']['data'] as $value) array_push($songIDs, $value['id']);
            $getUserSongIds = $likedsongsModel->where('user_id', auth()->id())->whereIn('song_id', $songIDs)->findColumn('song_id');

            $response['userLovedSongIDs'] = ($getUserSongIds == null) ? array() : $getUserSongIds;
        }

        return $this->response->setJSON($response);
    }
    public function requestDataNextPrev()
    {
        $likedsongsModel = model('LikedSongs');

        $url = $this->request->getPost('url');
        $options = [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ],
            'timeout' => 10
        ];

        $client = \Config\Services::curlrequest($options);
        $response['datas'] = json_decode($client->request('GET', $url, $options)->getBody(), true);
        $response['datas']['csrf_new_token'] = csrf_hash();

        if (auth()->loggedIn()) {
            $songIDs = array();
            foreach ($response['datas']['data'] as $value) array_push($songIDs, $value['id']);
            $getUserSongIds = $likedsongsModel->where('user_id', auth()->id())->whereIn('song_id', $songIDs)->findColumn('song_id');

            $response['userLovedSongIDs'] = ($getUserSongIds == null) ? array() : $getUserSongIds;
        }

        return $this->response->setJSON($response);
    }
    public function storeLove()
    {
        if (auth()->loggedIn()) {

            $musicModel = model('Music');
            $likedsongsModel = model('LikedSongs');

            $songId =  $this->request->getPost('songId');

            if ($this->request->getPost('save') === 'true') {
                $objMusic = json_decode($this->request->getPost('objMusic'), true);

                if ($musicModel->where('id_music', $songId)->countAllResults()  < 1) {
                    $arrayMusic['id_music'] = $objMusic['id'];
                    $arrayMusic['title'] = $objMusic['title'];
                    $arrayMusic['artist'] = $objMusic['artist']['name'];
                    $arrayMusic['preview'] = $objMusic['preview'];
                    $arrayMusic['full_link'] = $objMusic['link'];
                    $arrayMusic['cover_small'] = $objMusic['album']['cover_small'];
                    $arrayMusic['cover_medium'] = $objMusic['album']['cover_medium'];
                    $musicModel->insert($arrayMusic, false);
                }

                $arrayLikedSongs['user_id'] = auth()->id();
                $arrayLikedSongs['song_id'] = $songId;
                $likedsongsModel->insert($arrayLikedSongs, false);

                $response['status'] = true;
                $response['song_id'] = $songId;
                $response['csrf_new_token'] = csrf_hash();

                return $this->response->setJson($response);
            } else {

                $likedsongsModel->where('user_id', auth()->id())->where('song_id', $songId)->delete();
                if ($likedsongsModel->where('song_id', $songId)->countAllResults() < 1) $musicModel->delete($songId);

                $response['status'] = false;
                $response['song_id'] = $songId;
                $response['csrf_new_token'] = csrf_hash();

                return $this->response->setJson($response);
            }
        }
    }
    public function tes()
    {
        $playlistModel = model('Playlist');
        $playlistItemsModel = model('PlaylistItems');

        $exceptionId = $playlistItemsModel->where('song_id', 36)->findColumn('playlist_id');
        $data['playlist']  = $playlistModel->select('id,name')->where('user_id', auth()->id())->whereNotIn('id', $exceptionId)->orderBy('created_at', 'DESC')->findAll();

        var_dump($data);
    }
}
