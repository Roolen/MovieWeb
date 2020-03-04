<?php namespace App\Models;

use CodeIgniter\Model;

class PostsModel extends Model
{
    protected $table = 'posts';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_author',
        'rating',
        'title',
        'path_image',
        'is_scetch',
        'text_post'
    ];

    /**
     * Получить данные поста.
     *
     * @param string $title заголовок поста
     * @return array|bool массив с данными поста или false, где данные:
     * 'id', 'id_author', 'rating', 'title', 'path_image', 'is_scetch',
     * 'text_post', 'date_publish'
     */
    public function getPost(string $title)
    {
        $post = $this->asArray()
                     ->where(['title' => $title])
                     ->first();

        return ($post)
               ? $post
               : false;
    }

    /**
     * Получить данные всех постов автора.
     *
     * @param integer $id id автора
     * @return array массив с данными постов, где:
     * 'id_author', 'rating', 'title', 'path_image', 'is_scetch',
     * 'text_post', 'date_publish', 'isImage'
     */
    public function getPosts(int $idAuthor)
    {
        $posts = $this->asArray()
                      ->where(['id_author' => $idAuthor])
                      ->findAll();

        if ($posts) {
            for ($i = 0; $i < count($posts); $i++) {
                $post = &$posts[$i];
                unset($post['id']);
                $post['isImage'] = ($post['path_image'])?true:false;
                if (! $post['path_image']) {
                    $post['path_image'] = base_url() . "/images/post.svg";
                }
            }

            return $posts;
        }
    }

    /**
     * Получить все посты множества авторов по их id's
     *
     * @param array $ids массив идентификаторов
     * @return array массив с данными постов, где:
     * 'id_author', 'rating', 'title', 'path_image', 'is_scetch',
     * 'text_post', 'date_publish', 'isImage'
     */
    public function getPostsByAuthors(array $ids)
    {
        $posts = $this->asArray()
                      ->whereIn('id_author', $ids)
                      ->findAll();

        if ($posts) {
            for ($i = 0; $i < count($posts); $i++) {
                $post = &$posts[$i];
                unset($post['id']);
                $post['isImage'] = ($post['path_image'])?true:false;
                if (! $post['path_image']) {
                    $post['path_image'] = base_url() . "/images/post.svg";
                }
            }

            return $posts;
        }
    }

    /**
     * Находит посты содержащие искомую строку.
     *
     * @param string $searchLine искомая строка
     * @param bool $byText осуществлять поиск по содержимому поста
     * @return array|bool массив найденых постов или false если ничего не найдено
     */
    public function searchPosts(string $searchLine, bool $byText = false)
    {
        if (mb_strlen($searchLine) < 4) {
            return false;
        }

        $findField = ($byText)
                     ? 'text_post'
                     : 'title';
        $posts = $this->asArray()
                      ->like($findField, $searchLine)
                      ->findAll();

        return ($posts)
               ? $posts
               : false;
    }

    /**
     * Создать новый пост.
     *
     * @param array $dataPost данные поста, где:
     * 'title' - заголовок
     * 'id_author' - id автора
     * 'text_post' - текст поста
     * @return array массив с флагами успешности создания поста, где:
     * 'success' - успешность создания,
     * 'isDuplicate' - заголовок поста уже занят,
     * 'idPost' - id созданного поста
     */
    public function createPost(array $dataPost)
    {
        if ($dataPost['title'] == '' ||
            $dataPost['id_author'] == '' ||
            $dataPost['text_post'] == '')
        {
                return ['success' => false, 'isEmpty' => true];
        }

        $post = $this->asArray()
                     ->where(['title' => $dataPost['title']])
                     ->first();

        if ($post) {
            return ['success' => false, 'isDuplicate' => true];
        }

        $idPost = $this->insert($dataPost);
        return ['success' => true, 'idPost' => $idPost];
    }

    /**
     * Изменить содержимое поста.
     *
     * @param string $idPost id поста
     * @param array $dataPost массив с новыми данными для поста
     * @return bool успешность изменения данных поста
     */
    public function changePost(string $idPost, array $dataPost)
    {
        $post = $this->update($idPost, $dataPost);

        return ($post)
               ? true
               : false;
    }

    /**
     * Удалить пост.
     *
     * @param integer $idPost id поста
     * @return bool успешность удаления поста
     */
    public function removePost(int $idPost)
    {
        $status = $this->delete($idPost);

        return ($status)
               ? true
               : false;
    }

    /**
     * Установить новый адрес изображения для поста.
     *
     * @param string $imagePath адрес изображения
     * @param string $titlePost заголовок поста
     * @return void
     */
    public function setImage(string $imagePath, string $titlePost)
    {
        $post = $this->asArray()
                     ->where(['title' => $titlePost])
                     ->first();

        $this->update($post['id'], ['path_image' => $imagePath]);
    }
}