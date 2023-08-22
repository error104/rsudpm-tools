<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dokumen extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'mdokumen' => 'md'
        ]);
    }
    public function index()
    {

        $data['jnsdoc'] = $this->md->getjnsdoc()->result();
        $content = $this->load->view('dokumen/index', $data, true);
        $data['contentBody'] = $content;
        $this->load->view('layout', $data);
    }
    public function editdoc()
    {
        $data['doc'] = $this->md->getdoc($this->input->post('id'))->row();
        $data['jnsdoc'] = $this->md->getjnsdoc()->result();
        $this->load->view('dokumen/edit', $data);
    }
    public function insertdok()
    {
        $docid = $this->md->kodeoto('WEB_CO_PPID_DOCUMENT', 'DOC_ID');
        $data = [
            'DOC_ID' => $docid,
            'JNS_DOC' => $this->input->post('jenisdok'),
            'KETERANGAN' => $this->input->post('keterangan'),
            'URL_FILE' => $this->input->post('url'),
            'DOC_HEADER' => !$this->input->post('header') ? $this->input->post('headerdok') : '',
            'DOC_INDEX' => $this->input->post('index'),
            'HEADER' => $this->input->post('header'),
            'DESKRIPSI' => $this->input->post('deskripsi')
        ];
        $this->md->insert('WEB_CO_PPID_DOCUMENT', $data);
    }
    public function getdocheader()
    {
        $jenis = $this->input->post('jenis');
        $data = $this->md->getdocheader($jenis)->result();
        //$items = [];
        foreach ($data as $d) {
            echo "<option value='" . $d->DOC_ID . "' data-val>" . $d->DOC_INDEX . '. ' . $d->KETERANGAN . "</option>";
        }
    }
    public function data()
    {
        $data['ket'] = $this->input->post('ket');
        $data['jenis'] = $this->input->post('jenis');
        $data['doc'] = $this->md->getdocheaderlist($data)->result();
        $this->load->view('dokumen/data', $data);
    }
    public function updatedok()
    {
        $docid = $this->input->post('id');
        $data = [
            'JNS_DOC' => $this->input->post('jenisdok'),
            'KETERANGAN' => $this->input->post('keterangan'),
            'URL_FILE' => $this->input->post('url'),
            'DOC_HEADER' => !$this->input->post('header') ? $this->input->post('headerdok') : '',
            'DOC_INDEX' => $this->input->post('index'),
            'HEADER' => $this->input->post('header'),
            'DESKRIPSI' => $this->input->post('deskripsi')
        ];
        $this->md->update('WEB_CO_PPID_DOCUMENT', $data, ['DOC_ID' => $docid]);
    }
}
