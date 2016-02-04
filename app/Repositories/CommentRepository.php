<?php namespace App\Repositories;

use App\Models\Comment;
use App\Models\Post;

/**
 * Class CommentRepository
 * @package     App\Repositories
 * @version     1.0.0
 * @copyright   Copyright (c) 2015-2016 forehalo <http://www.forehalo.top>
 * @author      forehalo <forehalo@gmail.com>
 * @license     http://www.gnu.org/licenses/lgpl.html   LGPL
 */
class CommentRepository
{
    /**
     * @var Comment Model
     */
    protected $model;

    /**
     * @var Post model
     */
    protected $post;

    /**
     * CommentRepository constructor.
     *
     * @param Comment $comment
     */
    public function __construct(Comment $comment, Post $post)
    {
        $this->model = $comment;
        $this->post = $post;
    }

    /**
     * Get comment by given id.
     *
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->model->find($id);
    }

    /**
     * Store a new comment.
     * @param $input
     */
    public function store($input)
    {
        $comment = new $this->model;

        $comment->post_id = $input['post_id'];
        $comment->parent_id = $input['parent'];
        // Get parent comment name.
        if ($input['parent'] != 0) {
            $comment->parent_name = $this->getById($input['parent'])->name;
        }
        $comment->name = $input['name'];
        $comment->email = $input['email'];
        $comment->blog = $input['blog'];
        $comment->content = $input['content'];

        $comment->save();

        // add on comment_count
        $post = $this->post->find($input['post_id']);
        $post->comment_count++;
        $post->save();
    }
}