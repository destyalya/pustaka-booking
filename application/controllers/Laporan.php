<?php
defined('BASEPATH') or exit('No Direct script access allowed');


class Laporan extends CI_Controller 
{
    function construct()
    {
        parent::construct();
    }

    public function laporan_buku()
    {
        $data['judul'] = 'Laporan Data Buku';
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
        $data['buku'] = $this->ModelBuku->getBuku()->result_array();
        $data['kategori'] = $this->ModelBuku->getKategori()->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('buku/laporan_buku', $data);
        $this->load->view('templates/footer');
    }

    public function cetak_laporan_buku()
    {
        $data['buku'] = $this->ModelBuku->getBuku()->result_array();
        $data['kategori'] = $this->ModelBuku->getKategori()->result_Array();

        $this->load->view('buku/laporan_print_buku', $data);
    }

    public function laporan_buku_pdf()
    {
       
        $data['buku'] = $this->ModelBuku->getBuku()->result_array();

        $this->load->library('pdf');

        $paper_size = 'A4'; // ukuran kertas
        $orientation = 'landscape'; //tipe format kertas potrait atau landscape

        
        $this->pdf->setPaper($paper_size, $orientation);
        //Convert to PDF
        $this->pdf->filename = "laporan_data_buku.pdf";
        //nama file pdf yang dihasilkan
        $this->pdf->load_view('buku/laporan_pdf_buku', $data);
        
    }

    public function export_excel()
    {
        $data = ['title' => 'Laporan Buku',
                'buku' => $this->ModelBuku->getBuku()->result_array()];
        $this->load->view('buku/export_excel_buku', $data);
    }

    public function laporan_pinjam(){
		$data['judul'] = 'Laporan Data Peminjaman';
		$data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
 		$data['laporan'] = $this->db->query("select * from pinjam p,detail_pinjam d, buku b,user u where d.id_buku=b.id and p.id_user=u.id and p.no_pinjam=d.no_pinjam")->result_array();

		$this->load->view('templates/header', $data);
 		$this->load->view('templates/sidebar');
 		$this->load->view('templates/topbar', $data);
 		$this->load->view('pinjam/laporan-pinjam', $data);
 		$this->load->view('templates/footer');
	}

    public function cetak_laporan_pinjam(){
    	$data['laporan'] = $this->db->query("select * from pinjam p,detail_pinjam d, buku b,user u where d.id_buku=b.id and p.id_user=u.id and p.no_pinjam=d.no_pinjam")->result_array();
		$this->load->view('pinjam/laporan-print-pinjam', $data);
    }

    public function laporan_pinjam_pdf(){
    	
 
		$data['laporan'] = $this->db->query("select * from pinjam p,detail_pinjam d, buku b,user u where d.id_buku=b.id and p.id_user=u.id and p.no_pinjam=d.no_pinjam")->result_array();
		
		$root = $_SERVER['DOCUMENT_ROOT'];
        include $root."/pustaka-booking/application/third_party/dompdf/autoload.inc.php";
        $dompdf = new Dompdf\Dompdf();
		$this->load->view('pinjam/laporan-pdf-pinjam', $data);
 
		$paper_size = 'A4'; // ukuran kertas
		$orientation = 'landscape'; //tipe format kertas potrait atau landscape
		$html = $this->output->get_output();
 
		$dompdf->set_paper($paper_size, $orientation);
		//Convert to PDF
		$dompdf->load_html($html);
		$dompdf->render();
		ob_end_clean();
		$dompdf->stream("laporan data peminjaman.pdf", array('Attachment' => 0));
    }

    public function export_excel_pinjam(){
    	$data = array(
    		'title' => 'Laporan Data Peminjaman Buku',
    		'laporan' => $this->db->query("select * from pinjam p,detail_pinjam d, buku b,user u where d.id_buku=b.id and p.id_user=u.id and p.no_pinjam=d.no_pinjam")->result_array()
    	);
		$this->load->view('pinjam/export-excel-pinjam', $data);
    }

    public function laporan_anggota()
    {
        $data['judul'] = 'Laporan Data Anggota';
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
        $this->db->where('role_id', 1);
        $data['anggota'] = $this->db->get('user')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('member/laporan_anggota', $data);
        $this->load->view('templates/footer');
    }

    public function cetak_laporan_anggota()
    {
        $data['anggota'] = $this->db->get('user')->result_array();
        $this->load->view('member/laporan_print_anggota', $data);
    }

    public function laporan_anggota_pdf()
    {
       
        $data['anggota'] = $this->db->get('user')->result_array();
        $this->load->library('pdf');

        $paper_size = 'A4'; // ukuran kertas
        $orientation = 'landscape'; //tipe format kertas potrait atau landscape

        
        $this->pdf->setPaper($paper_size, $orientation);
        //Convert to PDF
        $this->pdf->filename = "laporan_data_anggota.pdf";
        //nama file pdf yang dihasilkan
        $this->pdf->load_view('member/laporan_pdf_anggota', $data);
        
    }

    public function export_excel_anggota()
    {
        $data = ['title' => 'laporan_anggota',
                'anggota' => $this->db->get('user')->result_array()];
        $this->load->view('member/export_excel_anggota', $data);
    }

   
}