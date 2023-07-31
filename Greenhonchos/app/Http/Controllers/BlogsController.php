<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Blogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogsController extends Controller
{
    public function blogs(Request $request)
    {

        if ($request->ajax()) {
            $blogs = Blogs::select('id', 'title', 'content', 'tags', 'image');
            return DataTables::of($blogs)
                ->setTotalRecords($blogs->count())
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editPost">Edit</a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deletePost">Delete</a>';


                    return $btn;
                })

                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $validatorResponse  =  Validator::make($request->all(), [
            'id' => ['nullable', 'gt:0', 'integer'],
            'title' => ['required', 'string', 'min:10'],
            'content' => ['required', 'string', 'min:10'],
            'tags' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        if ($validatorResponse->fails()) {

            return response()->json(
                [
                    'error' => $validatorResponse->errors()->first(),
                    'status' => 'ERR'
                ]
            );
        }
        $validatedData =  $validatorResponse->getData();

        if ($image = $request->file('image')) {
            $destinationPath = 'images/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $image = "$profileImage";
        }

        Blogs::updateOrInsert(
            ['id' => $validatedData['id']],
            [
                'title' => $validatedData['title'],
                'content' => $validatedData['content'],
                'tags' => $validatedData['tags'],
                'image' => $image ?? null,
            ]
        );

        return response()->json(
            [
                'success' => 'Blog saved successfully.',
                'status' => 'TXN'
            ]
        );
    }

    public function edit($id)
    {
        $blog = Blogs::find($id);
        return response()->json($blog);
    }

    public function show($id)
    {
        $blog = Blogs::find($id);
        return view('blogs.show', compact('blog'));
    }
    public function destroy($id)
    {
        Blogs::find($id)->delete();

        return response()->json(['success' => 'Blog deleted successfully.']);
    }
}