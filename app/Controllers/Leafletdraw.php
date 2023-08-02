<?php

namespace App\Controllers;

use App\Models\TbldatapointModel;
use App\Models\TbldatapolylineModel;
use App\Models\TbldatapolygonModel;
class Leafletdraw extends BaseController
{
    protected $TbldatapointModel;
    protected $TbldatapolylineModel;
    protected $TbldatapolygonModel;
    public function __construct()
    {
        $this->TbldatapointModel = new TbldatapointModel();
        $this->TbldatapolylineModel = new TbldatapolylineModel();
        $this->TbldatapolygonModel = new TbldatapolygonModel();
    }


    public function index()
    {
        return view('leafletdraw/v_create');
    }
    //Menyimpan hasil edit point
    //Nama geometri ditangkap route dan di kirim ke kontroler sebagai array data yang akan disimpan
    public function simpan_point()
    {
        $data = [
            'nama' => $this->request->getPost('input_point_name'),
            'geom' => $this->request->getPost('input_point_geometry'),
        ];
        $this->TbldatapointModel->save($data);
        return redirect()->to('/');
    }
    //Menyimpan hasil edit polyline
    public function simpan_polyline()
    {
        $data = [
            'nama' => $this->request->getPost('input_polyline_name'),
            'geom' => $this->request->getPost('input_polyline_geometry'),
        ];
        $this->TbldatapolylineModel->save($data);
        return redirect()->to('/');
    }
    //Menyimpan hasil edit polygon
    public function simpan_polygon()
    {
        $data = [
            'nama' => $this->request->getPost('input_polygon_name'),
            'geom' => $this->request->getPost('input_polygon_geometry'),
        ];
        $this->TbldatapolygonModel->save($data);
        return redirect()->to('/');
    }
    //Script edit point dengan meretrun view edit point
    public function edit_point()
    {
        return view('leafletdraw/v_edit_point');
    }
    //script menyimpan edit point dan mengupdate data point ke database
    public function simpan_edit_point(){
        $id = (int)$this->request->getPost('id_point');
         // Ambil nama titik sebelumnya
        $data = [
            'point'=> $this->request->getPost('simpan_point'),
            'nama' => $this->request->getPost('edit_point_name'), 
            'geom' => $this->request->getPost('edit_point_geometry'),];
        //standar syntax update harus mencari id nya 
        $this->TbldatapointModel->update($id,$data);
        return redirect()->to('/editpoint');
    }
    //script edit polyline dengan meretrun view edit polyline
    public function edit_polyline()
    {
        return view('leafletdraw/v_edit_polyline');
    }
    //script menyimpan edit polyline dan mengupdate data polyline ke database
    public function simpan_edit_polyline(){
        $id = (int)$this->request->getPost('id_polyline');
        $data = [
            'nama' => $this->request->getPost('edit_polyline_name'), 
            'geom' => $this->request->getPost('edit_polyline_geometry'),];
        $this->TbldatapolylineModel->update($id,$data);
        return redirect()->to('/editpolyline');
    }
    //script edit polygon dengan meretrun view edit polygon
    public function edit_polygon()
    {
        return view('leafletdraw/v_edit_polygon');
    }
    //script menyimpan edit polygon dan mengupdate data polygon ke database
    public function simpan_edit_polygon(){
        $id = (int)$this->request->getPost('id_polygon');
        $data = [
            'nama' => $this->request->getPost('edit_polygon_name'), 
            'geom' => $this->request->getPost('edit_polygon_geometry'),];
        $this->TbldatapolygonModel->update($id,$data);
        return redirect()->to('/editpolygon');
    }
    //script menghapus data point menggunakan parameter id
    //menghapus data point berdasarkan ID pada model TbldatapointModel
    public function delete_point($id){
        $this->TbldatapointModel->delete($id);
        return redirect()->to('/editpoint');
    }
    public function delete_polyline($id){
        $this->TbldatapolylineModel->delete($id);
        return redirect()->to('/editpolyline');
    }
    public function delete_polygon($id){
        $this->TbldatapolygonModel->delete($id);
        return redirect()->to('/editpolygon');
    }



}
