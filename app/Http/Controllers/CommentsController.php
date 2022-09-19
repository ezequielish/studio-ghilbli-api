<?php

namespace App\Http\Controllers;

use App\Models\CommentModel;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class CommentsController extends Controller
{

    private function validate_fk(array $inputs)
    {
        $user_exist = User::find($inputs['user_id']);

        if (isset($inputs['id_comment_parent'])) {

            $comment_exist = CommentModel::find($inputs['id_comment_parent']);
            if (empty($comment_exist)) {
                throw new Exception('comment no exists', 400);
            }

        }

        if (empty($user_exist)) {
            throw new Exception('user no exists', 400);
        }
    }
    protected function create(array $values)
    {
        try {
            $model = new CommentModel();
            $model->comment = $values['comment'];
            $model->id_film = $values['id_film'];
            $model->user_id = $values['user_id'];
            if (!empty($values['id_comment_parent'])) {
                $model->id_comment_parent = $values['id_comment_parent'];
            }
            $model->save();

            return true;
        } catch (\Throwable$th) {
            throw new Exception($th->getMessage(), 500);
        }

    }

    public function add(Request $request)
    {

        try {
            $inputs = $request->all();
            $request->validate([
                'comment' => 'required|max:255',
                'id_film' => 'required|max:255',
                'user_id' => 'required|numeric',
                'id_comment_parent' => 'numeric',
            ]);

            $data = [
                'comment' => $inputs['comment'],
                'id_film' => $inputs['id_film'],
                'user_id' => intval($inputs['user_id']),
                'id_comment_parent' => isset($inputs['id_comment_parent']) ? $inputs['id_comment_parent'] : null,
            ];

            $this->validate_fk($inputs);
            $created = $this->create($data);

            if ($created) {
                return response()->json([
                    'error' => false,
                    'message' => 'Comment created successfully',
                    'data' => $data,
                ], 201);
            }
        } catch (\Throwable$th) {
            throw $th;
        }

    }

    public function get(Request $request, String $id_film)
    {

        try {
            $comments = CommentModel::where('id_film', $id_film)->get();
            foreach ($comments as $comment) {
                $comment->user;
            }

            return response()->json([
                'error' => false,
                'message' => 'OK',
                'data' => $comments,
            ], 200);

        } catch (\Throwable$th) {
            throw $th;
        }
    }

    public function update(Request $request, Int $id_comment)
    {

        try {

            $inputs = $request->all();

            if (

                (
                    isset($inputs['comment']) &&
                    empty($inputs['comment']) &&
                    strlen($inputs['comment']) > 0
                )
                ||
                !isset($inputs['comment'])) {
                throw new Exception('empty comment', 400);
            }

            $new_comment = $inputs['comment'];

            $comment = CommentModel::find($id_comment);
            if (empty($comment)) {
                throw new Exception('comment no exists', 400);
            }

            $comment->comment = $new_comment;
            $comment->save();

            $comment->user;

            return response()->json([
                'error' => false,
                'message' => 'OK',
                'data' => $comment,
            ], 200);

        } catch (\Throwable$th) {
            throw $th;
        }
    }

    public function comment_delete(Int $id_comment)
    {

        try {
            $comment = CommentModel::find($id_comment);
            if (empty($comment)) {
                throw new Exception('comment no exists', 400);
            }

            $comment->delete();

            return response()->json([
                'error' => false,
                'message' => 'deleted comment',
            ], 200);
        } catch (\Throwable$th) {
            throw $th;
        }

    }

}
