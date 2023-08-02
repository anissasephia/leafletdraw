<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Api extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        //
    }
    //Script deafult API(RESTful) karena project baru
    //Script yang berubah
    //Menyimpan hasil input point, polyline, dan polygone dalam format geojson dalam pengulangan foreach untuk ditampilkan dalam peta
    public function point()
    {
        $db = db_connect();
        // geom /data diubah ke text agar bisa diambil datanya
        $query = $db->query("SELECT id, ST_AsGeoJSON(geom) AS geom, nama, deskripsi, foto, created_at, updated_at FROM tbl_data_point");
        $query_array = $query->getResultArray();
        $feature = array();
        foreach ($query_array as $q) {
            $feature[] = [
                'type' => 'Feature',
                'geometry' => json_decode($q['geom']),
                'properties' => [
                    'id' => $q['id'],
                    'nama' => $q['nama'],
                    'deskripsi' => $q['deskripsi'],
                    'foto' => $q['foto'],
                    'created_at' => $q['created_at'],
                    'updated_at' => $q['updated_at'],
                ]
            ];
        }
        $geojson = array(
            'type' => 'FeatureCollection',
            'features' => $feature
        );
        // header allow origin
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        return $this->respond($geojson);
    }
    public function polyline(){
        $db = db_connect();
        // geom diubah ke text agar bisa diambil datanya
        $query = $db->query("SELECT id, ST_AsGeoJSON(geom) AS geom, 
                ST_Length(ST_Transform(ST_SetSRID(ST_AsText(geom),4326),32748)) AS panjang,
                nama, deskripsi, foto, created_at, updated_at FROM tbl_data_polyline WHERE deleted_at IS NULL");
        $query_array = $query->getResultArray();
        $feature = array();
        //Disimpan dalam format geojson dalam pengulangan foreach
        foreach ($query_array as $q) {
            $feature[] = [
                'type' => 'Feature',
                'geometry' => json_decode($q['geom']),
                'properties' => [
                    'id' => $q['id'],
                    'nama' => $q['nama'],
                    'deskripsi' => $q['deskripsi'],
                    'foto' => $q['foto'],
                    'created_at' => $q['created_at'],
                    'updated_at' => $q['updated_at'],
                    'panjang' => $q['panjang'],
                ]
            ];
        }
        $geojson = array(
            'type' => 'FeatureCollection',
            'features' => $feature
        );
        // header allow origin
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        return $this->respond($geojson);
    }
    public function polygon(){
        $db = db_connect();
        $query = $db->query("SELECT id, ST_AsGeoJSON(geom) AS geom, 
                ST_Area(ST_Transform(ST_SetSRID(ST_AsText(geom),4326),32749)) AS luas,
                nama, deskripsi, foto, created_at, updated_at FROM tbl_data_polygon WHERE deleted_at IS NULL");
        $query_array = $query->getResultArray();
        $feature = array();
        //Disimpan dalam format geojson dalam pengulangan foreach
        foreach ($query_array as $q) {
            $feature[] = [
                'type' => 'Feature',
                'geometry' => json_decode($q['geom']),
                'properties' => [
                    'id' => $q['id'],
                    'nama' => $q['nama'],
                    'deskripsi' => $q['deskripsi'],
                    'foto' => $q['foto'],
                    'created_at' => $q['created_at'],
                    'updated_at' => $q['updated_at'],
                    'luas' => $q['luas'],
                ]
            ];
        }
        $geojson = array(
            'type' => 'FeatureCollection',
            'features' => $feature
        );
        // header allow origin
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        return $this->respond($geojson);
    }
}
