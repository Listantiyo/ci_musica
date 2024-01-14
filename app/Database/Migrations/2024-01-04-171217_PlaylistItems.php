<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PlaylistItems extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'playlist_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'song_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('playlist_id', 'playlists', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('song_id', 'liked_songs', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('playlist_items');
    }

    public function down()
    {
        $this->forge->dropTable('playlist_items');
    }
}
