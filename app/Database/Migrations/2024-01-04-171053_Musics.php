<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Musics extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_music' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'artist' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'preview' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'full_link' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'cover_small' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'cover_medium' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_music', true);
        $this->forge->createTable('musics');
    }

    public function down()
    {
        $this->forge->dropTable('musics');
    }
}
