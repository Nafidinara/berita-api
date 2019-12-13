<?php

namespace App\Http\Controllers;

use App\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $newss = News::all();
        foreach($newss as $news){
            $news->view_news=[
                'href' => 'api/v1/news/'.$news->id,
                'method' => 'GET'
            ];
        }
        $response=[
            'msg' => 'List of All News',
            'data' => $newss
        ];
        //response
        return response()->json($response,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'judul_berita' => 'required',
            'gambar_berita' => 'required',
            'deskripsi_berita' => 'required',
            'kategori_berita' => 'required',
        ]);

        $judul_berita = $request->input('judul_berita');
        $gambar_berita = $request->input('gambar_berita');
        $deskripsi_berita = $request->input('deskripsi_berita');
        $kategori_berita = $request->input('kategori_berita');

        $news = new News([
            'judul_berita' => $judul_berita,
            'gambar_berita' => $gambar_berita,
            'deskripsi_berita' => $deskripsi_berita,
            'kategori_berita' => $kategori_berita,
        ]);

        if($news->save()){
            $news->view_news =[
                'href' => 'api/v1/news/'.$news->id,
                'method' => 'GET'
            ];
            $succes =[
                'msg' => 'News Created!',
                'data' => $news
            ];
            //response if success input data
            return response()->json($succes,201);
        }

        $failed =[
            'msg' => 'Failed Create News'
        ];

        return response()->json($failed,404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $news = News::find($id);
        $news->view_news =[
            'href' => 'api/v1/news',
            'method' => 'GET'
        ];
        $response=[
            'msg' => 'News Information',
            'data' => $news
        ];
        return response()->json($response,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'judul_berita' => 'required',
            'gambar_berita' => 'required',
            'deskripsi_berita' => 'required',
            'kategori_berita' => 'required',
        ]);

        $judul_berita = $request->input('judul_berita');
        $gambar_berita = $request->input('gambar_berita');
        $deskripsi_berita = $request->input('deskripsi_berita');
        $kategori_berita = $request->input('kategori_berita');

        $news = News::find($id);

        $news->judul_berita = $judul_berita;
        $news->gambar_berita = $gambar_berita;
        $news->deskripsi_berita = $deskripsi_berita;
        $news->kategori_berita = $kategori_berita;

        if(!$news->update()){
            return response()->json([
                'msg'=>'gagal update'
            ],404);
        }
        $news->view_news=[
            'href'=>'api/v1/news'.$news->id,
            'method' => 'GET'
        ];
        $response=[
            'msg' => 'Succes update',
            'meeting' => $news
        ];
        return response()->json($response,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $news = News::find($id);

        if(!$news->delete()){
            return response()->json([
                'msg'=>'delete failed'
            ],404);
        }

        $response=[
            'msg' => 'succes deleted',
            'href' => 'api/v1/news',
            'method' => 'POST',
            'params' => 'judul_berita,gambar_berita,deskripsi_berita,kategori_berita'
        ];
        return response()->json($response,200);
    }

    public function searchJudul(Request $request){
        $data = $request->input('judul_berita');
        $news = News::where('judul_berita','like',"%{$data}%")->get();

        if(count($news)<=0){
            return response()->json([
                'msg'=>'data not found',
                'code' => 404,
                'status' => 'error'
            ],404);
        }

            return response()->json([
                'msg'=>'we found it',
                'code' => 200,
                'status' => 'succes',
                'data' => $news
            ],200);
    }

    public function searchKategori(Request $request){
        $data = $request->input('kategori_berita');
        $news = News::where('kategori_berita','like',"%{$data}%")->get();

        if(count($news)<=0){
            return response()->json([
                'msg'=>'data not found',
                'code' => 404,
                'status' => 'error'
            ],404);
        }

            return response()->json([
                'msg'=>'we found it',
                'code' => 200,
                'status' => 'succes',
                'data' => $news
            ],200);
    }
}