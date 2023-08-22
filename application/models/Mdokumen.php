<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mdokumen extends CI_Model
{
    public function getdoc($id = null)
    {
        $query = "
            SELECT A.JUDUL, A.KETERANGAN, A.URL_FILE, B.KETERANGAN JENISDOC, A.DOC_INDEX, A.JNS_DOC, A.DOC_HEADER, A.DOC_ID, A.HEADER, A.DESKRIPSI,
            (SELECT COUNT(C.DOC_ID) FROM WEB_CO_PPID_DOCUMENT C WHERE A.DOC_ID = C.DOC_HEADER) CHILD,
            (SELECT D.KETERANGAN FROM WEB_CO_PPID_DOCUMENT D WHERE D.DOC_ID = A.DOC_HEADER) KEPALA
            FROM WEB_CO_PPID_DOCUMENT A
            LEFT JOIN WEB_CO_PPID_JNS_DOC B ON A.JNS_DOC = B.JNS_DOC
            WHERE A.AKTIF = '1'";
        if ($id) {
            $query .= "AND DOC_ID = '" . $id . "'";
        }
        $query .= "ORDER BY A.CREATED_DATE DESC";
        return $this->db->query($query);
    }
    public function getdocheaderlist($data)
    {
        $query = "
            SELECT 
            CASE
                WHEN A.DOC_INDEX IS NULL THEN '999999'
                WHEN A.HEADER =  1 THEN TO_CHAR(A.DOC_ID) || '.0'
                ELSE A.DOC_HEADER || '.' ||  TO_CHAR(A.DOC_INDEX)
                END ORDERED,
                A.DOC_HEADER,
                (SELECT KETERANGAN FROM WEB_CO_PPID_DOCUMENT WHERE DOC_ID = A.DOC_HEADER) K_HEADER,
                (SELECT DOC_INDEX FROM WEB_CO_PPID_DOCUMENT WHERE DOC_ID = A.DOC_HEADER) HEADER_INDEX,
            A.JUDUL, A.KETERANGAN, A.URL_FILE, B.KETERANGAN JENISDOC, A.DOC_ID,A.DOC_INDEX, A.HEADER,A.DESKRIPSI,
            (SELECT COUNT(C.DOC_ID) FROM WEB_CO_PPID_DOCUMENT C WHERE A.DOC_ID = C.DOC_HEADER) H_CHILD
            FROM WEB_CO_PPID_DOCUMENT A
            LEFT JOIN WEB_CO_PPID_JNS_DOC B ON A.JNS_DOC = B.JNS_DOC
            WHERE A.AKTIF = '1'
            AND A.DOC_HEADER IS NULL
            HAVING H_CHILD > '0'
            --AND A.KETERANGAN LIKE '%" . $data['ket'] . "%'
            --AND A.JNS_DOC LIKE '%" . $data['jenis'] . "%'
            --AND (A.DOC_ID = '47' OR DOC_HEADER = '47')
            ORDER BY LPAD(ORDERED,200) ASC
        ";
        return $this->db->query($query);
    }
    public function getdocchildlist($data)
    {
        $query = "
            SELECT A.JUDUL, A.KETERANGAN, A.URL_FILE, B.KETERANGAN JENISDOC, A.DOC_ID, A.DOC_INDEX, A.HEADER,A.DESKRIPSI
            FROM WEB_CO_PPID_DOCUMENT A
            LEFT JOIN WEB_CO_PPID_JNS_DOC B ON A.JNS_DOC = B.JNS_DOC
            WHERE A.AKTIF = '1'
            AND A.DOC_HEADER = '" . $data['DOC_ID'] . "'
            AND A.KETERANGAN LIKE '%" . $data['ket'] . "%'
            AND A.JNS_DOC LIKE '%" . $data['jenis'] . "%'
            ORDER BY LPAD(A.DOC_INDEX,200) ASC
        ";
        return $this->db->query($query);
    }
    public function getdocheader($jenisdok)
    {
        $query = "
            SELECT A.DOC_ID, A.KETERANGAN, A.DOC_INDEX
            FROM WEB_CO_PPID_DOCUMENT A
            WHERE A.AKTIF = '1'
            AND HEADER = '1'
            AND A.JNS_DOC = '" . $jenisdok . "'
            ORDER BY DOC_INDEX ASC
        ";
        return $this->db->query($query);
    }
    public function getjnsdoc()
    {
        $query = "
            SELECT JNS_DOC, KETERANGAN
            FROM WEB_CO_PPID_JNS_DOC";
        return $this->db->query($query);
    }
    public function insert($table, $data)
    {
        foreach ($data as $i => $d) {
            if (strpos($d, 'TO_DATE') !== false || strpos($d, 'SYSDATE') !== false) {
                $this->db->set($i, $d, false);
            } else {
                $this->db->set($i, $d);
            }
        }
        return $this->db->insert($table);
    }
    public function update($table, $data, $where)
    {
        foreach ($data as $i => $d) {
            if (strpos($d, 'TO_DATE') !== false || strpos($d, 'SYSDATE') !== false) {
                $this->db->set($i, $d, false);
            } else {
                $this->db->set($i, $d);
            }
        }
        $this->db->where($where);
        return $this->db->update($table);
    }
    public function kodeoto($table, $field, $panjang = null, $awalan = null)
    {
        if ($awalan) {
            $awalanlength = strlen($awalan);
            $query = $this->db->query("SELECT $field F FROM (SELECT $field FROM $table ORDER BY $field DESC) WHERE SUBSTR($field,1,$awalanlength) = '" . $awalan . "' AND ROWNUM=1");
        } else {
            $query = $this->db->query("SELECT $field F FROM (SELECT $field FROM $table ORDER BY $field DESC) WHERE ROWNUM=1");
        }
        $row = $query->num_rows();
        $data = $query->row();
        if ($row > 0) {
            $kode = intval($data->F) + 1;
        } else {
            $kode = 1;
        }
        $batas = str_pad($kode, $panjang, "0", STR_PAD_LEFT);
        $kodetampil = $awalan . $batas;
        return $kodetampil;
    }
}
