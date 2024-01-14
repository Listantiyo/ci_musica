<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ProfileController extends BaseController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $playlistModel = model('Playlist');
        $likesSongsModel = model('LikedSongs');
        $data['playlist']  = $playlistModel->where('user_id', auth()->id())->countAll();
        $data['likedSongs'] = $likesSongsModel->where('user_id', auth()->id())->countAll();
        return view('profile/index', $data);
    }

    public function delete()
    {
        $userModel = model('UserModel');
        $userModel->delete(auth()->id());

        return redirect()->to('/logout');
    }
}
