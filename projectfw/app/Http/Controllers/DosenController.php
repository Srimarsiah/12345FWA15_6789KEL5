<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Dosen;
use App\Pengguna;
use App\Http\Requests\DosenRequest;
use Illuminate\Support\Facades\Input;
class DosenController extends Controller
{
	protected $informasi = 'Gagal Melakukan Aksi';
	public function awal()
	{
		$semuaDosen = Dosen::all();
		return view('dosen.awal',compact('semuaDosen'));
	}
	public function tambah()
	{
		return view('dosen.tambah');
	}
	public function simpan(Request $input)
	{$this->validate($input,[
                'nama'=>'required',
                'nip'=>'required|unique:dosen|min:10|max:10',
                'username'=>'required|unique:pengguna',
                'password'=>'required|min:6',
              	]);
		$pengguna = new Pengguna($input->only('username','password','level'));
		if($pengguna->save()){
			$dosen = new Dosen;
			$dosen->nama = $input->nama;
			$dosen->nip = $input->nip;
			$dosen->alamat = $input->alamat;
			if($pengguna->dosen()->save($dosen)) $this->informasi='Berhasil Simpan Data';	
		}		
		return redirect('dosen')->with(['informasi'=>$this->informasi]);
	}

	public function edit ($id)
	{
	$dosen=Dosen::find($id);
	return view ('dosen.edit')->with(array('dosen'=>$dosen));
	}
	public function lihat ($id)
	{
	$dosen=Dosen::find($id);
	return view ('dosen.lihat')->with(array('dosen'=>$dosen));
	}
	public function update ($id,Request $input)
	{
		$this->validate($input,[
                'nama'=>'required',
                'nip'=>'required|unique:dosen',
                'username'=>'required|unique:pengguna',
                'password'=>'required|min:6',
              	]);
		$dosen=Dosen::find($id);
		$pengguna = $dosen->pengguna;
		$dosen->nama = $input->nama;
		$dosen->nip = $input->nip;
		$dosen->alamat = $input->alamat;
		$dosen->save();
		if(!is_null($input->username)){
			$pengguna->fill($input->only('username'));
				if(!empty($input->password)){
					$pengguna->password = $input->password;
				}
					if($pengguna->save()){
					$this->informasi = 'Berhasil Simpan Data';
				}else{
					$this->informasi = 'Gagal Simpan Data';
				}	
			}
		return redirect('dosen')->with(['informasi'=>$this->informasi]);
	}
	public function hapus ($id)
	{
		$dosen=Dosen::find($id);
		if($dosen->pengguna()->delete()){
			$this->informasi = 'Berhasil Hapus Data';
		}
		return redirect('dosen')->with(['informasi'=>$this->informasi]);
	}
    
}