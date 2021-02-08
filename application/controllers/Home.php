<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('HomeModel', 'home');
	}

	public function index()
	{
		$this->load->view('index');
	}
	public function ambilData()
	{
		$results = $this->home->ambilDataMahasiswa();
		$data = [];
		$no = $_POST['start'];
		foreach ($results as $result) {
			$row = [];
			$row[] = ++$no;
			$row[] = $result->nama;
			$row[] = $result->alamat;
			$row[] = $result->no_telp;
			$row[] = '
			<button class="btn btn-success" id="btnEdit" onClick="edit(' . $result->id . ')">Edit</button>
			<button class="btn btn-danger" id="btnHapus" onClick="hapus(' . $result->id . ')">Hapus</button>
			';
			$data[] = $row;
		}

		$output = [
			'draw' => $_POST['draw'],
			'recordsTotal' => $this->home->countTotalRecord(),
			'recordsFiltered' => $this->home->countFiltered(),
			'data' => $data
		];

		$this->output->set_content_type('application/json')->set_output(json_encode($output));
	}

	public function tambah()
	{
		$this->form_validation->set_rules('nama', 'Nama', 'required|trim|alpha_numeric_spaces|min_length[3]');
		$this->form_validation->set_rules('alamat', 'Alamat', 'required|trim|min_length[3]');
		$this->form_validation->set_rules('no_telp', 'Nomor Telepon', 'required|trim|numeric|min_length[12]');

		$this->form_validation->set_message('required', '%s tidak boleh kosong !');
		$this->form_validation->set_message('alpha_numeric_spaces', '%s harus huruf !');
		$this->form_validation->set_message('numeric', '%s hanya dapat menggunakan angka!');
		$this->form_validation->set_message('min_length', '%s terlalu pendek');

		if ($this->form_validation->run() == FALSE) {
			$dataError = [
				'error'     => true,
				'status' => 'errorValidation',
				'nama'      => form_error('nama'),
				'alamat'      => form_error('alamat'),
				'no_telp'  => form_error('no_telp')
			];
			$this->output->set_content_type('application/json')->set_output(json_encode($dataError));
		} else {
			$data = [
				'nama' => htmlspecialchars($this->input->post('nama')),
				'alamat' => htmlspecialchars($this->input->post('alamat')),
				'no_telp' => htmlspecialchars($this->input->post('no_telp'))
			];

			if ($this->home->tambahData($data) > 0) {
				$message['status'] = 'Success';
			} else {
				$message['status'] = 'Failed';
			}

			$this->output->set_content_type('application/json')->set_output(json_encode($message));
		}
	}

	public function edit()
	{
		$id = $this->input->post('id');
		$data = $this->home->getDataById($id);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function update()
	{
		$this->form_validation->set_rules('namaEdit', 'Nama', 'required|trim|alpha_numeric_spaces|min_length[3]');
		$this->form_validation->set_rules('alamatEdit', 'Alamat', 'required|trim|min_length[3]');
		$this->form_validation->set_rules('noTelpEdit', 'Nomor Telepon', 'required|trim|numeric|min_length[12]');

		$this->form_validation->set_message('required', '%s tidak boleh kosong !');
		$this->form_validation->set_message('alpha_numeric_spaces', '%s harus huruf !');
		$this->form_validation->set_message('numeric', '%s hanya dapat menggunakan angka!');
		$this->form_validation->set_message('min_length', '%s terlalu pendek');

		if ($this->form_validation->run() == FALSE) {
			$dataError = [
				'error'     => true,
				'status' => 'errorValidation',
				'nama'      => form_error('namaEdit'),
				'alamat'      => form_error('alamatEdit'),
				'no_telp'  => form_error('noTelpEdit')
			];
			$this->output->set_content_type('application/json')->set_output(json_encode($dataError));
		} else {
			$id = $this->input->post('idEdit');
			$data = [
				'nama' => htmlspecialchars($this->input->post('namaEdit')),
				'alamat' => htmlspecialchars($this->input->post('alamatEdit')),
				'no_telp' => htmlspecialchars($this->input->post('noTelpEdit'))
			];

			if ($this->home->update($id, $data)) {
				$message['status'] = 'Success';
			} else {
				$message['status'] = 'Failed';
			}

			$this->output->set_content_type('application/json')->set_output(json_encode($message));
		}
	}

	public function hapus()
	{
		$id = $this->input->post('id');
		$status = $this->input->post('status');

		if ($status == 'ambilData') {
			$data = $this->home->getDataById($id);
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		} else {
			if ($this->home->delete($id) > 0) {
				$message['status'] = 'Success';
			} else {
				$message['status'] = 'Failed';
			}

			$this->output->set_content_type('application/json')->set_output(json_encode($message));
		}
	}
}