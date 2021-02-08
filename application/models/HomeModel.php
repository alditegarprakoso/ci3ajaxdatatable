<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HomeModel extends CI_Model
{
    // Variabel ini untuk menampung nama tabel
    var $table = 'mahasiswa';

    // Variabel ini untuk menampung field dari tabel
    var $column = ['id', 'nama', 'alamat', 'no_telp'];

    // Variabel ini untuk menampung field dari tabel yang dipakai jika fungsi order dijalankan
    var $order = ['id', 'nama', 'alamat', 'no_telp'];

    private function getData()
    {
        // Mengambil data
        $this->db->from($this->table);

        // Cek, apakah form search dijalankan
        if (isset($_POST['search']['value'])) {
            // Menampilkan data berdasarkan inputan pada form search pada dataTable
            $this->db->like('nama', $_POST['search']['value']);
            $this->db->or_like('alamat', $_POST['search']['value']);
            $this->db->or_like('no_telp', $_POST['search']['value']);
        }

        // Cek, apakah fungsi order dijalankan
        if (isset($_POST['order'])) {
            // Menampilkan data berdasarkan order yang di inginkan pada dataTable
            $this->db->order_by($this->order[$_POST['order'][0]['column']], $_POST['order'][0]['dir']);
        } else {
            // Menampilkan data berdasarkan id secara descending jika fungsi order belum dijalankan
            $this->db->order_by('id', 'DESC');
        }
    }

    // Function ini berfungsi untuk menghitung jumlah data yang sudah di filter atau di cari sesuai inputan pada form search
    public function countFiltered()
    {
        $this->getData();
        return $this->db->get()->num_rows();
    }

    // Function ini berfungsi untuk menghitung semua jumlah data yang ada pada tabel
    public function countTotalRecord()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // Mengambil data Mahasiswa
    public function ambilDataMahasiswa()
    {
        $this->getData();
        // If ini berfugnsi untuk melimit data-data yang ingin ditampilkan sesuai dengan inputan pada dataTable (10, 25, 50, 100)
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }

        return $this->db->get()->result();
    }

    // Menambahkan Data Mahasiswa
    public function tambahData($data)
    {
        $this->db->insert('mahasiswa', $data); // Tambah data mahasiswa
        return $this->db->affected_rows(); // Mengembalikan nilai 1 jika berhasil dan 0 jika gagal
    }

    public function getDataById($id)
    {
        return $this->db->get_where('mahasiswa', ['id' => $id])->row_array();
    }

    public function update($id, $data)
    {
        return $this->db->update('mahasiswa', $data, ['id' => $id]);
        // return $this->db->affected_rows(); // Mengembalikan nilai 1 jika berhasil dan 0 jika gagal
    }

    public function delete($id)
    {
        $this->db->delete('mahasiswa', ['id' => $id]);
        return $this->db->affected_rows(); // Mengembalikan nilai 1 jika berhasil dan 0 jika gagal
    }
}