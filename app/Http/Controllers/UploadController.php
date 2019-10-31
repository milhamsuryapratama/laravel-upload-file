<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Gambar;
// use SebastianBergmann\CodeCoverage\Node\File;
use File;

class UploadController extends Controller
{
    public function upload(){
		$gambar = Gambar::get();
		return view('upload',['gambar' => $gambar]);
    }

    public function proses_upload(Request $request) {
        $this->validate($request, [
            'file' => 'required',
            'keterangan' => 'required'
        ]);

        $file = $request->file('file');

        $nama_file = $file->getClientOriginalName();

        // echo 'File Extension: '. $file->getClientOriginalExtension();
        // echo '<br/>';

        // echo 'File real path: '. $file->getRealPath();
        // echo '<br/>';

        // echo 'File mime type: '. $file->getMimeType();

        $tujuan_folder = 'data_file';

        $file->move($tujuan_folder, $nama_file);

        Gambar::create([
            'file' => $nama_file,
			'keterangan' => $request->keterangan
        ]);

        return redirect()->back();
    }

    public function hapus($id)
    {
        $getId = Gambar::find($id);
        File::delete('data_file/'.$getId->file);
        $hapus = Gambar::where('id', $id)->delete();

        return redirect()->back();
    }
}
